# Panduan Memahami Proyek SMAART

Panduan ini menjelaskan bagian-bagian penting aplikasi berdasarkan kode yang ada di proyek. Aplikasi menggunakan Laravel 10, PHP, Blade, JavaScript, CSS, dan database melalui Eloquent.

## 1. Gambaran singkat

Proyek ini adalah website profil PT Smaart Kreasi Digital beserta area admin. Pengunjung bisa melihat layanan dan produk, mengirim permintaan konsultasi, serta bertanya melalui chat. Admin yang sudah login dapat mengelola produk dan layanan, membaca konsultasi, dan membalas chat.

Secara sederhana, alur Laravel-nya:

1. Pengunjung membuka alamat website.
2. `routes/web.php` atau `routes/api.php` menentukan URL dan fungsi yang menangani permintaan.
3. Controller mengambil atau menyimpan data menggunakan Model.
4. Controller mengirim hasilnya ke halaman Blade atau sebagai JSON.
5. Blade menampilkan HTML; CSS mengatur tampilan dan JavaScript menangani interaksi di browser.

## 2. Alur fitur yang tersedia

### Beranda

- `GET /` diarahkan ke `HomeController`.
- Controller mengambil layanan aktif dari tabel `services` dan produk aktif dari tabel `products`.
- `resources/views/welcome.blade.php` menampilkan hero, pilar strategis, visi, produk, formulir konsultasi, kontak, dan widget chat.
- Konten produk serta layanan berasal dari database, bukan hanya ditulis langsung di halaman.

### Formulir konsultasi

- Formulir ada di bagian Kontak pada halaman beranda.
- Form dikirim dengan `POST /konsultasi` ke `ProjectConsultationController`.
- Data nama, email, layanan, dan pesan wajib diisi; telepon dan perusahaan boleh kosong.
- Setelah validasi, datanya disimpan ke `project_consultations` dan pengguna mendapat pesan berhasil.
- Admin melihat daftar konsultasi dari menu **Konsultasi Proyek**.

### Login dan area admin

- `GET /login` menampilkan formulir login.
- `POST /login` memeriksa email dan kata sandi. Percobaan gagal dibatasi; setelah lima kegagalan, login ditahan selama satu menit.
- Rute admin berada di awalan `/admin` dan dilindungi middleware `auth`.
- Dashboard merangkum jumlah produk, pilar aktif, konsultasi, dan konsultasi terbaru.
- Admin dapat menambah, mengubah, mencari, dan menghapus produk atau layanan.

### Chat pengunjung dan admin

- Browser membuat token UUID untuk mengaitkan pengunjung dengan percakapan, lalu menyimpannya di `localStorage`.
- `GET /api/chat` mengambil percakapan; `POST /api/chat` menyimpan pesan dan meminta jawaban dari `ChatbotReplyService`.
- Chatbot memberi jawaban berdasarkan kata kunci dan data produk/layanan aktif. Jika pengunjung meminta admin, percakapan dialihkan ke antrean admin.
- Admin membuka **Live Chat**, membalas, lalu dapat menutup percakapan.
- Chat diperbarui dengan permintaan berkala dari browser, bukan WebSocket.
- Rute kirim pesan dan permintaan admin dibatasi 10 permintaan per menit dan 20 per hari per pengunjung berdasarkan konfigurasi rate limit.

## 3. Folder dan file penting

### Aplikasi Laravel

| Lokasi | Kegunaan |m
|---|---|
| `routes/web.php` | URL halaman website, login, konsultasi, logout, dan admin. |
| `routes/api.php` | Endpoint JSON untuk chat dan endpoint pengguna Sanctum. |
| `app/Http/Controllers/HomeController.php` | Menyiapkan data layanan dan produk untuk beranda. |
| `app/Http/Controllers/ProjectConsultationController.php` | Memvalidasi dan menyimpan permintaan konsultasi. |
| `app/Http/Controllers/PublicChatController.php` | Membaca percakapan, menyimpan pesan, mengirim jawaban bot, dan meminta bantuan admin. |
| `app/Http/Controllers/Auth/AuthenticatedSessionController.php` | Menangani formulir login, pembatasan percobaan login, sesi, dan logout. |
| `app/Http/Controllers/Admin/DashboardController.php` | Menyiapkan ringkasan dashboard serta daftar pencarian konsultasi. |
| `app/Http/Controllers/Admin/ProductController.php` | CRUD produk, pencarian, validasi, dan penyimpanan gambar. |
| `app/Http/Controllers/Admin/ServiceController.php` | CRUD layanan/pilar serta mengubah daftar fitur dari teks menjadi array. |
| `app/Http/Controllers/Admin/ChatController.php` | Menampilkan percakapan admin, mengirim balasan, dan menutup chat. |
| `app/Services/ChatbotReplyService.php` | Aturan jawaban otomatis chatbot berbasis kata kunci dan isi database. |
| `app/Http/Kernel.php` | Mengatur middleware global dan grup web/API, termasuk sesi, CSRF, dan pembatasan API. |
| `app/Providers/RouteServiceProvider.php` | Mendaftarkan file rute dan aturan pembatasan jumlah permintaan. |
| `app/Exceptions/Handler.php` | Titik pengaturan penanganan error aplikasi. |
| `app/Console/Kernel.php` | Tempat pengaturan perintah dan tugas terjadwal Laravel. |

