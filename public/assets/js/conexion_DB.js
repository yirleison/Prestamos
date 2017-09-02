
var mysql = require('mysql');
var connection;

function conmysql() {

	connection = mysql.createConnection({
		user: 'root',
		password: '',
		host: '127.0.0.1',
		database: 'prestamos',
		port: '3306'
	});

	connection.connect(function (error) {

		if (error) {

			throw error;

		} else {

			console.log('Conexion correcta.');
		}
	});

}

function consultarCLientes() {

	var clientes_mora = `SELECT DISTINCT C.id, C.nombre, C.primer_apellido,C.estado_cuota ,(select count(CL.id) as cantidad
	from
	(select * from prestamo p
		join (select A.prestamo_id, A.estado_cuota from prestamo_abonos A) a on p.id = a.prestamo_id and a.estado_cuota = 1) CL where CL.clientes_id = C.id) cantidad
		from
		(
			select * from clientes c
			JOIN (select p.id as idp, p.clientes_id from prestamo p) P on c.id = P.clientes_id
			JOIN (SELECT a.prestamo_id, a.fecha_cuota, a.estado_cuota from prestamo_abonos a) A on A.prestamo_id = P.idp
		) C where  C.fecha_cuota <= CURDATE() AND  C.estado_cuota = 1`;

		var promise = new Promise((resolve, fail) => {

			var query = connection.query(clientes_mora, function (error, result) {
				if (error) {
					return fail(error);
				} else {
					return resolve(result);
				}
				//connection.end();
			});
		});
		return promise;

	}

	exports.conmysql = conmysql;
	exports.consultarCLientes = consultarCLientes;
