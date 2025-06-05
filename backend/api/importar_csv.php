<?php

// Validar la carga del archivo
if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {

    // Obtener la ruta del archivo
    $ruta_archivo = $_FILES['csv_file']['tmp_name'];

    // Abrir el archivo
    $archivo = fopen($ruta_archivo, 'r');

    // Obtener los datos del CSV
    $datos = array();
    while (($fila = fgetcsv($archivo, 1000, ',')) !== FALSE) {
        $datos[] = $fila;
    }

    // Cerrar el archivo
    fclose($archivo);

    // Preparar la consulta SQL
    foreach ($datos as $fila) {
        $show_id = mysqli_real_escape_string($cnx, $fila['show_id']);
        $type = mysqli_real_escape_string($cnx, $fila['type']);
        $title = mysqli_real_escape_string($cnx, $fila['title']);
        $director = mysqli_real_escape_string($cnx, $fila['title']); // es una lista
        $cast = mysqli_real_escape_string($cnx, $fila['cast']); // es una lista
        $country = mysqli_real_escape_string($cnx, $fila['country']); // es una lista
        $date_added = mysqli_real_escape_string($cnx, $fila['date_added']);
        $release_year = mysqli_real_escape_string($cnx, $fila['release_year']);
        $rating = mysqli_real_escape_string($cnx, $fila['rating']);
        $duration
        $genres
        $language
        $description
        

        // Insertar datos en la base de datos
        $sql = "INSERT INTO usuarios (nombre, apellido, correo) VALUES ('$nombre', '$apellido', '$correo')";

        // Ejecutar la consulta
        if (mysqli_query($conexion, $sql)) {
            echo "Datos insertados correctamente.";
        } else {
            echo "Error al insertar datos: " . mysqli_error($conexion);
        }
    }

    // Cerrar la conexión
    mysqli_close($conexion);

} else {
    echo "Error al subir el archivo.";
}

?>