### Model dan database

Model adalah representasi tabel database dan cara aplikasi berinteraksi dengan datanya.

| File model | Data yang diwakili |
|---|---|
| `app/Models/Product.php` | Produk; juga membentuk URL gambar berdasarkan lokasi gambar. |
| `app/Models/Service.php` | Layanan/pilar strategis; daftar fitur disimpan sebagai array JSON. |
| `app/Models/ProjectConsultation.php` | Permintaan konsultasi dari formulir website. |
| `app/Models/ChatConversation.php` | Percakapan pengunjung, status chat, token, dan relasi ke pesan. |
| `app/Models/ChatMessage.php` | Pesan pengunjung, bot, atau admin; terhubung ke percakapan. |
| `app/Models/User.php` | Akun yang digunakan untuk autentikasi admin. Kata sandi disimpan dalam bentuk hash. |

Folder `database/migrations` berisi perubahan/definisi struktur tabel:

- `create_users_table`: akun pengguna dan kata sandi.
- `create_products_table`: nama, slug, tagline, deskripsi, gambar, URL, dan status aktif produk.
- `create_services_table` serta `add_features_to_services_table`: layanan/pilar dan daftar fiturnya.
- `create_project_consultations_table`: data formulir konsultasi beserta statusnya.
- `create_chat_conversations_table`: identitas sesi dan status percakapan chat.
- `create_chat_messages_table`: isi pesan dan relasinya ke percakapan; pesan ikut terhapus jika percakapannya dihapus.
- Migrasi lain untuk password reset, token API, dan pekerjaan gagal adalah bagian dukungan Laravel.

Migration adalah catatan perubahan struktur database. `database/seeders/DatabaseSeeder.php` menjalankan `PillarSeeder` dan `ProductSeeder`, yang memasukkan contoh pilar dan produk awal. Seeder menggunakan `firstOrCreate`, jadi data awal tidak dibuat ulang jika slug-nya sudah ada.

### Tampilan dan aset

| Lokasi | Kegunaan |
|---|---|
| `resources/views/welcome.blade.php` | Template Blade halaman utama publik. Sintaks seperti `@foreach` mengulang data dan `{{ ... }}` menampilkan nilai dengan escaping HTML. |
| `resources/views/auth/login.blade.php` | Tampilan login admin. |
| `resources/views/admin/layouts/app.blade.php` | Kerangka bersama area admin: sidebar, navigasi, header, pesan error/berhasil, dan footer. |
| `resources/views/admin/dashboard.blade.php` | Tampilan ringkasan admin. |
| `resources/views/admin/products/` | Halaman daftar, tambah, dan edit produk. |
| `resources/views/admin/services/` | Halaman daftar, tambah, dan edit layanan. |
| `resources/views/admin/consultations/index.blade.php` | Tampilan daftar permintaan konsultasi. |
| `resources/views/admin/chats/index.blade.php` | Tampilan percakapan yang ditangani admin. |
| `resources/views/admin/settings/index.blade.php` | Tampilan menu pengaturan website. |
| `resources/css/app.css`, `resources/js/app.js` | Aset utama yang diproses oleh Vite. |
| `public/css/` | CSS website publik, pencarian, tema, halaman utama, dan area admin. |
| `public/js/global-search.js` | Logika pencarian pada website. |
| `public/js/global-theme.js` | Tombol mode gelap/terang; pilihan tema disimpan di browser. |
| `public/images/` | Logo, gambar hero, serta ilustrasi produk. |

`resources/views` adalah template halaman, sedangkan `public` berisi file statis yang langsung dikirim ke browser. `vite.config.js` mengatur Vite untuk memproses `resources/css/app.css` dan `resources/js/app.js`.

### File konfigurasi

File di `config/` mengatur perilaku Laravel; banyak nilainya diambil dari `.env`. `.env` berisi konfigurasi lokal seperti kredensial database dan jangan dibagikan atau dimasukkan ke Git.

