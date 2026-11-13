<?php
// Kegunaan file: Berisi pengujian otomatis untuk memastikan perilaku aplikasi berjalan sesuai harapan.

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\PillarSeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicProductsTest extends TestCase
{
    use RefreshDatabase;

    // Siapkan data awal yang diperlukan sebelum pengujian fitur dijalankan.

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            PillarSeeder::class,
            ProductSeeder::class,
        ]);
    }

    // Memastikan produk awal ditampilkan dari database.

    public function test_seeded_products_are_rendered_from_the_database(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('SMaart Sakpu')
            ->assertSee('Collaborative AI')
            ->assertSee('SMaart Channel')
            ->assertSee('SMaart POS')
            ->assertSee('SMaart HR');
    }

    // Memastikan formulir produk admin dapat memilih dan melihat pratinjau gambar.

    public function test_admin_product_forms_allow_selecting_and_previewing_images(): void
    {
        $admin = User::factory()->create();
        $product = Product::where('slug', 'smaart-sakpu')->firstOrFail();

        $this->actingAs($admin)
            ->get(route('admin.products.create'))
            ->assertOk()
            ->assertSee('enctype="multipart/form-data"', false)
            ->assertSee('name="image_file"', false)
            ->assertSee('name="image_file_2"', false)
            ->assertSee('type="file"', false);

        $this->get(route('admin.products.edit', $product))
            ->assertOk()
            ->assertSee('name="image_file"', false)
            ->assertSee('name="image_file_2"', false)
            ->assertSee('Ganti gambar produk')
            ->assertSee('Gambar SMaart Sakpu');
    }

    // Memastikan produk aktif tampil dan produk nonaktif disembunyikan.

    public function test_products_added_in_admin_are_published_and_inactive_products_are_hidden(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->post(route('admin.products.store'), [
                'name' => 'Produk Baru',
                'slug' => 'produk-baru',
                'tagline' => 'Solusi baru',
                'description' => 'Deskripsi produk baru.',
                'image' => '',
                'image_file' => $this->fakeProductImage(),
                'website_url' => '',
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('success');

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Produk Baru')
            ->assertSee('Deskripsi produk baru.')
            ->assertSee('/storage/products/');

        $product = Product::where('slug', 'produk-baru')->firstOrFail();
        Storage::disk('public')->assertExists($product->image);
        $this->assertSame('/storage/'.$product->image, $product->image_url);
        $product->update(['is_active' => false]);

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('Produk Baru')
            ->assertSee('SMaart Sakpu');
    }

    // Memastikan gambar produk dapat diganti dan gambar lama dibersihkan.

    public function test_admin_can_replace_a_product_image_and_removes_the_old_upload(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('products/old.png', 'old-image');
        $product = Product::where('slug', 'smaart-sakpu')->firstOrFail();
        $product->update(['image' => 'products/old.png']);

        $this->actingAs(User::factory()->create())
            ->put(route('admin.products.update', $product), [
                'name' => $product->name,
                'slug' => $product->slug,
                'tagline' => $product->tagline,
                'description' => $product->description,
                'image' => $product->image,
                'image_file' => $this->fakeProductImage(),
                'website_url' => '',
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('success');

        $product->refresh();
        $this->assertNotSame('products/old.png', $product->image);
        Storage::disk('public')->assertExists($product->image);
        Storage::disk('public')->assertMissing('products/old.png');
    }

    // Memastikan gambar kedua opsional dan tampil sebagai slide jika tersedia.

    public function test_second_product_image_is_optional_and_is_rendered_as_a_slide_when_present(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->post(route('admin.products.store'), [
                'name' => 'SMaart Event',
                'slug' => 'smaart-event',
                'tagline' => 'Manajemen event',
                'description' => 'Solusi pengelolaan acara.',
                'image_file' => $this->fakeProductImage(),
                'image_file_2' => $this->fakeProductImage(),
                'website_url' => '',
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('success');

        $product = Product::where('slug', 'smaart-event')->firstOrFail();
        Storage::disk('public')->assertExists($product->image);
        Storage::disk('public')->assertExists($product->image_2);
        $this->assertNotNull($product->image_2_url);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('home-product-preview home-product-slideshow', false)
            ->assertSee('Galeri foto SMaart Event', false)
            ->assertSee('SMaart Event - foto 2')
            ->assertDontSee('home-product-slide-controls', false);
    }

    // Memastikan kontrol slide tidak tampil jika gambar kedua tidak ada.

    public function test_product_without_second_image_does_not_render_slideshow_controls(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('home-product-slideshow', false)
            ->assertDontSee('home-product-slide-controls', false);
    }

    // Memastikan admin dapat menghapus gambar kedua produk.

    public function test_admin_can_remove_a_products_second_image(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('products/second-photo.png', 'second-photo');
        $product = Product::where('slug', 'smaart-sakpu')->firstOrFail();
        $product->update(['image_2' => 'products/second-photo.png']);

        $this->actingAs(User::factory()->create())
            ->put(route('admin.products.update', $product), [
                'name' => $product->name,
                'slug' => $product->slug,
                'tagline' => $product->tagline,
                'description' => $product->description,
                'image' => $product->image,
                'image_2' => $product->image_2,
                'remove_image_2' => '1',
                'website_url' => '',
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('success');

        $this->assertNull($product->fresh()->image_2);
        Storage::disk('public')->assertMissing('products/second-photo.png');
    }

    // Buat gambar contoh untuk menguji unggah gambar produk.

    private function fakeProductImage(): UploadedFile
    {
        return UploadedFile::fake()->createWithContent(
            'product.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII='),
        );
    }
}
