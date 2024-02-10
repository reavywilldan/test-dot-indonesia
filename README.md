step untuk menginstall

- gunakan git untuk men clone project ini
- setelah berhasil men clone masuk ke direktori project ini menggunakan terminal
- lakukan composer install untuk menginstall dependency php
- lakukan npm install untuk menginstall dependency js
- copy semua value dari .env.example dan paste kan ke dalam file baru .env
- sesuaikan env dengan engine anda
- lakukan php artisan migrate
- lakukan php artisan app:fetch-data-area untuk mengimport data dari rajaongkir
- lakukan php artisan db:seed --class=UsersTableSeeder
- env SOURCE_IMPLEMENTATION diisi dengan db / rajaongkir
- set header Accept application/json pada request /api/search/provinces dan /api/search/cities

data login untuk mendapatkan access token yang akan di set ke header bearer token ketika get province dan city

username: cek@mail.com
password: password
