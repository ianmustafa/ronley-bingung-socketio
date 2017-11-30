var app  = require('express')()
var http = require('http').Server(app)
var io   = require('socket.io')(http)
// Express Body Parser untuk ambil parameter dari POST:
// https://scotch.io/tutorials/use-expressjs-to-get-url-and-post-parameters#toc-post-parameters
var bodyParser = require('body-parser')
// date-fns untuk memformat tanggal: https://date-fns.org/
var format = require('date-fns/format')
var idLocale = require('date-fns/locale/id')

app.use(bodyParser.json())
app.use(bodyParser.urlencoded({ extended: true }))

app.get('/', function(req, res) {
  res.sendFile(__dirname + '/templates/index.html')
})

app.post('/proses', function(req, res) {
  // Susun data yang akan dipakai sebagai response
  var payload = {
    message: 'Notifikasi telah dikirim pada <strong>' +
             format(new Date(), 'D MMMM YYYY HH.mm.ss', { locale: idLocale }) +
             '</strong> oleh <strong>' + req.body.namaPengirim + '</strong>.'
  }

  // Mari buat response JSON yang baik. Set Content-Type
  res.setHeader('Content-Type', 'application/json')
  // Kirim response
  res.send(JSON.stringify(payload))
})

io.on('connection', function (socket) {
  socket.on('notify', function (payload) {
    io.emit('notify', payload)
  })
})

http.listen(3002, function() {
  console.log('Socket.IO siap di port 3002')
})
