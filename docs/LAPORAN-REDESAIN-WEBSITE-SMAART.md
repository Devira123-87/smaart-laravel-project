# LAPORAN REDESAIN UI/UX WEBSITE PT SMAART KREASI DIGITAL

### DENGAN IMPLEMENTASI MENGGUNAKAN LARAVEL

**Disusun oleh:** [Nama Penyusun]  
**NIM/NIS:** [Nomor Induk]  
**Program Studi/Kelas:** [Program Studi/Kelas]  
**Institusi:** [Nama Institusi]  
**Tahun:** [Tahun Penyusunan]

---

## ABSTRAK

Website perusahaan berperan sebagai media informasi sekaligus sarana komunikasi dengan calon pelanggan. Laporan ini berfokus pada redesain UI/UX website PT Smaart Kreasi Digital agar penyajian informasi dan alur interaksi pengunjung lebih terarah. Analisis dilakukan terhadap tampilan, struktur informasi, alur fitur, dan implementasi website yang tersedia. Website mencakup informasi perusahaan, pilar layanan, produk digital, formulir konsultasi, fitur chat, dan area admin.

Implementasi website menggunakan PHP dan Laravel 10 pada sisi server, Blade dan HTML untuk halaman, CSS untuk tampilan, JavaScript untuk interaksi, Vite untuk pengelolaan aset, serta Eloquent dan migration untuk pengelolaan data. MySQL merupakan konfigurasi database default proyek, sementara koneksi aktif ditentukan oleh konfigurasi aplikasi. Pengujian otomatis yang dijalankan menghasilkan 27 pengujian lulus dan 1 pengujian gagal karena teks judul yang diharapkan oleh salah satu test tidak ditemukan persis pada halaman.

**Kata kunci:** UI/UX, redesain website, Laravel, company profile, pengujian fungsional.

---

## KATA PENGANTAR

Puji syukur ke hadirat Tuhan Yang Maha Esa karena laporan berjudul “Redesain UI/UX Website PT Smaart Kreasi Digital dengan Implementasi Menggunakan Laravel” ini dapat disusun. Laporan ini menjelaskan tujuan, analisis tampilan dan alur website, teknologi implementasi, fitur, serta hasil pengujian berdasarkan proyek yang tersedia.

Penulis menyadari laporan ini masih dapat disempurnakan, khususnya pada bagian identitas penyusun dan evaluasi UI/UX bersama pengguna jika evaluasi tersebut dilaksanakan. Kritik dan saran diharapkan untuk penyempurnaan laporan ini.

**[Kota], [Tanggal Penyusunan]**  
**Penyusun**

---

## DAFTAR ISI

