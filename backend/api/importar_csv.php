<?php

// Validar la carga del archivo
if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {

    // Obtener la ruta del archivo
    $ruta_archivo = $_FILES['csv_file']['tmp_name'];

    // Abrir el archivo
    $archivo = fopen($ruta_archivo, 'r');

    // Leer encabezados
    $encabezados = fgetcsv($archivo, 1000, ',');


    $datos = [];
    while (($fila = fgetcsv($archivo, 1000, ',')) !== FALSE) {
        $datos[] = array_combine($encabezados, $fila);
    }

    fclose($archivo);

    // Preparar la consulta SQL
    foreach ($datos as $fila) {
        $show_id = mysqli_real_escape_string($cnx, $fila['show_id']);
        $type = mysqli_real_escape_string($cnx, $fila['type']);
        $title = mysqli_real_escape_string($cnx, $fila['title']);

        $director = mysqli_real_escape_string($cnx, $fila['director']); // es una lista
        $array_director = explode(",", $director);


        $cast = mysqli_real_escape_string($cnx, $fila['cast']); // es una lista
        $array_cast = explode(",", $cast);

        $country = mysqli_real_escape_string($cnx, $fila['country']); // es una lista
        $array_country = explode(",", $country);

        $date_added = mysqli_real_escape_string($cnx, $fila['date_added']);
        $release_year = mysqli_real_escape_string($cnx, $fila['release_year']);
        $rating = mysqli_real_escape_string($cnx, $fila['rating']);
        $duration = mysqli_real_escape_string($cnx, $fila['duration']);
        $genres = mysqli_real_escape_string($cnx, $fila['genres']);
        $language = mysqli_real_escape_string($cnx, $fila['language']);
        $description = mysqli_real_escape_string($cnx, $fila['description']);
        $popularity = mysqli_real_escape_string($cnx, $fila['popularity']);
        $vote_count = mysqli_real_escape_string($cnx, $fila['vote_count']);
        $vote_avarage = mysqli_real_escape_string($cnx, $fila['vote_avarage']);
        $budget = mysqli_real_escape_string($cnx, $fila['rabudgetting']);
        $revenue = mysqli_real_escape_string($cnx, $fila['revenue']);

        // Insertar datos en la base de datos
        $sql = "INSERT INTO ";

        // Ejecutar la consulta
        if (mysqli_query($cnx, $sql)) {
            echo "Datos insertados correctamente.";
        } else {
            echo "Error al insertar datos: " . mysqli_error($conexion);
        }
    }

    // Cerrar la conexión
    mysqli_close($cnx);

} else {
    echo "Error al subir el archivo.";
}

?>


<?php

$archivo = fopen("netflix_movies_detailed_up_to_2025.csv", "r");
fgetcsv($archivo); // Saltar encabezado

function obtenerID($conexion, $tabla, $columna, $valor) {
    $stmt = $conexion->prepare("SELECT id_$tabla FROM $tabla WHERE $columna = ?");
    $stmt->bind_param("s", $valor);
    $stmt->execute();
    $stmt->bind_result($id);
    if ($stmt->fetch()) {
        $stmt->close();
        return $id;
    }
    $stmt->close();

    $stmt = $conexion->prepare("INSERT INTO $tabla ($columna) VALUES (?)");
    $stmt->bind_param("s", $valor);
    $stmt->execute();
    $id = $stmt->insert_id;
    $stmt->close();
    return $id;
}

while (($fila = fgetcsv($archivo)) !== false) {
    [
        $show_id, $tipo, $titulo, $director, $cast, $pais, $fecha_ingreso,
        $anio_realizacion, $rating, $duracion, $generos, $idioma,
        $descripcion, $popularidad, $votos, $promedio_votos, $presupuesto, $ganancia
    ] = $fila;

    // tipo
    $id_tipo = obtenerID($conexion, "tipos_produccion", "nombre", $tipo);

    // idioma
    $id_idioma = obtenerID($conexion, "idiomas", "idioma", $idioma);

    // reparto (para id_reparto obligatorio, solo 1er actor)
    $primer_actor = explode(",", $cast)[0] ?? "Desconocido";
    $id_reparto = obtenerID($conexion, "repartos", "nombre", trim($primer_actor));

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
        $id_dir = obtenerID($conexion, "directores", "nombre", $dir);

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
        $id_act = obtenerID($conexion, "repartos", "nombre", $actor);

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
