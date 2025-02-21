
#  Aplikasi Galeri Foto
Aplikasi Galeri Foto ini adalah aplikasi yang digunakan untuk ujian komprehensif (Ujikom) untuk tujuan pembelajaran dan evaluasi. Aplikasi ini dibuatkan untuk user dapat melihat foto-foto yang diupload oleh user lain.

##  Persyaratan
Sebelum memulai, pastikan Anda memiliki:
-  **PHP** (Disarankan versi terbaru)
-  **Composer**
-  **Node.js** dan **NPM**
-  **XAMPP** (atau server lokal dengan PHP dan MySQL)

##  Instalasi
Ikuti langkah-langkah berikut untuk menginstal aplikasi:

- Clone repositori ini ke komputer Anda:
```bash
https://github.com/orenjerry/allbany_ujikom_galeri.git
```

- Masuk ke direktori proyek:
```bash
cd  allbany_ujikom_galeri
```

- Install dependencies dengan Composer dan NPM:
```bash
composer install

npm install
```

- Buat file baru bernama `.env` dan isi dengan yang ada di `.env.example`

- Setelah membuat file `.env` selanjutnya kita perlu menggenerate key dengan
```bash
php artisan key:generate
```

- Migrasi database dan seeding data:
```bash

php artisan  migrate  --seed

```
- Jika terdapat pesan
```bash
   WARN  The database 'allbany_gallery' does not exist on the 'mysql' connection.  

 ┌ Would you like to create it? ────────────────────────────────┐
 │ ● Yes / ○ No                                                 │
 └──────────────────────────────────────────────────────────────┘
```
Tekan enter saja untuk membuat database dengan sendirinya

- Jalankan server Laravel:
```bash
php artisan serve
```

- Jalankan Vite untuk membangun asset frontend:
```bash
npm run dev
```

##  Login
Gunakan kredensial berikut untuk masuk ke aplikasi:

### Superadmin :
-  **Username** : superadmin
-  **Password** : password
### User :
- **Username** : user
-  **Password** : password

Setelah berhasil login, Anda akan diarahkan ke halaman utama aplikasi kasir.

##  Fitur Yang Tersedia
### Fitur Guest (Tamu)
- Guest hanya dapat melihat foto-foto yang ada di dalam aplikasi, dan melihat detail foto.
### Fitur User
- User dapat menambahkan like, komen pada foto
- User dapat menambahkan album dan mengubah album
- User dapat mengubah data pribadinya
### Fitur Superadmin
- Superadmin dapat mengakses dashboard admin yang berisi untuk menerima dan menolak Akun yang baru mendaftar ke aplikasi
- Superadmin dapat menghapus foto user yang tidak sesuai dengan peraturan aplikasi

##  Lisensi
Proyek ini dibuat untuk keperluan pembelajaran dan ujian komprehensif (Ujikom).
