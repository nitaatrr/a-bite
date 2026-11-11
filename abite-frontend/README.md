# A-BITE Frontend

Frontend prototype responsif berdasarkan referensi desain pada PDF A-BITE.

## Menjalankan

1. Buka folder `abite-frontend`.
2. Klik dua kali `index.html`, atau jalankan Live Server di VS Code.

Tidak membutuhkan Composer, npm, database, atau backend untuk preview.

## Halaman yang tersedia
- Pelanggan: login, daftar, katalog menu, keranjang, checkout, pesanan, pelacakan.
- Admin: dashboard, kelola menu, edit menu, pesanan & driver, voucher.
- Manager: statistik, transaksi, laporan.
- Driver: daftar tugas, detail pengiriman, profil.

## Catatan integrasi Laravel
Ini adalah frontend prototype standalone. Belum terhubung ke route, controller, database, autentikasi, atau API Laravel. Untuk integrasi, pindahkan tampilan menjadi Blade dan sesuaikan action/form dengan route backend proyek A-BITE.
Gambar menu menggunakan URL Unsplash sehingga memerlukan koneksi internet.
