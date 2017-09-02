var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io');
//var redis = require('redis');

 var socket = io.listen(server);

function iniciar(jsonResult,conexion){

  socket.on('connection', function(client) {

    console.log("client connected");

    // Con este clien de socket emito los datos para los notificaciones que traigo desde la DB.
    client.emit("message",jsonResult);


    // Con esta función recibo y emito al mismo client de "mensaje"...
    client.on('recibirRefresh', function(data) {
       conexion.consultarCLientes().then((result)=> {
         console.log("result " , result);
         client.emit("message",result);
       }).catch(console.error);

     });

     client.on('refrescar', function(data) {
       console.log("begin function: ", data);
        conexion.consultarCLientes().then((result)=> {
          console.log("result " , result);
          client.emit("ref",result);
        }).catch(console.error);

      });

  });
}



server.listen(8080, function() {
  console.log("servidor levantado");
});

exports.iniciar = iniciar;
//exports.emit = emit;
