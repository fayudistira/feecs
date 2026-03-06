# Dokumentasi SOSCT - School of Studies of Chinese Taiwan

## Pendahuluan

SOSCT (School of Studies of Chinese Taiwan) adalah aplikasi manajemen pendidikan berbasis web yang dirancang untuk mengelola seluruh aspek operasional lembaga pendidikan bahasa, khususnya bahasa Mandarin dan bahasa internasional lainnya. Aplikasi ini dibangun menggunakan framework CodeIgniter 4 dengan arsitektur modular yang memungkinkan pengembangan dan pemeliharaan kode yang lebih terstruktur.

Dokumentasi ini menjelaskan secara komprehensif setiap modul yang tersedia dalam aplikasi SOSCT, termasuk fitur-fitur utama, route URL, dan alur kerja masing-masing modul. Aplikasi ini mencakup 15 modul utama yang akan dibahas satu per satu dalam dokumen ini.

---

## Daftar Isi

1. [Modul Account](#modul-account)
2. [Modul Admission](#modul-admission)
3. [Modul Blog](#modul-blog)
4. [Modul Classroom](#modul-classroom)
5. [Modul Dashboard](#modul-dashboard)
6. [Modul Dormitory](#modul-dormitory)
7. [Modul Employee](#modul-employee)
8. [Modul Frontend](#modul-frontend)
9. [Modul Messaging](#modul-messaging)
10. [Modul Notification](#modul-notification)
11. [Modul Payment](#modul-payment)
12. [Modul Program](#modul-program)
13. [Modul Settings](#modul-settings)
14. [Modul Student](#modul-student)
15. [Modul Tools](#modul-tools)

---

## Modul Account

### Deskripsi

Modul Account berfungsi untuk mengelola profil pengguna dalam sistem. Setiap pengguna yang terdaftar dalam sistem SOSCT dapat memiliki profil yang menyimpan informasi pribadi mereka, termasuk foto, data identitas, dan dokumen pendukung. Modul ini terintegrasi dengan sistem autentikasi Shield bawaan CodeIgniter untuk mengelola akses dan otorisasi pengguna.

### Fitur Utama

**1. Manajemen Profil**
Modul ini memungkinkan pengguna untuk membuat, melihat, dan mengedit profil pribadi mereka. Data profil mencakup:

- Nama lengkap dan nama panggilan
- Jenis kelamin
- Tempat dan tanggal lahir
- Agama
- Nomor KTP/SIM
- Nomor telepon
- Alamat email
- Alamat lengkap (jalan, kelurahan, kecamatan, kota, provinsi, kode pos)
- Kontak darurat (nama, telepon, hubungan)
- Nama ayah dan ibu

**2. Upload Foto dan Dokumen**
Pengguna dapat mengunggah foto profil dan dokumen pendukung seperti:

- Foto terbaru
- Scan KTP
- Ijazah terakhir
- Dokumen lainnya

Semua file akan diproses dan disimpan di direktori yang sesuai dengan nomor registrasi sebagai penamaan file.

**3. API Profile**
Modul menyediakan API endpoints untuk manajemen profil yang memungkinkan:

- Mengambil daftar profil
- Mencari profil berdasarkan kriteria
- Membuat profil baru
- Memperbarui profil yang ada
- Menghapus profil

### Route URL

```
GET    /account              - Menampilkan halaman profil pengguna
GET    /account/create      - Formulir pembuatan profil
POST   /account/store       - Menyimpan profil baru
GET    /account/edit        - Formulir pengeditan profil
POST   /account/update      - Memperbarui profil

GET    /api/profiles        - API: Daftar semua profil
POST   /api/profiles        - API: Membuat profil baru
GET    /api/profiles/search - API: Mencari profil
GET    /api/profiles/:id    - API: Menampilkan profil tertentu
PUT    /api/profiles/:id    - API: Memperbarui profil
DELETE /api/profiles/:id    - API: Menghapus profil
GET    /api/profiles/me     - API: Profil pengguna saat ini
PUT    /api/profiles/me     - API: Memperbarui profil pengguna saat ini
```

### Model Database

Modul ini menggunakan tabel `profiles` yang menyimpan semua informasi profil pengguna. Setiap profil memiliki relasi one-to-one dengan tabel users untuk integrasi dengan sistem autentikasi.

---

## Modul Admission

### Deskripsi

Modul Admission adalah salah satu modul paling penting dalam sistem SOSCT. Modul ini mengelola seluruh proses penerimaan siswa baru mulai dari pendaftaran awal hingga persetujuan akhir. Modul ini bekerja sama dengan modul lain seperti Account, Program, dan Payment untuk menciptakan alur penerimaan yang lengkap.

### Fitur Utama

**1. Pendaftaran Siswa Baru**
Calon siswa dapat melakukan pendaftaran melalui dua jalur:

- **Pendaftaran Online**: Melalui halaman `/apply` di frontend
- **Pendaftaran Manual**: Melalui panel admin

Data yang dikumpulkan meliputi:

- Data pribadi lengkap
- Pilihan program kursus
- Foto dan dokumen persyaratan
- Tanggal mulai yang diinginkan

**2. Manajemen Pendaftaran**
Admin dapat mengelola semua pendaftaran dengan fitur:

- Melihat daftar semua pendaftaran dengan filter status
- Melihat detail setiap pendaftaran termasuk dokumen
- Mengunduh dokumen pelamar
- Mengedit informasi pendaftaran
- Memperbarui status pendaftaran (pending, approved, rejected)
- Menambahkan catatan dan notas

**3. Alur Kerja Otomatis**
Ketika pendaftaran disetujui, sistem secara otomatis:

- Membuat profil calon siswa
- Membuat nomor registrasi unik
- Membuat data angsuran (installment)
- Menghasilkan faktur (invoice) biaya pendaftaran dan tuition
- Mengirim notifikasi email ke pelamar

**4. Program Switching**
Modul ini mendukung perpindahan program bagi siswa yang sudah terdaftar:

- Admin dapat memproses perpindahan dari satu program ke program lain
- Sistem akan menyesuaikan kontrak biaya jika diperlukan
- Riwayat perpindahan program disimpan untuk keperluan audit

**5. Promosi ke Siswa**
Pendaftaran yang sudah disetujui dapat dipromosikan menjadi siswa resmi dengan:

- Membuat akun login berbasis nomor KTP
- Password default adalah nomor telepon
- Menambahkan ke grup "student" dalam sistem
- Membuat record student dengan nomor siswa unik

### Route URL

```
GET    /admission                     - Daftar semua pendaftaran
GET    /admission/view/:id            - Melihat detail pendaftaran
GET    /admission/download/:id/:file  - Mengunduh dokumen
GET    /admission/create              - Formulir pendaftaran manual
POST   /admission/store               - Menyimpan pendaftaran baru
GET    /admission/edit/:id            - Formulir pengeditan
POST   /admission/update/:id          - Memperbarui pendaftaran
GET    /admission/promote/:id         - Formulir promosi ke siswa
POST   /admission/process_promotion/:id - Memproses promosi
POST   /admission/update-status       - Endpoint AJAX untuk update status
DELETE /admission/delete/:id          - Menghapus pendaftaran
GET    /admission/search              - Mencari pendaftaran
GET    /admission/ajax-search         - Pencarian AJAX
GET    /admission/switch/:id          - Formulir perpindahan program
POST   /admission/switch/:id         - Memproses perpindahan program
GET    /admission/switch-history/:id - Riwayat perpindahan program

GET    /api/admissions                - API: Daftar pendaftaran
POST   /api/admissions               - API: Membuat pendaftaran
GET    /api/admissions/search         - API: Mencari pendaftaran
GET    /api/admissions/filter         - API: Filter pendaftaran
GET    /api/admissions/statistics     - API: Statistik pendaftaran
GET    /api/admissions/:id           - API: Detail pendaftaran
PUT    /api/admissions/:id           - API: Memperbarui pendaftaran
DELETE /api/admissions/:id           - API: Menghapus pendaftaran
POST   /api/admissions/:id/approve   - API: Menyetujuikan pendaftaran
POST   /api/admissions/:id/reject    - API: Menolak pendaftaran
POST   /api/admissions/:id/promote   - API: Mempromosikan ke siswa
```

### Model Database

Modul ini menggunakan tabel:

- `admissions`: Data utama pendaftaran
- `profiles`: Profil pelamar (integrasi dengan Modul Account)
- `programs`: Program yang dipilih
- `installments`: Rencana pembayaran
- `invoices`: Faktur yang dihasilkan

---

## Modul Blog

### Deskripsi

Modul Blog menyediakan sistem manajemen konten untuk mempublikasikan artikel, berita, dan informasi di website publik. Modul ini dirancang untuk mendukung content marketing dan komunikasi dengan calon siswa serta masyarakat umum.

### Fitur Utama

**1. Manajemen Artikel**

- Membuat artikel baru dengan editor konten lengkap
- Mengatur slug URL untuk SEO
- Menambahkan gambar utama (featured image)
- Menulis ringkasan (excerpt)
- Mengatur meta title dan meta description untuk SEO
- Status publikasi (draft/published)
- Opsi artikel andalan (featured)

**2. Kategori dan Tag**

- Membuat dan mengelola kategori artikel
- Membuat dan mengelola tag
- Relasi many-to-many antara artikel dan tag
- Statistik jumlah artikel per kategori

**3. Fitur AI (Placeholder)**

- Generasi ringkasan otomatis (placeholder untuk integrasi AI)
- Ekstraksi kata kunci otomatis (placeholder untuk integrasi AI)

**4. Statistik dan Analisis**

- Menghitung total artikel
- Melihat artikel terpopuler
- Statistik pembacaan

**5. RSS Feed dan Sitemap**

- Menghasilkan RSS feed untuk artikel
- Menghasilkan sitemap.xml untuk SEO

### Route URL

```
# Admin Routes
GET    /admin/blog                  - Dashboard blog
GET    /admin/blog/create           - Formulir artikel baru
POST   /admin/blog/store            - Menyimpan artikel
GET    /admin/blog/edit/:id         - Formulir pengeditan
POST   /admin/blog/update/:id       - Memperbarui artikel
POST   /admin/blog/delete/:id       - Menghapus artikel
POST   /admin/blog/toggle/:id      - Toggle publish status
POST   /admin/blog/feature/:id     - Toggle featured status
GET    /admin/blog/categories       - Kelola kategori
POST   /admin/blog/categories/store - Menyimpan kategori
POST   /admin/blog/categories/delete/:id - Hapus kategori
GET    /admin/blog/tags            - Kelola tag
POST   /admin/blog/tags/store      - Menyimpan tag
POST   /admin/blog/ai/generate-summary - AI: Generate ringkasan
POST   /admin/blog/ai/extract-keywords - AI: Ekstraksi keyword
GET    /admin/blog/stats           - Statistik blog

# Public Routes
GET    /blog                       - Halaman utama blog
GET    /blog/:slug                 - Detail artikel
GET    /blog/category/:slug        - Artikel berdasarkan kategori
GET    /blog/tag/:slug             - Artikel berdasarkan tag
GET    /blog/search                - Pencarian artikel
GET    /blog/feed                  - RSS Feed

# API Routes
GET    /api/blog/posts             - API: Daftar artikel
GET    /api/blog/posts/:slug       - API: Detail artikel
GET    /api/blog/posts/featured    - API: Artikel andalan
GET    /api/blog/categories        - API: Daftar kategori
GET    /api/blog/tags              - API: Daftar tag
GET    /api/blog/search            - API: Pencarian
```

---

## Modul Classroom

### Deskripsi

Modul Classroom digunakan untuk mengelola data ruang kelas, jadwal pembelajaran, dan keanggotaan siswa dalam setiap kelas. Modul ini memungkinkan administrator untuk mengatur struktur kelas dengan lebih efisien.

### Fitur Utama

**1. Manajemen Ruang Kelas**

- Membuat ruang kelas baru dengan detail lengkap
- Menentukan kapasitas maksimal
- Menambahkan deskripsi dan fasilitas
- Mengatur status ruang kelas (available, in use, maintenance)

**2. Penjadwalan**

- Mengatur jadwal pelajaran per kelas
- Menentukan mata pelajaran
- Menambahkan instruktur/pengajar
- Menentukan waktu pembelajaran

**3. Keanggotaan Kelas**

- Menambahkan siswa ke kelas tertentu
- Melihat daftar anggota kelas
- Menghapus anggota kelas

### Route URL

```
GET    /classroom                  - Daftar ruang kelas
GET    /classroom/create           - Formulir pembuatan kelas
POST   /classroom/store            - Menyimpan kelas baru
GET    /classroom/show/:id         - Detail kelas
GET    /classroom/edit/:id         - Formulir pengeditan
POST   /classroom/update/:id       - Memperbarui kelas
POST   /classroom/delete/:id      - Menghapus kelas

GET    /api/classrooms             - API: Daftar ruang kelas
GET    /api/classrooms/:id         - API: Detail kelas
POST   /api/classrooms             - API: Membuat kelas
PUT    /api/classrooms/:id         - API: Memperbarui kelas
DELETE /api/classrooms/:id         - API: Menghapus kelas

GET    /my/class                   - Kelas siswa saat ini
GET    /my/class/summary           - Ringkasan kelas siswa
```

---

## Modul Dashboard

### Deskripsi

Modul Dashboard adalah halaman utama yang ditampilkan setelah pengguna login. Modul ini memberikan gambaran umum tentang berbagai aspek sistem berdasarkan peran dan izin pengguna yang login.

### Fitur Utama

**1. Statistik Admission**

- Jumlah pendaftaran berdasarkan status (pending, approved, rejected)
- Grafik tren pendaftaran

**2. Statistik Program**

- Distribusi siswa per program
- Program yang paling populer

**3. Statistik Pembayaran**

- Total pendapatan dalam periode tertentu
- Pendapatan berdasarkan metode pembayaran
- Invoice yang overdue
- Tren pendapatan bulanan

**4. Widget Informasi**

- Pendaftaran terbaru
- Pembayaran terbaru
- Invoice overdue

### Route URL

```
GET    /dashboard                  - Halaman utama dashboard

GET    /api/dashboard/stats        - API: Statistik keseluruhan
GET    /api/dashboard/overview    - API: Ringkasan overview
GET    /api/dashboard/recent-admissions  - API: Pendaftaran terbaru
GET    /api/dashboard/recent-payments    - API: Pembayaran terbaru
GET    /api/dashboard/overdue-invoices   - API: Invoice overdue
GET    /api/dashboard/revenue-chart      - API: Grafik pendapatan
GET    /api/dashboard/admissions-chart   - API: Grafik pendaftaran
```

---

## Modul Dormitory

### Deskripsi

Modul Dormitory mengelola informasi asrama untuk siswa yang membutuhkan tempat tinggal selama masa pendidikan. Modul ini mencakup manajemen kamar asrama, penempatan siswa, dan pelacakan fasilitas yang tersedia.

### Fitur Utama

**1. Manajemen Asrama**

- Menambahkan asrama baru dengan detail lengkap
- Menentukan lokasi dan kapasitas kamar
- Menambahkan URL peta (Google Maps)
- Mengatur fasilitas kamar (AC, WiFi, kamar mandi, dll)
- Mengunggah galeri foto
- Mengatur status kamar (available, full, maintenance, inactive)

**2. Penempatan Siswa**

- Menempatkan siswa ke kamar asrama
- Menentukan tanggal mulai dan akhir tinggal
- Menambahkan catatan khusus
- Membatalkan/menghapus penempatan

**3. Pencarian dan Pelacakan**

- Mencari siswa berdasarkan nama atau nomor registrasi
- Melihat riwayat penempatan asrama siswa
- Melihat kapasitas terpakai dan tersedia

**4. Bulk Upload**

- Mengunggah data asrama dalam jumlah besar menggunakan file Excel
- Template download untuk format yang benar

### Route URL

```
GET    /dormitory                  - Daftar asrama
GET    /dormitory/create           - Formulir pembuatan asrama
POST   /dormitory/store            - Menyimpan asrama baru
GET    /dormitory/show/:id         - Detail asrama
GET    /dormitory/edit/:id         - Formulir pengeditan
POST   /dormitory/update/:id       - Memperbarui asrama
POST   /dormitory/delete/:id      - Menghapus asrama
GET    /dormitory/download-template - Download template Excel
POST   /dormitory/bulk-upload      - Upload bulk data asrama

GET    /dormitory/assignments/:id  - Kelola penempatan siswa
POST   /dormitory/assign/:id       - Menempatkan siswa
POST   /dormitory/unassign/:id     - Membatalkan penempatan

GET    /dormitory/search           - Pencarian siswa asrama
GET    /dormitory/student/:id      - Detail penempatan siswa

GET    /dormitories                - Halaman publik asrama
GET    /dormitories/:slug          - Detail asrama (publik)

GET    /api/dormitories            - API: Daftar asrama
GET    /api/dormitories/available  - API: Asrama tersedia
GET    /api/dormitories/:id        - API: Detail asrama
POST   /api/dormitories            - API: Membuat asrama
PUT    /api/dormitories/:id        - API: Memperbarui asrama
DELETE /api/dormitories/:id        - API: Menghapus asrama
POST   /api/dormitories/:id/assign - API: Menempatkan siswa
POST   /api/dormitories/:id/unassign - API: Membatalkan penempatan
```

---

## Modul Employee

### Deskripsi

Modul Employee mengelola data karyawan dan staf lembaga pendidikan. Modul ini mencakup informasi pribadi, data pekerjaan, dan integrasi dengan sistem autentikasi untuk memberikan akses login kepada karyawan.

### Fitur Utama

**1. Manajemen Karyawan**

- Menambahkan karyawan baru dengan data lengkap
- Mengelola informasi pribadi dan kontak
- Mengatur data pekerjaan (jabatan, departemen, tipe kerja)
- Mengatur status kepegawaian (active, inactive, resigned, terminated)

**2. Integrasi Akun**

- Membuatkan akun login otomatis
- Username berdasarkan NIK/kartu identitas
- Password default yang dapat diubah
- Grup default: staff

**3. Unggah Dokumen**

- Foto profil karyawan
- Dokumen kepegawaian (kontrak, sertifikat, dll)

### Route URL

```
GET    /admin/employee             - Daftar karyawan
GET    /admin/employee/view/:id    - Detail karyawan
GET    /admin/employee/create      - Formulir penambahan karyawan
POST   /admin/employee/store       - Menyimpan karyawan baru
GET    /admin/employee/edit/:id    - Formulir pengeditan
POST   /admin/employee/update/:id - Memperbarui karyawan
DELETE /admin/employee/delete/:id - Menghapus karyawan

GET    /api/employees              - API: Daftar karyawan
GET    /api/employees/:id          - API: Detail karyawan
POST   /api/employees              - API: Membuat karyawan
PUT    /api/employees/:id          - API: Memperbarui karyawan
DELETE /api/employees/:id         - API: Menghapus karyawan
```

---

## Modul Frontend

### Deskripsi

Modul Frontend menangani semua halaman yang dapat diakses oleh publik (tidak memerlukan login). Modul ini mencakup halaman beranda, tentang kami, kontak, program, dan formulir pendaftaran online.

### Fitur Utama

**1. Halaman Publik**

- **Home (/):** Menampilkan informasi lengkap termasuk program yang tersedia dan artikel blog terbaru
- **About (/about):** Informasi tentang lembaga pendidikan
- **Contact (/contact):** Formulir kontak dan informasi lokasi
- **Programs (/programs):** Daftar semua program yang tersedia
- **Program Detail (/programs/:slug):** Detail lengkap satu program

**2. Halaman Khusus Bahasa**

- **Mandarin (/mandarin):** Landing page khusus kursus Mandarin
- **Japanese (/japanese):** Landing page khusus kursus Jepang
- **Korean (/korean):** Landing page khusus kursus Korea
- **German (/german):** Landing page khusus kursus Jerman
- **English (/english):** Landing page khusus kursus Inggris

**3. Formulir Pendaftaran Online (/apply)**

- Menampilkan pilihan program yang tersedia
- Formulir lengkap untuk pendaftaran siswa baru
- Upload foto dan dokumen persyaratan
- Persetujuan syarat dan ketentuan
- Konfirmasi otomatis via email setelah submit
- Generate faktur otomatis

### Route URL

```
GET    /                           - Halaman utama/homepage
GET    /about                      - Halaman tentang kami
GET    /contact                   - Halaman kontak
GET    /programs                  - Daftar program
GET    /programs/:slug             - Detail program

GET    /mandarin                   - Landing page Mandarin
GET    /japanese                   - Landing page Jepang
GET    /korean                     - Landing page Korea
GET    /german                     - Landing page Jerman
GET    /english                    - Landing page Inggris

GET    /apply                      - Formulir pendaftaran
POST   /apply/submit               - Submit formulir pendaftaran
GET    /apply/success              - Halaman sukses setelah daftar
GET    /apply/:program_id          - Formulir dengan program pra-pilih

GET    /frontend/api/recent-admissions - API: Pendaftaran terbaru (publik)
```

---

## Modul Messaging

### Deskripsi

Modul Messaging menyediakan sistem pesan internal yang memungkinkan pengguna dalam sistem untuk berkomunikasi secara langsung. Fitur ini mendukung percakapan satu-ke-satu dan grup.

### Fitur Utama

**1. Percakapan**

- Membuat percakapan baru dengan pengguna lain
- Mengirim dan menerima pesan
- Melihat riwayat percakapan
- Menambahkan peserta ke percakapan grup

**2. Notifikasi Pesan**

- Penghitung pesan belum dibaca
- Penandaan pesan sebagai sudah dibaca

**3. Pencarian**

- Mencari pengguna untuk memulai percakapan
- Mencari riwayat pesan

### Route URL

```
GET    /messages                   - Daftar percakapan
GET    /messages/conversation/:id  - Detail percakapan
POST   /messages/create            - Membuat percakapan baru
POST   /messages/send              - Mengirim pesan

GET    /messages/api/conversations - API: Daftar percakapan
GET    /messages/api/messages/:id  - API: Pesan dalam percakapan
POST   /messages/api/mark-read     - API: Tandai sudah dibaca
GET    /messages/api/users/search  - API: Cari pengguna
GET    /messages/api/unread-count - API: Jumlah belum dibaca

GET    /api/messages/conversations - API: Daftar percakapan
POST   /api/messages/conversations - API: Buat percakapan
GET    /api/messages/conversations/:id - API: Detail percakapan
POST   /api/messages/conversations/:id/participants - API: Tambah peserta
POST   /api/messages/:id          - API: Kirim pesan
POST   /api/messages/:id/read     - API: Tandai dibaca
GET    /api/messages/unread       - API: Jumlah belum dibaca
```

---

## Modul Notification

### Deskripsi

Modul Notification mengelola sistem notifikasi dalam aplikasi. Notifikasi digunakan untuk menginformasikan pengguna tentang berbagai peristiwa penting seperti pendaftaran baru, pembayaran, dan aktivitas sistem lainnya.

### Fitur Utama

**1. Jenis Notifikasi**

- Notifikasi pendaftaran baru
- Notifikasi pembayaran masuk
- Notifikasi invoice overdue
- Notifikasi perubahan status

**2. Manajemen Notifikasi**

- Melihat semua notifikasi
- Menandai notifikasi sebagai sudah dibaca
- Menandai semua notifikasi sebagai sudah dibaca
- Penghitung notifikasi belum dibaca

### Route URL

```
GET    /notifications              - Halaman semua notifikasi

GET    /notifications/api/unread-count  - API: Jumlah belum dibaca
GET    /notifications/api/list          - API: Daftar notifikasi
POST   /notifications/api/mark-read/:id  - API: Tandai sudah dibaca
POST   /notifications/api/mark-all-read - API: Tandai semua dibaca
```

---

## Modul Payment

### Deskripsi

Modul Payment adalah modul paling kompleks dalam sistem SOSCT karena mengelola seluruh aspek keuangan termasuk invoice, pembayaran, angsuran, dan laporan keuangan. Modul ini bekerja dengan modul lain seperti Admission dan Student untuk memastikan integrasi data yang akurat.

### Fitur Utama

**1. Manajemen Invoice**

- Membuat invoice untuk biaya pendaftaran dan tuition
- Multiple item dalam satu invoice
- Struktur biaya terpisah (registration fee, tuition fee, dll)
- Status invoice (unpaid, partially_paid, paid, cancelled)
- Tanggal jatuh tempo
- Perpanjangan jatuh tempo (extend)
- Pembatalan invoice
- Generate PDF invoice

**2. Manajemen Pembayaran**

- Mencatat pembayaran dari siswa
- Multiple metode pembayaran (tunai, transfer bank, e-wallet, kartu kredit)
- Nomor bukti pembayaran
- Upload bukti pembayaran (receipt)
- Status pembayaran (pending, paid, failed)

**3. Sistem Angsuran (Installments)**

- Membuat rencana angsuran
- Melacak total kontrak, total terbayar, dan sisa tagihan
- Multiple invoice per angsuran (untuk perpindahan program)
- Status angsuran (unpaid, partially_paid, paid)

**4. Laporan Keuangan**

- Laporan pendapatan dengan filter tanggal
- Pendapatan berdasarkan metode pembayaran
- Pendapatan berdasarkan tipe biaya
- Tren pendapatan bulanan
- Laporan invoice overdue
- Export data ke CSV

**5. Akses Publik**

- Tampilan invoice publik (tanpa login)
- Tampilan receipt publik (tanpa login)
- QR code untuk akses mudah

**6. Kontrak**

- Melihat dan mencetak kontrak siswa

### Route URL

```
# Invoice Routes
GET    /invoice                    - Daftar invoice
GET    /invoice/view/:id           - Detail invoice
GET    /invoice/create            - Formulir pembuatan invoice
POST   /invoice/store              - Menyimpan invoice
GET    /invoice/edit/:id           - Formulir pengeditan
POST   /invoice/update/:id         - Memperbarui invoice
GET    /invoice/cancel/:id         - Membatalkan invoice
GET    /invoice/pdf/:id            - Download PDF invoice
GET    /invoice/reissue/:id         - Formulir reissue
POST   /invoice/process-reissue   - Proses reissue
GET    /invoice/extend            - Formulir perpanjangan
POST   /invoice/bulk-extend-store - Bulk perpanjangan
GET    /invoice/student-invoices  - Invoice siswa tertentu
GET    /invoice/invoice-summary   - Ringkasan invoice

# Payment Routes
GET    /payment                    - Daftar pembayaran
GET    /payment/view/:id           - Detail pembayaran
GET    /payment/create            - Formulir pembuatan
POST   /payment/store              - Menyimpan pembayaran
GET    /payment/edit/:id           - Formulir pengeditan
POST   /payment/update/:id         - Memperbarui pembayaran
GET    /payment/receipt/:id        - Tampilan receipt

# Reports
GET    /payment/reports/revenue    - Laporan pendapatan
GET    /payment/reports/overdue    - Laporan overdue
GET    /payment/reports/export     - Export laporan

# Public Routes
GET    /invoice/public/:id         - Invoice publik
GET    /invoice/secure/:id         - Invoice aman (dengan token)
GET    /invoice/qr/:id             - QR code invoice
GET    /payment/public/:id         - Receipt publik
GET    /payment/secure/:id         - Receipt aman

# Student Routes
GET    /my/invoices               - Invoice siswa
GET    /my/invoices/:id           - Detail invoice siswa
GET    /my/payments                - Pembayaran siswa
GET    /my/payments/:id           - Detail pembayaran siswa

# Contract Routes
GET    /contract                   - Daftar kontrak
GET    /contract/view/:id          - Detail kontrak
GET    /contract/print/:id         - Print kontrak

# API Routes
GET    /api/payments               - API: Daftar pembayaran
GET    /api/payments/:id           - API: Detail pembayaran
POST   /api/payments              - API: Membuat pembayaran
PUT    /api/payments/:id           - API: Memperbarui pembayaran
GET    /api/payments/search       - API: Cari pembayaran
GET    /api/payments/statistics   - API: Statistik pembayaran
POST   /api/payments/:id/receipt  - API: Upload receipt

GET    /api/invoices               - API: Daftar invoice
POST   /api/invoices               - API: Membuat invoice
GET    /api/invoices/search        - API: Cari invoice
GET    /api/invoices/overdue       - API: Invoice overdue
GET    /api/invoices/:id/pdf       - API: Generate PDF

GET    /api/installments           - API: Daftar angsuran
GET    /api/installments/:id       - API: Detail angsuran
```

---

## Modul Program

### Deskripsi

Modul Program mengelola semua program kursus yang ditawarkan oleh lembaga. Modul ini memungkinkan administrator untuk membuat, mengedit, dan mengatur program dengan detail lengkap termasuk biaya, durasi, dan kurikulum.

### Fitur Utama

**1. Manajemen Program**

- Membuat program baru dengan detail lengkap
- Judul dan deskripsi program
- Biaya pendaftaran (registration fee)
- Biaya tuition (tuition fee)
- Diskon yang tersedia
- Durasi program
- Mode pembelajaran (offline, online)

**2. Kategorisasi**

- Bahasa (Mandarin, Jepang, Korea, Jerman, Inggris, dll)
- Level bahasa (Beginner, Intermediate, Advanced, All Levels)
- Kategori dan sub-kategori
- Status program (active, inactive)

**3. Detail Program**

- Fitur program
- Fasilitas yang disediakan
- Fasilitas tambahan
- Kurikulum (bab dan deskripsi)
- Thumbnail/gambar program

**4. Bulk Upload**

- Upload banyak program sekaligus menggunakan Excel
- Template download tersedia

### Route URL

```
GET    /program                   - Daftar program
GET    /program/view/:id          - Detail program
GET    /program/create            - Formulir pembuatan
POST   /program/store             - Menyimpan program
GET    /program/edit/:id          - Formulir pengeditan
POST   /program/update/:id       - Memperbarui program
GET    /program/delete/:id       - Menghapus program
GET    /program/download-template - Download template
POST   /program/bulk-upload       - Upload bulk program

GET    /api/programs              - API: Daftar program
GET    /api/programs/:id          - API: Detail program
POST   /api/programs              - API: Membuat program
PUT    /api/programs/:id          - API: Memperbarui program
DELETE /api/programs/:id          - API: Menghapus program
GET    /api/programs/active       - API: Program aktif
GET    /api/programs/categories   - API: Daftar kategori
GET    /api/programs/languages    - API: Daftar bahasa
GET    /api/programs/by-language  - API: Program berdasarkan bahasa
```

---

## Modul Settings

### Deskripsi

Modul Settings menyediakan fungsi administratif untuk pengelolaan sistem. Modul ini mencakup pengaturan umum, manajemen data uji, dan pembersihan data.

### Fitur Utama

**1. Dashboard Statistik**

- Menampilkan statistik tabel database
- Jumlah record di setiap tabel penting

**2. Pembuatan Data Uji**

- Generate data pendaftaran uji (test admissions)
- Generate data pembayaran uji (test payments)
- Validasi dan kontrol jumlah data

**3. Pembersihan Data**

- Menghapus semua data uji
- Pembersihan upload direktori
- Konfirmasi dengan teks "DELETE"

**4. Manajemen Syarat dan Ketentuan**

- Membuat syarat dan ketentuan per bahasa
- Mengatur konten dan status
- Toggle aktif/non-aktif

### Route URL

```
GET    /settings                  - Halaman pengaturan utama
GET    /settings/cleanup          - Halaman pembersihan data
POST   /settings/cleanup          - Proses pembersihan data
GET    /settings/test-data        - Halaman pembuatan data uji
POST   /settings/generate-test-data - Proses pembuatan data uji

GET    /settings/terms            - Kelola syarat dan ketentuan
GET    /settings/terms/create     - Formulir pembuatan
POST   /settings/terms/store      - Menyimpan syarat
GET    /settings/terms/edit/:id   - Formulir pengeditan
POST   /settings/terms/update/:id - Memperbarui syarat
POST   /settings/terms/delete/:id - Menghapus syarat
POST   /settings/terms/toggle/:id - Toggle status

GET    /settings/api/terms        - API: Daftar syarat (publik)
GET    /settings/api/terms/:slug - API: Detail syarat (publik)
```

---

## Modul Student

### Deskripsi

Modul Student mengelola data siswa yang telah resmi diterima setelah melalui proses admission. Modul ini berbeda dari Admission karena fokus pada pengelolaan siswa aktif yang sudah memiliki akun login dan status resmi.

### Fitur Utama

**1. Manajemen Data Siswa**

- Melihat daftar semua siswa
- Detail informasi siswa
- Status keanggotaan (active, inactive, graduated, etc.)
- IPK dan total SKS (jika applicable)
- Tanggal kelulusan

**2. Promosi dari Admission**

- Mempromosikan pendaftaran yang disetujui menjadi siswa resmi
- Membuat akun login otomatis (username = NIK, password = no telp)
- Menambahkan ke grup "student"
- Generate nomor siswa unik

**3. Relasi dengan Modul Lain**

- Melihat invoice siswa
- Melihat pembayaran siswa
- Melihat angsuran siswa

### Route URL

```
GET    /student                    - Daftar siswa
GET    /student/promote            - Formulir promosi siswa
POST   /student/do-promote         - Proses promosi
GET    /student/view/:id           - Detail siswa
GET    /student/edit/:id           - Formulir pengeditan
POST   /student/update/:id         - Memperbarui data siswa

GET    /api/students               - API: Daftar siswa
GET    /api/students/me            - API: Profil siswa saat ini
GET    /api/students/search       - API: Cari siswa
GET    /api/students/statistics   - API: Statistik siswa
GET    /api/students/:id          - API: Detail siswa
GET    /api/students/number/:no   - API: Siswa berdasarkan nomor
PUT    /api/students/:id          - API: Memperbarui siswa
DELETE /api/students/:id         - API: Menghapus siswa
GET    /api/students/:id/payments - API: Pembayaran siswa
GET    /api/students/:id/invoices - API: Invoice siswa
GET    /api/students/:id/installments - API: Angsuran siswa
```

---

## Modul Tools

### Deskripsi

Modul Tools menyediakan berbagai utility dan alat bantu untuk pengembangan dan penggunaan internal sistem. Modul ini mencakup beberapa alat yang berguna untuk berbagai keperluan.

### Fitur Utama

**1. API Tester**

- Menguji endpoint REST API
- Mendukung metode GET, POST, PUT, PATCH, DELETE
- Input header dan body
- Menampilkan response

**2. QR Code Generator**

- Membuat QR code untuk berbagai keperluan
- Mendukung URL, teks, dan link WhatsApp
- Custom ukuran dan format

**3. Image Converter**

- Mengkonversi gambar ke format WebP
- Batch processing untuk beberapa file
- Kompresi gambar

**4. Hanzi Flashcard**

- Kartu flash untuk belajar汉字 (character Mandarin)
- Mendukung level HSK
- Fitur belajar interaktif

### Route URL

```
GET    /tools                      - Halaman utama tools
GET    /tools/api-tester           - Halaman API Tester
GET    /tools/qrgen                - Halaman QR Code Generator
GET    /tools/imager               - Halaman Image Converter
GET    /tools/hanzi                - Halaman Hanzi Flashcard

# Hanzi Routes
GET    /tools/hanzi                - Daftar Hanzi
GET    /tools/hanzi/create         - Formulir pembuatan
POST   /tools/hanzi/create         - Menyimpan Hanzi
GET    /tools/hanzi/edit/:id       - Formulir pengeditan
POST   /tools/hanzi/edit/:id       - Memperbarui Hanzi
GET    /tools/hanzi/flashcards     - Mode flashcards
GET    /tools/hanzi/bulk-upload    - Upload bulk Hanzi
POST   /tools/hanzi/bulk-upload    - Proses upload bulk
DELETE /tools/hanzi/:id           - Menghapus Hanzi
```

---

## Integrasi Antar Modul

Sistem SOSCT dirancang dengan arsitektur modular namun tetap terintegrasi satu sama lain. Berikut adalah beberapa contoh integrasi penting:

### Alur Pendaftaran Lengkap

1. **Frontend** - Calon siswa mengisi formulir pendaftaran online
2. **Account** - Sistem membuat profil berdasarkan data formulir
3. **Admission** - Menerima dan menyimpan pendaftaran
4. **Payment** - Membuat invoice dan rencana angsuran
5. **Notification** - Mengirim notifikasi ke admin tentang pendaftaran baru
6. **Messaging** - Mengirim email konfirmasi ke calon siswa

### Alur Pembayaran

1. **Student/Admission** - Siswa melihat invoice
2. **Payment** - Admin mencatat pembayaran
3. **Payment** - Sistem mengupdate status invoice dan angsuran
4. **Admission** - Jika pembayaran pertama, status otomatis berubah menjadi approved
5. **Notification** - Mengirim notifikasi ke siswa

### Alur Promosi Siswa

1. **Admission** - Admin memilih pendaftaran yang akan dipromosikan
2. **Student** - Membuat record siswa baru
3. **Employee** - Membuat akun user dengan username NIK
4. **Account** - Menghubungkan profile dengan user ID

---

##Kesimpulan

Dokumentasi ini telah menjelaskan secara komprehensif 15 modul yang tersedia dalam aplikasi SOSCT. Setiap modul memiliki fungsi spesifik namun saling terintegrasi untuk menciptakan sistem manajemen pendidikan yang lengkap.

Untuk informasi lebih lanjut tentang implementasi teknis, API documentation terpisah tersedia di file `API_DOCUMENTATION.md`. Untuk informasi tentang alur aplikasi dan penggunaan, dapat dilihat di `APPLICATION_WORKFLOW.md`.

---

_Dokumen ini dibuat pada Maret 2026 untuk versi aplikasi SOSCT yang sedang dikembangkan._
