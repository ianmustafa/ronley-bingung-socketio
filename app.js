// Disini Express cuma dipake untuk instansiasi HTTP server untuk Socket.IO aja
var app  = require('express')()
var http = require('http').Server(app)
var io   = require('socket.io')(http)

io.on('connection', function (socket) {
  socket.on('notify', function (payload) {
    io.emit('notify', payload)
  })
})

http.listen(3002, function() {
  console.log('Socket.IO siap di port 3002')
})