| File | Pengaturan |
|---|---|
| `config/app.php` | Nama aplikasi, mode, URL, zona waktu, dan pengaturan dasar aplikasi. |
| `config/auth.php` | Guard, sumber data akun, dan aturan reset kata sandi. Proyek menggunakan autentikasi sesi web dan model `User`. |
| `config/database.php` | Koneksi database. Default pada file ini adalah `mysql`, tetapi nilai `.env` dapat menggantinya. |
| `config/broadcasting.php` | Layanan broadcast event; default file adalah `null`. |
| `config/cache.php` | Penyimpanan cache. |
| `config/cors.php` | Aturan akses lintas domain browser untuk `api/*` dan `sanctum/csrf-cookie`. File ini mengizinkan semua origin dan metode pada path tersebut; sesuaikan jika API dipakai lintas domain di produksi. |
| `config/filesystems.php` | Lokasi penyimpanan file lokal, publik, atau S3. Gambar produk yang diunggah controller disimpan pada disk `public`. |
| `config/hashing.php` | Algoritma hashing, termasuk hash kata sandi. |
| `config/logging.php` | Tujuan dan level log aplikasi. |
| `config/mail.php` | Pengiriman email. Form konsultasi saat ini menyimpan data ke database; controller-nya tidak mengirim email. |
| `config/queue.php` | Cara menjalankan pekerjaan latar belakang. Default `sync` berarti pekerjaan berjalan langsung dalam permintaan; kode fitur yang ditinjau belum mengirim job ke antrean. |
| `config/sanctum.php` | Pengaturan autentikasi token/API Sanctum. |
| `config/services.php` | Kredensial layanan eksternal yang diambil dari `.env`. |
| `config/session.php` | Cara dan lama penyimpanan sesi login. |
| `config/view.php` | Lokasi template Blade dan cache hasil kompilasi view. |

`app/Providers` menghubungkan layanan inti Laravel dengan aplikasi. `app/Http/Middleware` berisi lapisan pemeriksaan/pemrosesan request, misalnya autentikasi, CSRF, dan proxy. Tidak semua file di folder ini berisi fitur khusus SMAART; beberapa adalah kerangka standar Laravel.

### File pendukung proyek

- `artisan`: antarmuka perintah Laravel, misalnya untuk migrasi database.
- `public/index.php`: pintu masuk request website ke Laravel.
- `bootstrap/app.php`: menyiapkan aplikasi Laravel.
- `composer.json` dan `composer.lock`: daftar serta versi paket PHP.
- `package.json` dan `package-lock.json`: daftar serta versi paket JavaScript.
- `phpunit.xml`: konfigurasi pengujian; test menggunakan SQLite sementara di memori.
- `tests/Feature/`: pengujian alur seperti chat, login admin, produk, pilar, dan konsultasi.
- `storage/`: log, cache, sesi, dan file aplikasi. `public/storage` biasanya menjadi tautan publik ke file yang diunggah.
- `vendor/` dan `node_modules/`: paket pihak ketiga, bukan kode fitur website yang biasanya perlu dipelajari atau diedit.
- `public/build/`: hasil build aset untuk digunakan website; umumnya dibuat oleh Vite.

## 4. Istilah dasar

- **Route**: alamat/URL dan aturan untuk memilih fungsi yang merespons.
- **Controller**: pengatur alur request; memvalidasi data, memanggil Model, lalu mengembalikan halaman atau JSON.
- **Model**: penghubung kode ke tabel database.
- **Migration**: definisi perubahan struktur tabel database.
- **Seeder**: pengisi data awal atau contoh.
- **Blade**: sistem template Laravel untuk membuat HTML dinamis.
- **Middleware**: pemeriksaan yang dilewati request, misalnya apakah pengguna sudah login.
- **CRUD**: Create, Read, Update, Delete—tambah, lihat, ubah, dan hapus data.
- **API/JSON**: cara frontend bertukar data dengan backend tanpa memuat ulang seluruh halaman.
- **Vite**: alat untuk menjalankan dan membangun aset CSS/JavaScript frontend.

## 5. Catatan tentang perilaku yang ditemukan

1. Chat admin dan pengunjung disegarkan secara berkala dari JavaScript. Konfigurasi broadcast tersedia, tetapi `config/broadcasting.php` default-nya `null` dan integrasi Echo/Pusher di `resources/js/bootstrap.js` masih berupa komentar. Jadi jangan menganggap chat memakai WebSocket.
2. `public/js/global-search.js` mencari kartu dengan selector `#services .pillar-card` dan `.solution-feature`/`.solution-card`. Beranda saat ini memakai `#pillars .home-pillar-card` dan `.home-product`. Selector yang tidak cocok ini dapat membuat data pencarian tidak terambil; periksa bagian ini jika pencarian tidak menampilkan hasil.
3. `config/cors.php` mengizinkan origin `*` untuk path API yang disebut di file. Untuk deployment, pastikan cakupan ini memang sesuai kebutuhan.
4. Menu pengaturan tersedia di admin, tetapi halaman tersebut hanya sebuah view; route/controller yang diperiksa mengembalikan tampilan itu tanpa menyimpan pengaturan website.

## 6. Urutan belajar yang disarankan

