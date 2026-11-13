<?php
// Kegunaan file: Memvalidasi formulir konsultasi, menyimpan permintaan, dan memberi konfirmasi.

namespace App\Http\Controllers;
use App\Models\ProjectConsultation;
use Illuminate\Http\Request;

class ProjectConsultationController extends Controller
{
    // Periksa isian formulir, simpan konsultasi yang valid, lalu beri konfirmasi.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'company' => ['nullable', 'string', 'max:255'],
            'service' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ProjectConsultation::create($validated);

        return back()->with(
            'success',
            'Konsultasi berhasil dikirim!'
        );
    }
}
