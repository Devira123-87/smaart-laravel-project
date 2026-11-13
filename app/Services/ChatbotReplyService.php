<?php
// Kegunaan file: Memilih jawaban chat dari kata kunci dan data produk/layanan aktif.

namespace App\Services;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Str;

class ChatbotReplyService
{
    // Pilih jawaban berdasarkan kata kunci; jawaban ini bukan dari layanan AI eksternal.
    public function reply(string $message): array
    {
        $query = Str::lower(Str::ascii($message));

        if ($this->containsAny($query, ['admin', 'manusia', 'petugas', 'customer service', 'cs', 'bicara dengan orang', 'hubungkan ke tim'])) {
            return [
                'reply' => 'Baik, saya teruskan percakapan ini ke tim SMAART. Silakan tuliskan kebutuhan Anda; admin akan membalas melalui chat ini.',
                'handoff' => true,
            ];
        }

        if ($this->containsAny($query, ['kontak', 'hubungi', 'alamat', 'email', 'telepon', 'nomor'])) {
            return [
                'reply' => 'Anda dapat menghubungi tim SMAART melalui info@smaart.id atau telepon +62 251 3102030. Alamat kami di Jl. Farmasi II Blok BG No 4, Bogor 16111.',
                'handoff' => false,
            ];
        }

        foreach (Product::query()->where('is_active', true)->get(['name', 'tagline', 'description']) as $product) {
            $name = Str::lower(Str::ascii($product->name));

            if ($name !== '' && Str::contains($query, $name)) {
                return [
                    'reply' => trim($product->name.($product->tagline ? ' — '.$product->tagline : '').'. '.$product->description),
                    'handoff' => false,
                ];
            }
        }

        if ($this->containsAny($query, ['produk', 'aplikasi', 'sakpu', 'channel', 'pos', 'hr'])) {
            $products = Product::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->pluck('name');

            return [
                'reply' => $products->isEmpty()
                    ? 'Informasi produk sedang disiapkan. Untuk detail, silakan hubungi info@smaart.id atau +62 251 3102030.'
                    : 'Produk unggulan SMAART saat ini: '.$products->join(', ').'. Tanyakan nama produk untuk mengetahui detailnya.',
                'handoff' => false,
            ];
        }

        if ($this->containsAny($query, ['layanan', 'jasa', 'pilar', 'pelatihan', 'bnsp', 'mice', 'event', 'cloud', 'hosting', 'website', 'web', 'mobile', 'erp', 'hris'])) {
            $services = Service::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['name', 'features']);

            if ($services->isEmpty()) {
                return [
                    'reply' => 'Informasi layanan sedang disiapkan. Silakan hubungi info@smaart.id atau +62 251 3102030 untuk bantuan.',
                    'handoff' => false,
                ];
            }

            $details = $services->map(function (Service $service) {
                $features = collect($service->features ?? [])->filter()->take(5);

                return $service->name.($features->isNotEmpty() ? ' ('.$features->join(', ').')' : '');
            });

            return [
                'reply' => 'Layanan SMAART meliputi: '.$details->join('; ').'. Jika Anda ceritakan kebutuhan, saya bantu arahkan.',
                'handoff' => false,
            ];
        }

        if ($this->containsAny($query, ['halo', 'hai', 'hello', 'selamat pagi', 'selamat siang', 'selamat sore', 'selamat malam'])) {
            return [
                'reply' => 'Halo! Saya asisten otomatis SMAART. Saya bisa membantu memberi informasi tentang layanan, produk, dan kontak. Anda juga dapat meminta bantuan admin kapan saja.',
                'handoff' => false,
            ];
        }

        return [
            'reply' => 'Maaf, saya belum menemukan jawaban yang tepat. Saya bisa membantu tentang layanan, produk, atau kontak SMAART. Jika perlu, tekan “Minta bantuan admin” agar tim kami dapat membantu langsung.',
            'handoff' => false,
        ];
    }

    private function containsAny(string $text, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if (Str::contains($text, Str::ascii(Str::lower($keyword)))) {
                return true;
            }
        }

        return false;
    }
}
