<?php
// Kegunaan file: Mengelola katalog produk admin, validasi data, serta penyimpanan gambarnya.

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use RuntimeException;

class ProductController extends Controller
{
    // Tampilkan daftar produk dan saring berdasarkan nama atau slug.
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $products = Product::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'search'));
    }

    // Tampilkan formulir produk baru.
    public function create()
    {
        return view('admin.products.create');
    }

    // Validasi lalu simpan produk baru, termasuk gambar jika diunggah.
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'image_2' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'image_file_2' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'is_active' => ['required', 'boolean'],
        ]);
        unset($data['image_file'], $data['image_file_2']);

        $data['slug'] = filled($data['slug'] ?? null)
            ? Str::slug($data['slug'])
            : Str::slug($data['name']);

        if (Product::where('slug', $data['slug'])->exists()) {
            return back()->withErrors([
                'slug' => 'Slug sudah digunakan. Silakan pilih nama atau slug lain.',
            ])->withInput();
        }

        if ($request->hasFile('image_file')) {
            $data['image'] = $this->storeProductImage($request);
        }

        if ($request->hasFile('image_file_2')) {
            $data['image_2'] = $this->storeProductImage($request, 'image_file_2');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    // Tampilkan formulir dengan data produk yang akan diedit.
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // Perbarui data dan gambar produk yang sudah ada.
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => ['required', 
            'string', 'max:255'],
            'slug' => [
                'nullable', 'string', 'max:255',
                Rule::unique('products', 'slug')->ignore($product->id),
            ],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'image_2' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'image_file_2' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'remove_image_2' => ['nullable', 'boolean'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'is_active' => ['required', 'boolean'],
        ]);
        unset($data['image_file'], $data['image_file_2'], $data['remove_image_2']);

        $data['slug'] = filled($data['slug'] ?? null)
            ? Str::slug($data['slug'])
            : Str::slug($data['name']);
            
        if (
            Product::where('slug', $data['slug'])
                ->where('id', '!=', $product->id)
                ->exists()
        ) {
            return back()->withErrors([
                'slug' => 'Slug sudah digunakan. Silakan pilih nama atau slug lain.',
            ])->withInput();
        }

        $previousImage = $product->image;
        $previousImage2 = $product->image_2;
        if ($request->hasFile('image_file')) {
            $data['image'] = $this->storeProductImage($request);
        }

        if ($request->boolean('remove_image_2')) {
            $data['image_2'] = null;
        } elseif ($request->hasFile('image_file_2')) {
            $data['image_2'] = $this->storeProductImage($request, 'image_file_2');
        }

        $product->update($data);

        if ($request->hasFile('image_file') && Str::startsWith($previousImage ?? '', 'products/')) {
            $this->deleteProductImage($previousImage);
        }

        if (
            ($request->boolean('remove_image_2') || $request->hasFile('image_file_2'))
            && Str::startsWith($previousImage2 ?? '', 'products/')
        ) {
            $this->deleteProductImage($previousImage2);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    // Hapus gambar yang diunggah dan data produk dari database.
    public function destroy(Product $product)
    {
        if (Str::startsWith($product->image ?? '', 'products/')) {
            $this->deleteProductImage($product->image);
        }

        if (Str::startsWith($product->image_2 ?? '', 'products/')) {
            $this->deleteProductImage($product->image_2);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    // Simpan gambar unggahan ke penyimpanan publik dan kembalikan lokasinya.
    private function storeProductImage(Request $request, string $field = 'image_file'): string
    {
        $path = $request->file($field)->storePublicly('products', 'public');

        if ($path === false) {
            throw new RuntimeException('Gambar produk gagal disimpan ke penyimpanan publik.');
        }

        return $path;
    }

    // Hapus gambar lama dari penyimpanan publik; laporkan jika gagal.
    private function deleteProductImage(string $path): void
    {
        if (! Storage::disk('public')->delete($path)) {
            throw new RuntimeException('Gambar produk lama gagal dihapus dari penyimpanan publik.');
        }
    }
}