1. [BAB I Pendahuluan](#bab-i-pendahuluan)
2. [BAB II Gambaran Umum dan Analisis Kebutuhan](#bab-ii-gambaran-umum-dan-analisis-kebutuhan)
3. [BAB III Metode dan Perancangan](#bab-iii-metode-dan-perancangan)
4. [BAB IV Implementasi dan Pengujian](#bab-iv-implementasi-dan-pengujian)
5. [BAB V Penutup](#bab-v-penutup)
6. [Daftar Pustaka](#daftar-pustaka)

---

## BAB I PENDAHULUAN

### 1.1 Latar Belakang

Website merupakan salah satu media yang dapat digunakan perusahaan untuk menyampaikan informasi secara terstruktur dan mudah diakses. Kualitas UI/UX berpengaruh pada bagaimana pengunjung memahami isi website, menemukan informasi, serta menyelesaikan tindakan seperti meminta konsultasi atau memperoleh informasi produk. Karena itu, redesain perlu memperhatikan kebutuhan pengguna dan alasan di balik kendala yang mereka alami, bukan hanya perubahan tampilan visual.

Website PT Smaart Kreasi Digital menyajikan informasi perusahaan, pilar layanan, dan produk digital, serta menyediakan formulir konsultasi, fitur chat, dan area admin. Redesain UI/UX diarahkan pada penataan informasi dan alur interaksi website. Laravel digunakan sebagai teknologi implementasi fungsional website, bukan sebagai fokus utama pembahasan desain.

### 1.2 Rumusan Masalah

1. Bagaimana kondisi tampilan, struktur informasi, dan alur penggunaan website PT Smaart Kreasi Digital saat ini berdasarkan analisis UI/UX?
2. Bagaimana merancang ulang UI/UX website agar informasi layanan dan produk lebih jelas serta fitur konsultasi dan chat mudah ditemukan dan digunakan?
3. Bagaimana rancangan ulang tersebut diimplementasikan pada website menggunakan Laravel dan bagaimana hasil pengujian fungsionalnya?

### 1.3 Tujuan

1. Menganalisis tampilan, struktur informasi, dan alur penggunaan website PT Smaart Kreasi Digital.
2. Merancang ulang UI/UX website agar informasi layanan dan produk lebih jelas serta fitur konsultasi dan chat mudah ditemukan dan digunakan.
3. Mengimplementasikan rancangan ulang menggunakan Laravel dan menguji fungsi utama website.

### 1.4 Manfaat

**Bagi perusahaan**

- Menyediakan media digital untuk memperkenalkan layanan dan produk.
- Mempermudah pencatatan permintaan konsultasi dari calon pelanggan.
- Membantu admin mengelola konten dan menindaklanjuti percakapan.

**Bagi pengunjung**

- Memudahkan akses terhadap informasi layanan dan produk.
- Memberikan sarana untuk menyampaikan kebutuhan dan meminta informasi.

**Bagi penyusun**

- Menambah pengalaman menganalisis dan merancang UI/UX, menerapkan Laravel, dan menguji aplikasi web.

### 1.5 Batasan Masalah

1. Pembahasan berfokus pada analisis dan redesain UI/UX website PT Smaart Kreasi Digital. Laravel dibahas sebagai teknologi untuk mengimplementasikan rancangan.
2. Analisis dan implementasi dibatasi pada halaman utama, informasi layanan/pilar dan produk, formulir konsultasi, fitur chat, serta area admin yang tersedia pada proyek.
3. Redesain berfokus pada tampilan, struktur informasi, navigasi, dan alur penggunaan fitur; pembahasan tidak mencakup perubahan proses bisnis perusahaan di luar website.
4. Fitur chatbot yang dibahas adalah balasan otomatis berbasis kata kunci dan data katalog serta opsi meneruskan percakapan kepada admin; integrasi layanan AI eksternal tidak termasuk dalam ruang lingkup.
5. Formulir konsultasi menyimpan data ke basis data. Pengiriman email otomatis dan integrasi layanan eksternal lainnya tidak dibahas.
6. Evaluasi dibatasi pada analisis antarmuka/alur website dan pengujian fungsional otomatis yang tersedia. Penelitian ini tidak mencakup wawancara atau pengujian kegunaan langsung bersama pengguna, sehingga tidak menyimpulkan tingkat kepuasan atau kemudahan berdasarkan persepsi pengguna.
7. Pembahasan tidak mencakup deployment produksi, audit keamanan menyeluruh, dan pengukuran performa website.

---

## BAB II GAMBARAN UMUM DAN ANALISIS KEBUTUHAN

### 2.1 Gambaran Proyek

Objek laporan adalah UI/UX website profil PT Smaart Kreasi Digital beserta implementasi website yang tersedia. Website memuat informasi perusahaan, pilar strategis/layanan, dan produk digital. Interaksi pengunjung meliputi konsultasi dan chat, sementara admin memiliki halaman pengelolaan yang dilindungi proses login. Aspek yang menjadi perhatian redesain adalah kejelasan informasi, navigasi, konsistensi antarmuka, dan kemudahan menyelesaikan tugas.

### 2.2 Analisis Kebutuhan Fungsional

| No. | Pengguna | Kebutuhan |
|---|---|---|
| 1 | Pengunjung | Melihat informasi utama, pilar layanan, dan produk yang aktif. |
| 2 | Pengunjung | Mengirim formulir konsultasi dengan data yang tervalidasi. |
| 3 | Pengunjung | Mengirim pesan, melihat riwayat percakapan, dan meminta bantuan admin. |
| 4 | Admin | Login sebelum membuka area pengelolaan. |
| 5 | Admin | Menambah, melihat, mengubah, dan menghapus data produk serta layanan. |
| 6 | Admin | Melihat permintaan konsultasi dan daftar percakapan yang perlu ditangani. |
| 7 | Admin | Membalas dan menutup percakapan pengunjung. |

### 2.3 Kebutuhan Nonfungsional

- Website dibangun menggunakan Laravel 10 dan PHP minimal 8.1 sesuai konfigurasi proyek.
- Data aplikasi dikelola melalui model Eloquent dan migration.
- Area admin dibatasi menggunakan autentikasi.
- Input konsultasi dan chat divalidasi sebelum diproses.
- Endpoint pengiriman pesan dan permintaan handoff chat menggunakan pembatasan permintaan.
- Pengujian otomatis dikonfigurasi untuk memakai SQLite di memori agar data pengujian terpisah dari database aplikasi.

### 2.4 Teknologi yang Digunakan

| Teknologi | Peran |
|---|---|
| PHP | Bahasa pemrograman sisi server. |
| Laravel 10 | Framework aplikasi, routing, middleware, validasi, dan pengelolaan request. |
| Blade dan HTML | Penyusunan template dan struktur halaman. |
| CSS | Pengaturan tampilan dan tata letak. |
| JavaScript | Interaksi antarmuka, pencarian, tema, dan widget chat. |
| Vite | Pengelolaan dan build aset frontend. |
| Eloquent ORM | Interaksi aplikasi dengan data berbasis model. |
| MySQL | Database default sesuai konfigurasi; database aktif dapat ditentukan oleh environment. |
| PHPUnit | Menjalankan pengujian otomatis aplikasi. |

---

## BAB III METODE DAN PERANCANGAN

### 3.1 Metode Analisis dan Redesain

Laporan menggunakan analisis deskriptif terhadap tampilan, struktur informasi, alur fitur, dan kode website yang tersedia. Analisis difokuskan pada halaman utama, navigasi, informasi layanan dan produk, konsultasi, chat, serta area admin. Implementasi ditelusuri melalui route, controller, model, template, dan test untuk menjelaskan cara kerja fitur.

Tahapan pengerjaan laporan meliputi:

1. **Inventarisasi website** — mengidentifikasi halaman, fitur, dan teknologi yang tersedia.
2. **Analisis UI/UX** — meninjau struktur informasi, navigasi, konsistensi tampilan, dan alur utama berdasarkan halaman yang ada.
3. **Perancangan redesain** — menyusun perbaikan tampilan dan alur agar tujuan tiap bagian website lebih jelas.
4. **Implementasi** — menerapkan rancangan pada halaman website menggunakan Blade, CSS, JavaScript, dan Laravel.
5. **Pengujian fungsional** — menjalankan test otomatis yang tersedia untuk memeriksa fitur utama.
6. **Evaluasi** — merangkum hasil pengujian dan mencatat batas evaluasi.

Analisis ini tidak menggunakan wawancara dan tidak mengukur kepuasan atau kemudahan penggunaan melalui pengujian langsung bersama pengguna. Oleh karena itu, kesimpulan UI/UX dibatasi pada telaah antarmuka dan alur yang tersedia, bukan klaim tentang persepsi pengguna.

### 3.2 Tahapan Redesain dan Implementasi

1. **Memetakan website** — mencatat halaman publik, konten, dan fitur interaktif.
2. **Meninjau alur** — memeriksa langkah yang diperlukan untuk menemukan informasi, mengirim konsultasi, menggunakan chat, dan mengelola konten.
3. **Menyusun rancangan** — merapikan struktur informasi, navigasi, dan alur antarmuka.
4. **Mengimplementasikan rancangan** — menerapkan tampilan dan interaksi pada website menggunakan teknologi proyek.
5. **Memeriksa fungsi** — menjalankan test otomatis dan mencatat hasilnya.

### 3.3 Perancangan Alur Sistem

**Alur pengunjung melihat informasi**

Pengunjung membuka halaman utama → route memanggil `HomeController` → controller mengambil layanan dan produk aktif → data ditampilkan melalui template Blade.

**Alur permintaan konsultasi**

Pengunjung mengisi formulir → route `POST /konsultasi` meneruskan data ke controller → controller memvalidasi data → data yang valid disimpan ke tabel konsultasi → admin dapat meninjau permintaan tersebut.

**Alur chat**

Pengunjung mengirim pesan melalui widget → endpoint API menyimpan pesan → layanan chatbot memilih jawaban berdasarkan kata kunci dan katalog aktif → jika pengunjung meminta admin, percakapan diteruskan ke antrean admin.

**Alur admin**

Admin login → middleware autentikasi memeriksa akses → admin membuka dashboard → admin mengelola produk/layanan atau meninjau konsultasi dan chat.

### 3.4 Struktur Data Utama

| Model | Fungsi |
|---|---|
| `Product` | Menyimpan informasi produk digital dan status publikasinya. |
| `Service` | Menyimpan informasi pilar atau layanan beserta fitur. |
| `ProjectConsultation` | Menyimpan permintaan konsultasi pengunjung. |
| `ChatConversation` | Menyimpan identitas sesi dan status percakapan. |
| `ChatMessage` | Menyimpan pesan pengunjung, bot, atau admin. |
| `User` | Menyimpan akun untuk autentikasi admin. |

Migration mendefinisikan struktur tabel, sedangkan seeder menyediakan data awal produk dan pilar. Konten produk dan layanan yang aktif diambil untuk ditampilkan pada website publik.

---

## BAB IV IMPLEMENTASI DAN PENGUJIAN

### 4.1 Implementasi Halaman Publik

Halaman utama berada di `resources/views/welcome.blade.php`. Halaman ini menampilkan bagian pengenalan, pilar strategis, informasi produk, formulir konsultasi, informasi kontak, dan widget chat. Data layanan dan produk disiapkan oleh `HomeController`, sehingga konten yang dikelola admin dapat digunakan pada halaman publik.

Dalam konteks UI/UX, elemen-elemen tersebut merupakan bagian dari struktur informasi dan alur tugas pengunjung. Analisis redesain dalam laporan ini didasarkan pada telaah terhadap tampilan serta alur website yang tersedia, bukan pada wawancara atau pengukuran persepsi pengguna.

### 4.2 Implementasi Formulir Konsultasi

Formulir konsultasi dikirim melalui route `POST /konsultasi`. Data nama, email, layanan yang diminati, dan pesan merupakan isian wajib; nomor telepon dan perusahaan bersifat opsional. Controller memeriksa data sebelum menyimpannya ke tabel `project_consultations`. Setelah berhasil, pengunjung menerima pesan konfirmasi pada halaman.

### 4.3 Implementasi Chat

Widget chat berkomunikasi dengan endpoint API untuk mengambil riwayat dan mengirim pesan. Identitas percakapan pengunjung dihubungkan menggunakan token sesi. Balasan otomatis dibuat oleh `ChatbotReplyService` berdasarkan kata kunci dan isi katalog aktif, bukan oleh model AI eksternal. Pengunjung dapat meminta admin mengambil alih percakapan. Pembaruan percakapan dilakukan secara berkala dari browser.

### 4.4 Implementasi Area Admin

Area admin menggunakan middleware autentikasi dan memiliki dashboard serta menu pengelolaan. Admin dapat mengelola data produk dan layanan, meninjau permintaan konsultasi, serta membuka dan membalas percakapan yang diteruskan. Fitur pengelolaan produk juga mendukung unggah dan penggantian gambar.

### 4.5 Pengujian

Pengujian otomatis dijalankan menggunakan perintah `php artisan test`. Cakupan test proyek meliputi halaman dan autentikasi admin, pilar, produk, konsultasi, serta chat.

| Hasil | Jumlah | Keterangan |
|---|---:|---|
| Lulus | 27 | Test selain pemeriksaan judul formulir konsultasi berhasil. |
| Gagal | 1 | Test halaman konsultasi mengharapkan teks persis `KONSULTASI PROYEK`, sedangkan teks tersebut tidak ditemukan pada HTML halaman. |
| Total | 28 | Jumlah pengujian yang dijalankan. |

Hasil tersebut menunjukkan mayoritas alur yang diuji berjalan sesuai ekspektasi. Namun, status keseluruhan suite belum sepenuhnya lulus. Pengujian yang gagal perlu ditinjau dengan membandingkan teks yang memang dirancang untuk tampil dengan ekspektasi pada test, lalu memperbarui salah satunya agar konsisten. Hasil pengujian ini adalah kondisi saat laporan disusun dan dapat berubah setelah perbaikan.

### 4.6 Hasil yang Dicapai

Hasil implementasi proyek yang dapat diverifikasi dari kode meliputi:

1. Website publik untuk menampilkan informasi perusahaan, layanan, dan produk.
2. Formulir konsultasi yang divalidasi dan menyimpan data ke database.
3. Fitur chat dengan balasan berbasis aturan kata kunci dan mekanisme permintaan bantuan admin.
4. Dashboard admin untuk mengelola konten dan menindaklanjuti interaksi pengunjung.
5. Kumpulan pengujian otomatis untuk memeriksa beberapa alur utama.

Evaluasi pada laporan ini terbatas pada telaah tampilan/alur dan hasil pengujian fungsional. Untuk mengetahui dampak redesain terhadap kemudahan penggunaan atau kepuasan pengunjung, diperlukan pengujian kegunaan langsung bersama pengguna sebagai pekerjaan lanjutan.

---

## BAB V PENUTUP

### 5.1 Kesimpulan

Laporan ini menetapkan redesain UI/UX sebagai fokus utama dan Laravel sebagai teknologi implementasi. Website yang ditinjau menggabungkan penyajian informasi produk dan layanan dengan konsultasi, chat, serta area admin. Analisis dilakukan terhadap antarmuka dan alur yang tersedia, tanpa wawancara atau pengujian langsung bersama pengguna.

Penerapan Laravel mengatur alur aplikasi melalui route, controller, model, middleware, dan template Blade. Pengujian otomatis mencakup sejumlah fungsi utama; pada pemeriksaan untuk laporan ini, 27 test lulus dan 1 test perlu diselaraskan karena perbedaan teks judul yang diharapkan dan teks pada halaman. Hasil tersebut mengukur fungsi yang diuji, bukan dengan sendirinya membuktikan kualitas UI/UX.

### 5.2 Saran

1. Lakukan evaluasi kegunaan bersama pengguna sebagai pengembangan lanjutan untuk memperoleh umpan balik langsung terhadap hasil redesain.
2. Selaraskan assertion pada test formulir dengan judul yang benar-benar ditampilkan, atau sesuaikan teks halaman jika frasa tersebut memang ditetapkan sebagai judul; kemudian jalankan kembali seluruh test.
3. Lengkapi isi website dengan informasi resmi perusahaan, kontak, dan materi produk yang telah disetujui.
4. Pastikan konfigurasi database, domain, penyimpanan unggahan, serta pengaturan keamanan telah diperiksa sebelum deployment.

---

## DAFTAR PUSTAKA

1. Dokumentasi proyek SMAART, `docs/PANDUAN-MEMAHAMI-PROYEK.md`.
2. Catatan presentasi proyek SMAART, `Catatan-Presentasi-SMAART.txt`.
3. Laravel. *Laravel 10.x Documentation*. https://laravel.com/docs/10.x
4. PHPUnit. *PHPUnit Documentation*. https://docs.phpunit.de/
