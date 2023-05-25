<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$servidor = "localhost";
$usuario = "root";
$contrasenia = "";
$nombreBaseDatos = "persona";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);

if (isset($_GET["consultar"])) {
    $id = $_GET["consultar"];
    $sqlRegistro = mysqli_query($conexionBD, "SELECT * FROM registro WHERE id=$id");
    if (mysqli_num_rows($sqlRegistro) > 0) {
        $registro = mysqli_fetch_assoc($sqlRegistro);
        echo json_encode($registro);
        exit();
    } else {
        echo json_encode(["success" => 0]);
    }
}

if (isset($_GET["borrar"])) {
    $sqlRegistro = mysqli_query($conexionBD, "DELETE FROM registro WHERE id=".$_GET["borrar"]);
    //$sqlRegistro = mysqli_query($conexionBD, "DELETE FROM registro WHERE id=$id");
    if ($sqlRegistro) {
        echo json_encode(["success" => 1]);
        exit();
    } else {
        echo json_encode(["success" => 0]);
    }
}

// if (isset($_GET["insertar"])) {
//     $data = json_decode(file_get_contents("php://input"));
//     $nombre = $data->nombre;
//     $apellidos = $data->apellidos;
//     $fechaNacimiento = $data->fecha_nacimiento;
//     $dni = $data->dni;
    
//     if (!empty($nombre) && !empty($apellidos) && !empty($fechaNacimiento) && !empty($dni)) {
//         $sqlInsertar = "INSERT INTO registro (nombre, apellidos, fecha_nacimiento, dni) VALUES ('$nombre', '$apellidos', '$fechaNacimiento', '$dni')";
//         if (mysqli_query($conexionBD, $sqlInsertar)) {
//             echo json_encode(["success" => 1]);
//         } else {
//             echo json_encode(["success" => 0]);
//         }
//     } else {
//         echo json_encode(["success" => 0]);
//     }
//     exit();
// }
if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"));
    $nombre=$data->nombre;
    $apellido=$data->apellido;
    $fecha=$data->fecha;
    $dni=$data->dni;
        if(($nombre!="")&&($apellido!="")&&($fecha!="")&&($dni!="")){
            $sqlRegistro = mysqli_query($conexionBD,"INSERT INTO registro(nombre,apellidos,fecha_nacimiento,dni) VALUES('$nombre','$apellido','$fecha','$dni') ");
            echo json_encode(["success"=>1]);
        }
    exit();
}

if (isset($_GET["actualizar"])) {
    $data = json_decode(file_get_contents("php://input"));
    $id = $_GET["actualizar"];
    $nombre = $data->nombre;
    $apellidos = $data->apellidos;
    $fechaNacimiento = $data->fecha_nacimiento;
    $dni = $data->dni;

    $sqlActualizar = "UPDATE registro SET nombre='$nombre', apellidos='$apellidos', fecha_nacimiento='$fechaNacimiento', dni='$dni' WHERE id='$id'";
    if (mysqli_query($conexionBD, $sqlActualizar)) {
        echo json_encode(["success" => 1]);
    } else {
        echo json_encode(["success" => 0]);
    }
    exit();
}

$sqlRegistros = mysqli_query($conexionBD, "SELECT * FROM registro ORDER BY id DESC");
if (mysqli_num_rows($sqlRegistros) > 0) {
    $registros = mysqli_fetch_all($sqlRegistros, MYSQLI_ASSOC);
    echo json_encode($registros);
} else {
    echo json_encode(["success" => 0]);
}
?>
