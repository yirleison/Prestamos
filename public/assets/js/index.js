
var server = require('./node/server');
var conexion = require('./conexion_DB');



conexion.conmysql();
conexion.consultarCLientes().then((jsonResult)=>{
	server.iniciar(jsonResult, conexion);
}).catch(console.error);
