# TODO: Remove Super Admin & Ensure Doctor Dashboard

✅ Semua edits selesai! Doctor dashboard sudah ada di /dashboard/dokter.

Selanjutnya: Jalankan command ini untuk reseed roles/users:

```
php artisan cache:clear
php artisan permission:cache-reset
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=UserSeeder
```

Test: Login admin@rumahsakit.com / password, akses /dashboard (sekarang full admin access).
Dokter: ahmad.fauzi@rumahsakit.com / password → /dashboard/dokter (lihat appointments hari ini dll.).
