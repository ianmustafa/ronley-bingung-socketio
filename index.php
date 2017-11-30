<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main Notifikasi.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bulma untuk styling: https://bulma.io/ -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.1/css/bulma.min.css">
    <!-- Note.js untuk Notifikasi: https://chmln.github.io/Note.js/ -->
    <link rel="stylesheet" href="https://unpkg.com/Note.js@0.0.4/dist/note.css">

    <!-- CSS -->
    <style>
        /* Buat Flex container seukuran halaman */
        html, body {
            height: 100vh;
        }
        body {
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Kustomisasi Note.js */
        .note--container {
            top: 0;
            right: 0;
            font-family: inherit;
        }
        .note--body {
            font-weight: normal;
        }
        .note--body strong {
            color: #fff;
        }
    </style>
</head>
<body>
<div class="box">
    <h1 class="title">Tulis nama lalu kirim.</h1>
    <h2 class="subtitle">Gampang kan?</h2>
    <div class="field has-addons">
        <div class="control">
            <input id="inputNama" class="input" type="text" placeholder="Tulis nama">
        </div>
        <div class="control">
            <button id="kirimNotif" class="button is-info">Kirim notifikasi</button>
        </div>
    </div>
</div>

<!-- Note.js untuk Notifikasi: https://chmln.github.io/Note.js/ -->
<script src="https://unpkg.com/Note.js@0.0.4/dist/note.min.js"></script>
<!-- Axios untuk AJAX: https://github.com/axios/axios -->
<script src="https://unpkg.com/axios@0.17.1/dist/axios.min.js"></script>
<!-- Socket.IO Client. Sesuaikan alamatnya dengan host dan port yang sesuai -->
<script src="http://localhost:3002/socket.io/socket.io.js"></script>
<!-- JavaScript -->
<script>
// Socket.IO instance. Jangan lupa sesuaikan host dan port-nya juga
var io = io('http://localhost:3002/')
// Note.js instance
var note = new Note({
    // Set durasi ke 10 detik secara global
    duration: 10
})

var inputNama  = document.getElementById('inputNama')
var kirimNotif = document.getElementById('kirimNotif')

// Listen event 'click' dari button#kirimNotif
kirimNotif.addEventListener('click', function () {
    axios.post('proses.php', {
        nama_lengkap: inputNama.value
    }).then(function (response) {
        // Ambil pesan notifikasi dari response
        var message = response.data.message
        // Broadcast notifikasi sekarang!
        io.emit('notify', message)
    }).catch(function (error) {
        // Cuma ngambil dari sini: https://github.com/axios/axios#handling-errors
        if (error.response) {
            console.log('Response Error ' + error.response.status, error.response.data)
        } else if (error.request) {
            console.log('Request Error', error.request)
        } else {
            console.log('Error', error.message)
        }
    })
})

// Listen event 'notify' dari Socket.IO
io.on('notify', function (payload) {
// Tampilkan notifikasi dengan Note.js
note.info('Informasi', payload)
})
</script>
</body>
</html>