1. Mulai dari `routes/web.php` untuk mengenali URL.
2. Ikuti satu alur sederhana: `HomeController` → Model `Product`/`Service` → `welcome.blade.php`.
3. Pelajari formulir konsultasi dari Blade → route `consultations.store` → `ProjectConsultationController` → Model → migration.
4. Pelajari login dan middleware `auth`, lalu lihat layout dan dashboard admin.
5. Pelajari fitur chat setelah memahami route API, Model percakapan/pesan, dan `ChatbotReplyService`.
6. Setelah itu, pelajari CSS/JavaScript dan konfigurasi yang berkaitan dengan fitur yang sedang diubah.

Untuk mengubah teks/struktur halaman, mulai dari file Blade. Untuk mengubah warna, ukuran, atau tata letak, mulai dari CSS terkait. Untuk mengubah data/formulir, telusuri route, controller, model, dan migration bersama-sama.

## 7. Penjelasan lebih rinci tentang kode aplikasi

Bagian ini melengkapi daftar file dengan apa yang dilakukan kode di dalamnya. Tujuannya menjelaskan alur dan fungsi blok kode, bukan menggandakan seluruh source code Laravel ke dalam dokumen.

### Routes dan pengamanan request

`routes/web.php` mendaftarkan rute browser:

- `POST /konsultasi` diberi nama `consultations.store` dan diteruskan ke `ProjectConsultationController::store`.
- `GET /` diberi nama `home` dan memakai `HomeController` sebagai controller tunggal.
- Grup `guest` membatasi tampilan dan pengiriman login untuk pengunjung yang belum login.
- `POST /logout` memakai middleware `auth`, sehingga hanya akun login yang dapat keluar.
- Grup admin memiliki prefix `/admin`, nama route `admin.*`, dan middleware `auth`. Di dalamnya ada dashboard, daftar konsultasi, pengaturan, chat, serta resource CRUD produk dan layanan. Resource dikecualikan dari halaman `show` karena tidak ada halaman detail tunggal di rute tersebut.

`routes/api.php` mendaftarkan rute JSON di bawah prefix `/api`:

- `GET /api/user` perlu autentikasi Sanctum.
- `GET /api/chat` membaca percakapan berdasarkan token sesi.
- `POST /api/chat` mengirim pesan ke chat dan memakai middleware `throttle:chat`.
- `POST /api/chat/handoff` meminta admin mengambil alih chat dan memakai throttle yang sama.

`app/Http/Kernel.php` menjalankan middleware umum untuk setiap request, lalu middleware per grup. Grup `web` mengelola cookie, sesi, error validasi, perlindungan CSRF, dan binding model dari URL. Grup `api` menerapkan pembatasan umum API dan binding model. Alias `auth`, `guest`, `throttle`, dan alias Laravel lain mengizinkan middleware dipasang dengan nama pendek di route.

`app/Providers/RouteServiceProvider.php` menghubungkan file route web/API ke Laravel. Ia juga menetapkan batas umum API 60 request per menit dan batas chat 10 per menit serta 20 per hari, dengan identitas berdasarkan akun atau alamat IP.

### Controller dan logika bisnis

| File | Urutan kerja dan logika yang ada |
|---|---|
| `HomeController.php` | Mengambil `Service` aktif, urut ID; mengambil `Product` aktif, urut terbaru; mengirim keduanya ke view `welcome`. |
| `ProjectConsultationController.php` | Memeriksa nama, email, layanan, dan pesan sebagai wajib; telepon/perusahaan opsional; menyimpan hanya data tervalidasi; kembali ke halaman dengan pesan sukses. |
| `PublicChatController.php` | `show` memvalidasi UUID lalu mencari percakapan; `send` memvalidasi token dan pesan, membuat percakapan bila belum ada, menyimpan pesan pengunjung, memanggil bot jika aktif, memperbarui status/waktu, dan mengembalikan JSON. Chat tertutup menolak pesan dengan HTTP 409. `handoff` mematikan bot, mengubah status menjadi `waiting_admin`, dan menambahkan pesan pemberitahuan. Operasi tulis dibungkus transaksi database. Payload membatasi riwayat ke 200 pesan terakhir. |
| `ChatbotReplyService.php` | Menormalkan huruf/aksen, mencari kata kunci permintaan admin, kontak, produk, layanan, atau sapaan. Detail produk dan layanan aktif diambil dari database. Bila tidak cocok, bot mengembalikan panduan umum. `containsAny` memeriksa apakah teks memuat salah satu kata kunci. |
| `AuthenticatedSessionController.php` | Menampilkan login; memvalidasi email/password; membatasi lima kegagalan selama 60 detik per email dan IP; memeriksa kredensial; membersihkan pembatasan saat berhasil; mengganti session ID; logout dengan membatalkan sesi dan token CSRF. |
| `DashboardController.php` | Menghitung ringkasan dashboard, mengambil lima konsultasi terbaru, mencari konsultasi pada nama/email/perusahaan/layanan, membatasi daftar ke 10 per halaman, dan menampilkan view pengaturan. |
| `ProductController.php` | Daftar produk dengan pencarian nama/slug dan pagination; form tambah/edit; validasi produk; membuat slug dari nama bila kosong; mencegah slug duplikat; menyimpan upload gambar publik; memperbarui data; menghapus upload lama milik folder `products/`; menghapus produk. Jika operasi simpan/hapus gambar gagal, controller melempar error eksplisit. |
| `ServiceController.php` | Daftar pilar dengan pencarian nama/slug/kategori dan pagination; tambah/edit/hapus; validasi; slug otomatis dan unik; memecah teks `features` per baris, membuang baris kosong, lalu menyimpannya sebagai array. |
| `Admin/ChatController.php` | Mengambil maksimal 100 percakapan terbaru beserta pesan terakhir; memilih percakapan dari query URL atau percakapan terbaru; memvalidasi dan menyimpan balasan admin; mengubah status menjadi `with_admin`; menutup percakapan dan menonaktifkan bot. |
| `Controller.php` | Controller dasar yang memakai dukungan Laravel untuk otorisasi dan validasi request. |

