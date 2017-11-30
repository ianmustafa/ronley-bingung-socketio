<?php

require 'core.php';

// Set timezone secara manual
date_default_timezone_set('Asia/Jakarta');

// Set locale untuk memformat tanggal dalam Bahasa Indonesia di PHP
// tanpa menambahkan library tertentu atau membuat implementasi
// terjemahan yang terkustomisasi. Cukup memakai strftime().
// Tapi cek dulu OS yang dipakai oleh web server.
if (stripos(PHP_OS, 'win') === 0) {
    // Gunakan ini jika web server memakai OS Windows family
    setlocale (LC_TIME, 'INDONESIA');
} else {
    // Gunakan ini jika web server memakai OS selain Windows family
    setlocale (LC_TIME, 'id_ID');
}

// Panggil PDO secara langsung disini
$pdo = require 'db.php';
