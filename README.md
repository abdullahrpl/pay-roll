<br></br>
# 💼 Payroll Service App

Payroll Service App adalah sistem penggajian sederhana berbasis Laravel untuk membantu perusahaan dalam mengelola data karyawan, absensi, dan penggajian secara efisien. Aplikasi ini dikembangkan menggunakan Laravel dan antarmuka modern berbasis TailwindCSS.

<br></br>
## ✨ Fitur

### 1. **Manajemen Karyawan**
- Tambah, lihat, edit, dan hapus data karyawan.
- Detail karyawan ditampilkan dengan UI modern berupa kartu informasi.

### 2. **Manajemen Absensi**
- Rekap dan detail absensi per karyawan.
- Fitur pencarian dan filter absensi berdasarkan tanggal.
- Export data absensi ke PDF.

### 3. **Manajemen Gaji**
- Histori penggajian dengan tampilan tabel modern dan fitur filter.
- Rincian gaji karyawan lengkap beserta informasi absensi.

### 4. **Dashboard Admin**
- Tampilan dashboard ringkas dengan UI modern.
- Statistik jumlah karyawan, absensi hari ini, dan total gaji dibayarkan.

### 5. **Otentikasi dan Hak Akses**
- Sistem login.
- Role akses untuk admin dan user (akan dikembangkan).

<br></br>
## 🔧 Teknologi yang Digunakan
- **Backend**: Laravel 11.x
- **Frontend**: Blade + TailwindCSS + Alpine.js
- **Database**: MySQL / MariaDB
- **PDF Export**: DomPDF
- **UI Komponen**: Custom dan TailwindCSS

<br></br>
## 🚀 Cara Menjalankan Proyek

1. **Clone Repository**
```bash
git clone https://github.com/abdullahrpl/pay-roll.git
```

2. **Masuk ke direktori proyek dan install dependency**
```bash
cd pay-roll
composer install
npm install && npm run build
```

3. **Salin file .env dan generate key**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Setup Database dan Migrasi**
```bash
php artisan migrate --seed
```

5. **Jalankan Server**
```bash
php artisan serve
```

<br></br>
## 👤 Akun Demo (Jika Ada)

### Admin

- **Email**: `admin@example.com`  
- **Password**: `admin123`

### User

- **Email**: `karyawan@example.com`  
- **Password**: `karyawan123`

Belum tersedia. Anda dapat menambahkan data pengguna secara manual atau menggunakan seeder.

<br></br>

## 🤝 Kontribusi

Jika Anda ingin berkontribusi:

1. Fork repositori ini.
2. Buat branch fitur baru:
```bash
git checkout -b fitur-anda
```
3. Commit perubahan Anda:
```bash
git commit -m "Menambahkan fitur baru"
```
4. Push ke repository Anda:
```bash
git push origin fitur-anda
```
5. Buat Pull Request.

<br></br>
## 📄 Lisensi

Proyek ini berlisensi [MIT License](https://opensource.org/licenses/MIT)
