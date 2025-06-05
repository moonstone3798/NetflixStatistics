<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "netflix_statistics";

$conexion = new mysqli($host, $user, $pass, $db);
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$archivo = fopen("netflix_movies_detailed_up_to_2025.csv", "r");
fgetcsv($archivo); // Saltar encabezado

function obtenerID($conn, $tabla, $columna_busqueda, $valor) {
    // Mapa correcto de columnas ID
    $id_columnas = [
        'idiomas' => 'id_idioma',
        'paises' => 'id_pais',
        'generos' => 'id_genero',
        'tipos_produccion' => 'id_tipo_produccion',
        'tipos_graficos' => 'id_tipo',
        'repartos' => 'id_reparto',
        'directores' => 'id_director'
        // Agrega más si es necesario
    ];

    $columna_id = $id_columnas[$tabla];
    $sql = "SELECT $columna_id FROM $tabla WHERE $columna_busqueda = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $valor);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $id ?? null;
}

function insertarSiNoExiste($conn, $tabla, $columna, $valor) {
    $id = obtenerID($conn, $tabla, $columna, $valor);
    if ($id === null) {
        $sql = "INSERT INTO $tabla ($columna) VALUES (?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $valor);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $id = mysqli_insert_id($conn);
    }
    return $id;
}

while (($fila = fgetcsv($archivo)) !== false) {
    [
        $show_id, $tipo, $titulo, $director, $cast, $pais, $fecha_ingreso,
        $anio_realizacion, $rating, $duracion, $generos, $idioma,
        $descripcion, $popularidad, $votos, $promedio_votos, $presupuesto, $ganancia
    ] = $fila;

    // tipo
    $id_tipo = insertarSiNoExiste($conexion, "tipos_produccion", "nombre", $tipo);

    // idioma
    $id_idioma = insertarSiNoExiste($conexion, "idiomas", "idioma", $idioma);

    // reparto (para id_reparto obligatorio, solo 1er actor)
    $primer_actor = explode(",", $cast)[0] ?? "Desconocido";
    $id_reparto = insertarSiNoExiste($conexion, "repartos", "nombre", trim($primer_actor));

    // datos_extras
    $stmt = $conexion->prepare("
        INSERT INTO datos_extras (popularidad, votos, rating, promedio_votos, presupuesto, ganancia)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $pop = (int) $popularidad;
    $vot = (int) $votos;
    $rat = (int) $rating;
    $prom = (int) $promedio_votos;
    $pres = (int) $presupuesto;
    $gan = (int) $ganancia;
    $stmt->bind_param("iiiiii", $pop, $vot, $rat, $prom, $pres, $gan);
    $stmt->execute();
    $id_datos_extras = $stmt->insert_id;
    $stmt->close();

    // produccion
    $stmt = $conexion->prepare("
        INSERT INTO producciones (titulo, fecha_ingreso, anio_realizacion, duracion, descripcion, id_idioma, id_reparto, id_datos_extras, id_tipo)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $dur = floatval($duracion);
    $anio = (int) $anio_realizacion;
    $stmt->bind_param("ssidsiiii", $titulo, $fecha_ingreso, $anio, $dur, $descripcion, $id_idioma, $id_reparto, $id_datos_extras, $id_tipo);
    $stmt->execute();
    $id_produccion = $stmt->insert_id;
    $stmt->close();

    // directores
    foreach (explode(",", $director) as $dir) {
        $dir = trim($dir);
        if ($dir == "") continue;
        $id_dir = insertarSiNoExiste($conexion, "directores", "nombre", $dir);

        $stmt = $conexion->prepare("SELECT 1 FROM directores_producciones WHERE id_director = ? AND id_produccion = ?");
        $stmt->bind_param("ii", $id_dir, $id_produccion);
        $stmt->execute();
        if (!$stmt->fetch()) {
            $stmt->close();
            $stmt = $conexion->prepare("INSERT INTO directores_producciones (id_produccion, id_director) VALUES (?, ?)");
            $stmt->bind_param("ii", $id_produccion, $id_dir);
            $stmt->execute();
        } else {
            $stmt->close();
        }
    }

    // cast
    foreach (explode(",", $cast) as $actor) {
        $actor = trim($actor);
        if ($actor == "") continue;
        $id_act = insertarSiNoExiste($conexion, "repartos", "nombre", $actor);

        $stmt = $conexion->prepare("SELECT 1 FROM repartos_producciones WHERE id_reparto = ? AND id_produccion = ?");
        $stmt->bind_param("ii", $id_act, $id_produccion);
        $stmt->execute();
        if (!$stmt->fetch()) {
            $stmt->close();
            $stmt = $conexion->prepare("INSERT INTO repartos_producciones (id_reparto, id_produccion) VALUES (?, ?)");
            $stmt->bind_param("ii", $id_act, $id_produccion);
            $stmt->execute();
        } else {
            $stmt->close();
        }
    }

    // paises
    foreach (explode(",", $pais) as $p) {
        $p = trim($p);
        if ($p == "") continue;
        $id_pais = obtenerID($conexion, "paises", "nombre", $p);

        $stmt = $conexion->prepare("SELECT 1 FROM producciones_paises WHERE id_pais = ? AND id_produccion = ?");
        $stmt->bind_param("ii", $id_pais, $id_produccion);
        $stmt->execute();
        if (!$stmt->fetch()) {
            $stmt->close();
            $stmt = $conexion->prepare("INSERT INTO producciones_paises (id_pais, id_produccion) VALUES (?, ?)");
            $stmt->bind_param("ii", $id_pais, $id_produccion);
            $stmt->execute();
        } else {
            $stmt->close();
        }
    }

    // generos
    foreach (explode(",", $generos) as $g) {
        $g = trim($g);
        if ($g == "") continue;
        $id_gen = obtenerID($conexion, "generos", "nombre", $g);

        $stmt = $conexion->prepare("SELECT 1 FROM generos_producciones WHERE id_genero = ? AND id_produccion = ?");
        $stmt->bind_param("ii", $id_gen, $id_produccion);
        $stmt->execute();
        if (!$stmt->fetch()) {
            $stmt->close();
            $stmt = $conexion->prepare("INSERT INTO generos_producciones (id_genero, id_produccion) VALUES (?, ?)");
            $stmt->bind_param("ii", $id_gen, $id_produccion);
            $stmt->execute();
        } else {
            $stmt->close();
        }
    }
}

fclose($archivo);
$conexion->close();

echo "Importación completada con éxito.";
?>
