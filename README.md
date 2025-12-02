
## Dokumentasi Web Inventaris

Konsep Dari Web Yang Saya Buat

Web inventaris adalah website Untuk mendata barang apa saja yang ada diLab IPI, lalu barang yang rusak ada berapa , dan yang baik ada berapa , dikarenakan Diipi Mendata nya masih manual/diketik.

## cara mengithub
- buat folder di github
- lalu buka  project web-inventaris
- lgit init
- git add .
- git commit -m "Nama bebas"
- git branch -M main
- git remote add origin nama link github nya
- git push -u origin main

## Cara Setup project
 - mengclone project menggunakan git bash folder nya di xampp/htdocs lalu ketikan git clone https://github.com/MaulanaAsfarPraja/web-inventaris.git
 - buka project kamu di visual studio code, lalu ketikan diterminal composer install.
 - lalu benarkan env nya.
 - lalu ketikan php artisan key:generate
 - ke php my admin buat database nama nya harus sama dengan env 
 - lalu ketikan php artisan migrate
 - lalu ketikan php artisan db:seed --class=PetugasSeeder,php artisan db:seed --class=UserSeeder
 - habis itu php artisan serve
   
## Isi Dashboard

- Menampilkan Total Barang
- Menampilkan Total petugas
- menampilkan Berapa Barang Yang Rusak
- Menampilkan Persentase Rusak Dari Total

## Tools Yang Digunakan
- git hub
- visual studio code
- google crome
- laravel 10
- mysql


### ISI PROJECT
- Crud Daftar Barang
- Crud Status Barang
- transaksi (keluar masuk nya barang)
- crud Petugas

## ERD
Berikut adalah diagram ERD (Erd 3) untuk proyek ini:

![ERD 3](Erd_dan_UML/erd3.png)

## UML
Berikut adalah diagram UML Use Case 

![umlplant](Erd_dan_UML/umlplant.png)

## Login
        Admin
Email : admin@gmail.com
Password : 12345678

        Petugas
Email : petugas123@gmail.com
Password : 123456789

Penjelasan saya sudah sampai disini mohon maaf bila ada kesalahan,terimakasih bapak/ibu guru.