Pada controller CRUD, validasi memakai aturan Laravel seperti `required`, `string`, `email`, `url`, `image`, `mimes`, `max`, `boolean`, dan `unique`. `Request::validate()` menghentikan proses dan mengembalikan error validasi ke halaman bila input tidak memenuhi aturan. `DB::transaction()` menjaga beberapa perubahan chat tetap konsisten sebagai satu transaksi.

### Model: atribut, casting, dan hubungan

- `Product::$fillable` menentukan kolom yang boleh diisi melalui `create`/`update`. `is_active` di-cast menjadi boolean. Accessor `image_url` menangani tiga kemungkinan: tidak ada gambar, URL HTTP(S), atau path lokal; upload publik menggunakan URL `/storage/...`.
- `Service::$fillable` menentukan kolom layanan yang bisa disimpan; `features` di-cast JSON ↔ array dan `is_active` menjadi boolean.
- `ProjectConsultation::$fillable` berisi kolom formulir yang aman untuk penyimpanan massal.
- `ChatConversation` mengubah `is_bot_active` menjadi boolean dan `last_message_at` menjadi tanggal-waktu. `messages()` adalah relasi satu-ke-banyak; `latestMessage()` mengambil satu pesan terakhir.
- `ChatMessage` memiliki relasi `conversation()` ke percakapan dan mengubah `is_bot` menjadi boolean.
- `User` memakai fitur factory dan notifikasi Laravel, Sanctum API tokens, menyembunyikan password/token dari serialisasi, mengubah waktu verifikasi menjadi tanggal, dan otomatis meng-hash password melalui cast `hashed`.

### Tampilan Blade: isi dan tugas masing-masing

| File | Apa yang ditampilkan atau dilakukan kodenya |
|---|---|
| `resources/views/welcome.blade.php` | Dokumen HTML berbahasa Indonesia; memuat asset Vite dan stylesheet/script publik; header navigasi; dialog pencarian; hero; kartu pilar dari `$pillars`; bagian visi; kartu produk dari `$products`; form konsultasi dengan token CSRF dan pesan error/sukses; footer; tombol kembali ke atas; widget chatbot dengan endpoint API. `@foreach`/`@forelse` merender koleksi, `@if` memilih bagian kondisional, `{{ }}` melakukan escaping nilai, dan `route()` membuat URL dari nama route. |
| `resources/views/auth/login.blade.php` | Form login email/password, token CSRF, checkbox ingat saya, error validasi, serta tautan kembali ke beranda. |
| `resources/views/admin/layouts/app.blade.php` | Layout induk untuk semua halaman admin: sidebar/menu, tampilan menu aktif, bar atas dengan nama akun, tombol logout, slot judul/deskripsi/isi, notifikasi, serta JavaScript menu seluler dan konfirmasi penghapusan. |
| `resources/views/admin/dashboard.blade.php` | Kartu angka untuk produk, produk aktif, pilar, dan konsultasi; pintasan kelola; tabel lima konsultasi terbaru atau tampilan kosong. |
| `resources/views/admin/products/index.blade.php` | Form GET untuk mencari produk; tabel produk dengan gambar/status/slug; tautan edit; form hapus dengan CSRF dan method spoofing DELETE; pagination. |
| `resources/views/admin/products/create.blade.php` | Form POST untuk nama, slug, tagline, deskripsi, file gambar/path gambar, URL produk, dan status aktif. `multipart/form-data` dibutuhkan untuk upload. |
| `resources/views/admin/products/edit.blade.php` | Form PUT untuk data produk, menampilkan gambar saat ini dan mengganti gambar bila dipilih. Nilai `old()` dipakai agar isian tidak hilang saat validasi gagal. |
| `resources/views/admin/services/index.blade.php` | Pencarian dan tabel pilar, kategori, status, tautan edit, penghapusan, dan pagination. |
| `resources/views/admin/services/create.blade.php` | Form pilar baru dengan nama, slug, kategori, emoji/ikon, deskripsi, fitur per baris, dan status. JavaScript memperbarui pratinjau secara langsung dan memakai `textContent` untuk menampilkan input sebagai teks. |
| `resources/views/admin/services/edit.blade.php` | Form pengubahan pilar dan pratinjau yang sama dengan form tambah, tetapi nilai awal diambil dari database atau input lama. |
| `resources/views/admin/consultations/index.blade.php` | Form pencarian dan tabel kontak, perusahaan, layanan, pesan, status, tanggal serta pagination. Email dibuat sebagai tautan `mailto:`. |
| `resources/views/admin/chats/index.blade.php` | Kolom daftar percakapan dan detail chat; status percakapan diterjemahkan ke label; menampilkan pesan pengunjung/bot/admin; form balas dan tombol tutup untuk percakapan yang belum ditutup. |
| `resources/views/admin/settings/index.blade.php` | Halaman baca-saja untuk nama, URL, bahasa, dan zona waktu dari konfigurasi Laravel. Tidak ada form atau penyimpanan pengaturan. |

