<?php
// Kegunaan file: Menyiapkan ringkasan dashboard dan daftar permintaan konsultasi untuk admin.

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProjectConsultation;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    // Siapkan angka ringkasan dan konsultasi terbaru untuk dashboard admin.
    public function index(): View
    {
        return view('admin.dashboard', [
            'productCount' => Product::count(),
            'activeProductCount' => Product::where('is_active', true)->count(),
            'serviceCount' => Service::where('is_active', true)->count(),
            'consultationCount' => ProjectConsultation::count(),
            'recentConsultations' => ProjectConsultation::latest()->limit(5)->get(),
        ]);
    }

    // Cari konsultasi berdasarkan nama, email, perusahaan, atau layanan.
    public function consultations(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $consultations = ProjectConsultation::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('service', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.consultations.index', compact('consultations', 'search'));
    }

    // Tampilkan informasi pengaturan yang tersedia untuk admin.
    public function settings(): View
    {
        return view('admin.settings.index');
    }
}
