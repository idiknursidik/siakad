# Sistem Informasi Akademik - Feeder menggunakan framework CodeIgniter 4 dan dashboard AdminLTE

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible, and secure. 
More information can be found at the [official site](http://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the 
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [the announcement](http://forum.codeigniter.com/thread-62615.html) on the forums.

The user guide corresponding to this version of the framework can be found
[here](https://codeigniter4.github.io/userguide/). 


## Server Requirements

PHP version 7.2 or higher is required, with the following extensions installed: 

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)
# Dashboard Framework

- https://adminlte.io/

# Web server bagi yang menggunakan windows

Silahkan menggunakan XAMPP terbaru 
- https://www.apachefriends.org/index.html

# Instalasi SIAKAD-FEEDER
- Download XAMPP 
- Install XAMPP
- Download SIAKAD-FEEDER
- Simpan di C:\xampp\htdocs
- ekstrak hasil download, rename "siakad-master" menjadi "siakad"
- pada folder C:\xampp\htdocs\siakad - cari file "env.txt" ubah menjadi ".env"
- buka http://localhost/phpmyadmin/
- buat database "siakad"
- import "siakad.sql"
- Buka http://localhost/siakad
- Login username dan password = admin
- Jika di hosting ada beberapa error contoh database.default.hostname = localhost ubah jadi 127.0.0.1

# Mengaktifkan extension php_intl.dll
- Masuk ke folder xampp/php/php.ini
- Cari ;extension=php_intl.dll
- hapus ;
- Restart Apache

# Tampilan 
![Alt text](https://github.com/github/{repository}/blob/assets/cat.png  "Title")