Method spoofing Blade seperti `@method('PUT')` atau `@method('DELETE')` memungkinkan form HTML yang hanya mendukung GET/POST memanggil operasi update/delete. `@csrf` menyertakan token perlindungan CSRF pada form.

### JavaScript dan CSS frontend

| File | Isi kode dan efeknya |
|---|---|
| `resources/js/bootstrap.js` | Mendaftarkan Axios dan header `X-Requested-With`. Inisialisasi Laravel Echo/Pusher dicontohkan tetapi dinonaktifkan dalam komentar. |
| `resources/js/app.js` | Mengimpor bootstrap; memilih layanan/produk otomatis pada form kontak saat tautan diklik; menu hamburger dan navigasi scroll; penanda navigasi aktif; efek reveal yang menghormati `prefers-reduced-motion`; tombol kembali ke atas; permintaan fetch JSON ke API chat; membuat UUID sesi chat dan menyimpannya di localStorage; merender pesan memakai `textContent`; menangani status, error, reset chat, quick replies, dan handoff ke admin; refresh chat tiap tiga detik. |
| `public/js/global-search.js` | Mengambil teks dari kartu halaman, menormalkan huruf/aksen, mencari seluruh kata query, menampilkan maksimum delapan hasil di dialog, menyediakan status kosong/hasil, serta menutup dialog melalui tombol, klik backdrop, atau Escape. |
| `public/js/global-theme.js` | Memeriksa apakah tombol tema ada, memperbarui label aksesibilitas, menukar class `smaart-dark-mode`, dan menyimpan preferensi `dark`/`light` di localStorage. |
| `resources/css/app.css` | Gaya inti website: variabel warna, ukuran container, font, link, tombol, header, section, serta perilaku dasar layout publik. |
| `public/css/homepage.css` | Gaya khusus beranda: header navigasi, hero dan foto latar, pilar, visi, produk, kontak, kartu/form, footer, chatbot, responsivitas dan animasi. |
| `public/css/site-refinement.css` | Penyesuaian tampilan tambahan. Pada bagian yang diperiksa, antara lain menyederhanakan tombol chatbot menjadi tombol bulat dan menyembunyikan label/status tombol. |
| `public/css/global-search.css` | Gaya tombol pencarian, dialog, backdrop, panel, input, hasil, dan status pencarian. |
| `public/css/global-theme.css` | Variabel warna mode gelap, gaya tombol tema, ikon matahari/bulan, aturan responsif, dan override warna elemen saat mode gelap. |
| `public/css/admin.css` | Sistem tampilan admin: warna dasar, sidebar, topbar, tombol, panel/tabel/form, kartu dashboard, chat, layout responsif, dan navigasi seluler. |
| `public/css/admin-auth.css` | Tampilan terpisah halaman login admin: latar, panel, logo, input, error, tombol, dan penyesuaian ukuran layar. |

CSS memakai custom properties seperti `--home-ink` atau `--navy` agar warna/tema dapat dipakai ulang. Aturan `@media` menyesuaikan tata letak untuk layar kecil; class seperti `.is-open`, `.is-visible`, dan `.smaart-dark-mode` ditambahkan/dihapus oleh JavaScript untuk mengubah tampilan.

### Database: arti kolom

Migration menulis definisi tabel di database, bukan memuat data halaman secara langsung:

