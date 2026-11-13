<?php
// Kegunaan file: Mengelola data pilar layanan yang tampil di halaman publik.

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    // Tampilkan daftar pilar dan sediakan pencarian berdasarkan nama, slug, atau kategori.
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $services = Service::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.services.index', compact('services', 'search'));
    }

    // Tampilkan formulir untuk membuat pilar layanan baru.
    public function create()
    {
        return view('admin.services.create');
    }

    // Validasi data pilar lalu simpan sebagai layanan di database.
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:services,slug'],
            'category' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'features' => ['nullable', 'string', 'max:4000'],
            'is_active' => ['required', 'boolean'],
        ]);

        $data['features'] = $this->parseFeatures($data['features'] ?? null);
        $data['slug'] = filled($data['slug'] ?? null)
            ? Str::slug($data['slug'])
            : Str::slug($data['name']);

        if (Service::where('slug', $data['slug'])->exists()) {
            return back()->withErrors([
                'slug' => 'Slug sudah digunakan. Gunakan slug lain.',
            ])->withInput();
        }

        Service::create($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    // Tampilkan formulir dengan data pilar yang akan diedit.
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    // Perbarui informasi pilar yang dipilih admin.
    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('services', 'slug')->ignore($service->id),
            ],
            'category' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'features' => ['nullable', 'string', 'max:4000'],
            'is_active' => ['required', 'boolean'],
        ]);

        $data['features'] = $this->parseFeatures($data['features'] ?? null);
        $data['slug'] = filled($data['slug'] ?? null)
            ? Str::slug($data['slug'])
            : Str::slug($data['name']);

        if (
            Service::where('slug', $data['slug'])
                ->where('id', '!=', $service->id)
                ->exists()
        ) {
            return back()->withErrors([
                'slug' => 'Slug sudah digunakan. Gunakan slug lain.',
            ])->withInput();
        }

        $service->update($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    // Hapus pilar layanan dari database.
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }

    // Pisahkan daftar fitur dari teks menjadi array untuk disimpan sebagai JSON.
    private function parseFeatures(?string $features): ?array
    {
        $items = collect(preg_split('/\r\n|\r|\n/', $features ?? ''))
            ->map(fn (string $feature) => trim($feature))
            ->filter()
            ->values()
            ->all();

        return $items === [] ? null : $items;
    }
}
