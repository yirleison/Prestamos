
<?php
namespace App\procedimientos;
use DB;

class sp_prestamos {

  public function crear_prestamos ($datos){

    DB::statement('sp_prestamos(?,?,?,?,?,?,?,?,?,?)',array($datos));

  }

}

 ?>