- `users`: `name`, email unik, waktu verifikasi opsional, password, token ingat-login, timestamps.
- `products`: nama, slug unik, tagline/deskripsi, lokasi gambar, URL produk, status aktif, timestamps.
- `services`: nama, slug unik, kategori/deskripsi/ikon, status aktif, timestamps. Migration lanjutan menambah `features` bertipe JSON.
- `project_consultations`: nama/email, telepon/perusahaan opsional, layanan, pesan, status default `baru`, timestamps.
- `chat_conversations`: nama/email pengunjung opsional, token sesi unik, status default `open`, status bot, waktu pesan terakhir, timestamps.
- `chat_messages`: foreign key ke percakapan, teks pesan, tipe pengirim, penanda bot, timestamps. Foreign key memakai cascade delete.
- `password_reset_tokens`: email, token, waktu pembuatan; disediakan untuk alur reset password Laravel.
- `failed_jobs`: UUID, koneksi/antrian, payload dan error job gagal.
- `personal_access_tokens`: token API Sanctum, pemilik token polimorfik, izin, pemakaian, masa kedaluwarsa.

`down()` pada setiap migration menghapus tabel/kolom yang dibuat oleh `up()`, untuk membatalkan migration. Jangan menjalankan rollback di database berisi data penting tanpa memahami dampaknya.

### Seeder, factory, dan data uji

- `DatabaseSeeder` memanggil `PillarSeeder` dan `ProductSeeder`.
- `PillarSeeder` menyiapkan dua layanan awal, fitur masing-masing, kategori, deskripsi, dan status aktif.
- `ProductSeeder` menyiapkan empat produk SMAART dengan tagline, deskripsi, path ilustrasi, dan status aktif.
- Kedua seeder memakai `firstOrCreate(['slug' => ...], ...)`: mencari slug dahulu agar data seed yang sama tidak digandakan.
- `UserFactory` membuat data akun acak untuk pengujian; kata sandi default test adalah `password`, bukan kredensial produksi. Method `unverified()` mengosongkan waktu verifikasi.

### Pengujian

Pengujian memverifikasi hasil request dan keadaan database. `RefreshDatabase` membuat database test bersih untuk masing-masing pengujian. `phpunit.xml` mengatur environment testing, SQLite `:memory:`, cache/session array, dan mail array.

| File test | Hal yang diperiksa |
|---|---|
| `tests/Feature/StrategicPillarsTest.php` | Seed pilar tampil di beranda; admin dapat membuka form, mengubah fitur/ikon/deskripsi, dan pilar nonaktif tidak tampil ke publik. |
| `tests/Feature/PublicProductsTest.php` | Produk seed tampil; form upload gambar tersedia; admin dapat membuat produk, mengunggah/mengganti gambar; produk nonaktif tidak tampil dan gambar unggahan lama dihapus. |
| `tests/Feature/ProjectConsultationTest.php` | Form ada; konsultasi valid tersimpan dan muncul sebagai status `baru`; input invalid menampilkan error dan tidak menyimpan record. |
| `tests/Feature/ChatTest.php` | Pesan disimpan bersama jawaban bot; informasi produk diambil dari katalog aktif; riwayat dapat dibaca; handoff menonaktifkan bot; token/pesan invalid ditolak; admin dapat membaca/membalas/menutup percakapan; chat tertutup menolak pesan baru. |
| `tests/Feature/ChatConversationTest.php` | Relasi percakapan-pesan berfungsi dan penghapusan percakapan menghapus pesannya. |
| `tests/Feature/AdminAuthenticationTest.php` | Halaman login tersedia; halaman admin mengarahkan tamu ke login; kredensial salah menghasilkan error. |
| `tests/Feature/ExampleTest.php` | Contoh test dasar bahwa homepage sukses dan menampilkan pilar seed. |
| `tests/Unit/ExampleTest.php` | Contoh test unit PHPUnit sederhana untuk assertion boolean. |
| `tests/TestCase.php`, `tests/CreatesApplication.php` | Base class dan trait untuk memuat/bootstrap aplikasi Laravel saat test berjalan. |

Cara menjalankan pengujian proyek adalah `php artisan test`. Pengujian menggunakan konfigurasi database testing dari `phpunit.xml`, bukan seharusnya memakai database produksi.

### Kerangka aplikasi, providers, dan middleware standar

File-file ini penting bagi cara Laravel bekerja, meskipun sebagian besar merupakan titik ekstensi standar dan tidak menjalankan logika bisnis website khusus:

