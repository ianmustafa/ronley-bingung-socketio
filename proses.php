<?php

require 'includes/boot.php';

// Kita pakai HTTP request method sesuai spek RESTful:
// - GET untuk ambil semua data (tidak dipakai disini)
// - GET dengan parameter id untuk ambil satu data (tidak dipakai disini)
// - POST untuk tambah data
// - PATCH untuk ubah data (tidak dipakai disini)
// - DELETE untuk hapus data (tidak dipakai disini)
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        // Filter data yang masuk dengan parse_input(), untuk memastikan
        // hanya input dengan nama 'nama_lengkap' yang boleh masuk
        $input = parse_input(['nama_lengkap']);

        // Set waktu dan tambahkan ke input
        $waktu = time();
        $input['waktu'] = date('Y-m-d H:i:s', $waktu);

        // Simpan data
        $stmt = $pdo->prepare('INSERT INTO notifikasi (nama_lengkap, waktu) VALUES (:nama_lengkap, :waktu)');
        $stmt->execute($input);

        // Siapkan pesan respon
        $message = 'Notifikasi telah dikirim pada <strong>' .
                    ltrim(strftime('%d %B %Y %H:%M:%S', $waktu), '0') .
                   '</strong> oleh <strong>' .$input['nama_lengkap'] . '</strong>.';

        response(compact('message'), 201);
        break;

    default:
        response(['message' => 'Metode HTTP tidak bisa diterima.'], 405);
}