| File | Peran kode saat ini |
|---|---|
| `bootstrap/app.php` | Membuat instance aplikasi dan mendaftarkan HTTP Kernel, Console Kernel, dan exception handler. |
| `public/index.php` | Menerima request web, memuat autoloader/bootstrap, menjalankan HTTP Kernel, lalu mengirim response. |
| `artisan` | Menjalankan perintah CLI Laravel melalui Console Kernel. |
| `app/Providers/AppServiceProvider.php` | Tempat register/boot layanan aplikasi; method saat ini kosong. |
| `app/Providers/AuthServiceProvider.php` | Tempat mapping policy/otorisasi; belum ada policy atau aturan khusus yang didefinisikan. |
| `app/Providers/BroadcastServiceProvider.php` | Mendaftarkan rute broadcast dan memuat `routes/channels.php`; belum berarti chat memakai WebSocket. |
| `app/Providers/EventServiceProvider.php` | Memetakan event `Registered` ke notifikasi verifikasi email; auto-discovery event dinonaktifkan. |
| `app/Exceptions/Handler.php` | Mencegah password/current password/password confirmation dimasukkan ke data form lama saat error validasi; callback reportable saat ini tidak menambah tindakan. |
| `app/Console/Kernel.php` | Memuat perintah di `app/Console/Commands` dan `routes/console.php`; belum ada jadwal tugas aktif. |
| `app/Http/Middleware/Authenticate.php` | Mengarahkan request halaman biasa yang belum login ke route `login`; request JSON tidak diarahkan ke halaman. |
| `app/Http/Middleware/RedirectIfAuthenticated.php` | Jika sudah login, mengarahkan pengguna dari halaman guest ke path HOME pada RouteServiceProvider. |
| `app/Http/Middleware/EncryptCookies.php` | Mewarisi enkripsi cookie Laravel; tidak ada cookie yang dikecualikan. |
| `app/Http/Middleware/VerifyCsrfToken.php` | Mewarisi pemeriksaan CSRF Laravel; tidak ada URL yang dikecualikan. |
| `app/Http/Middleware/TrimStrings.php` | Memangkas spasi input, tetapi tidak memangkas kolom password. |
| `app/Http/Middleware/PreventRequestsDuringMaintenance.php` | Memblokir request saat aplikasi dalam mode maintenance; tidak ada URL pengecualian. |
| `app/Http/Middleware/TrustHosts.php` | Menyediakan pola host subdomain dari URL aplikasi; middleware ini tidak aktif di daftar global saat ini karena baris pendaftarannya dikomentari. |
| `app/Http/Middleware/TrustProxies.php` | Mengatur header proxy yang dipercaya untuk IP/host/port/protokol; daftar proxy spesifik belum ditetapkan di file. |
| `app/Http/Middleware/ValidateSignature.php` | Memakai validasi URL bertanda tangan Laravel; tidak ada parameter query yang dikecualikan. |
| `routes/channels.php` | Channel privat standar `App.Models.User.{id}` hanya boleh didengar pemilik akun dengan ID yang sama. |
| `routes/console.php` | Mendaftarkan perintah `inspire` bawaan yang mencetak kutipan motivasi. |

`bootstrap/cache/packages.php` dan `bootstrap/cache/services.php` adalah hasil cache discovery Composer/Laravel, bukan tempat menulis fitur. Isinya dibuat ulang oleh framework saat package discovery/cache berjalan.

## 8. File proyek lain dan batas cakupan

- `composer.json` menentukan Laravel 10, PHP minimal 8.1, Sanctum, Guzzle, serta dependency development seperti PHPUnit/Pint. `composer.lock` mengunci versi dependency agar pemasangan konsisten.
- `package.json` menentukan Vite, Laravel Vite Plugin, Axios, dan perintah `npm run dev`/`npm run build`. `package-lock.json` mengunci versi paket Node.
- `vite.config.js` memasukkan `resources/css/app.css` dan `resources/js/app.js` ke proses build serta mengaktifkan refresh saat pengembangan.
- `phpunit.xml` menentukan suite Feature/Unit dan variabel pengujian.
- `README.md` saat ini terutama README bawaan Laravel, bukan dokumentasi khusus semua fitur SMAART.
- `public/robots.txt`, favicon, logo, foto hero, dan SVG ilustrasi produk adalah aset/metadata, bukan logika backend. SVG produk menampilkan ilustrasi produk di kartu beranda.
- `public/build/manifest.json` dan file bernama hash di `public/build/assets/` adalah output hasil build, bukan source yang sebaiknya diedit langsung.
- `.env` lokal tidak dimasukkan ke panduan karena dapat berisi password, key, dan kredensial. Jangan menyalin nilainya ke dokumentasi atau membagikannya.
- File framework/paket di `vendor/` dan `node_modules/` sengaja tidak didokumentasikan per file. Isinya kode milik dependency, jumlahnya sangat banyak, dan bukan kode aplikasi SMAART. Kode generated/cache serta file log juga bukan sumber fitur aplikasi.

Dengan batas tersebut, cakupan panduan adalah kode aplikasi dan konfigurasi yang berada di `app/`, `routes/`, `database/`, `resources/`, CSS/JavaScript publik, `config/`, `bootstrap/app.php`, entry point, dan test yang terlihat di proyek. Setiap file pada kelompok itu telah dipetakan berdasarkan inventaris workspace; jika ada file baru atau belum tersimpan di editor, isinya belum tercakup sampai file tersebut tersedia di folder proyek.
