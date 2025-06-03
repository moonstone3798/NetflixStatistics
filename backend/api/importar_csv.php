<?php
$pdo = new PDO("mysql:host=localhost;dbname=netflix_statistics", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

if ($_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
    $file = fopen($_FILES['csv_file']['tmp_name'], 'r');
    $headers = fgetcsv($file); // Saltar encabezado

    while (($row = fgetcsv($file)) !== false) {
        // Asumiendo que las columnas son (ajustar según tus archivos reales)
        [$title, $release_year, $duration, $description, $language, $directors, $cast, $genres, $country, $popularity, $votes, $rating, $vote_average, $budget, $revenue] = $row;

        // 1. Insertar idioma (o buscar si ya existe)
        $stmt = $pdo->prepare("SELECT id_idioma FROM idiomas WHERE idioma = ?");
        $stmt->execute([$language]);
        $id_idioma = $stmt->fetchColumn();
        if (!$id_idioma) {
            $pdo->prepare("INSERT INTO idiomas (idioma) VALUES (?)")->execute([$language]);
            $id_idioma = $pdo->lastInsertId();
        }

        // 2. Insertar datos extras
        $pdo->prepare("INSERT INTO datos_extras (popularidad, votos, rating, promedio_votos, presupuesto, ganancia)
                       VALUES (?, ?, ?, ?, ?, ?)")
            ->execute([$popularity, $votes, $rating, $vote_average, $budget, $revenue]);
        $id_datos_extras = $pdo->lastInsertId();

        // 3. Insertar producción (usamos tipo 1 = película, 2 = serie)
        $tipo = strpos(strtolower($_FILES['csv_file']['name']), 'movie') !== false ? 1 : 2;
        $pdo->prepare("INSERT INTO producciones (titulo, fecha_ingreso, anio_realizacion, duracion, descripcion, id_idioma, id_actor, id_datos_extras, id_tipo)
                       VALUES (?, NOW(), ?, ?, ?, ?, 1, ?, ?)")
            ->execute([$title, $release_year, $duration, $description, $id_idioma, $id_datos_extras, $tipo]);
        $id_produccion = $pdo->lastInsertId();

        // 4. Insertar país (similar a idioma, simplificado para un solo país)
        if ($country) {
            $stmt = $pdo->prepare("SELECT id_pais FROM paises WHERE nombre = ?");
            $stmt->execute([$country]);
            $id_pais = $stmt->fetchColumn();
            if (!$id_pais) {
                $pdo->prepare("INSERT INTO paises (nombre) VALUES (?)")->execute([$country]);
                $id_pais = $pdo->lastInsertId();
            }
            $pdo->prepare("INSERT INTO producciones_paises (id_pais, id_produccion) VALUES (?, ?)")->execute([$id_pais, $id_produccion]);
        }

        // 5. Géneros (pueden ser múltiples separados por coma)
        foreach (explode(',', $genres) as $genero) {
            $genero = trim($genero);
            if ($genero) {
                $stmt = $pdo->prepare("SELECT id_genero FROM generos WHERE nombre = ?");
                $stmt->execute([$genero]);
                $id_genero = $stmt->fetchColumn();
                if (!$id_genero) {
                    $pdo->prepare("INSERT INTO generos (nombre) VALUES (?)")->execute([$genero]);
                    $id_genero = $pdo->lastInsertId();
                }
                $pdo->prepare("INSERT INTO generos_producciones (id_genero, id_produccion) VALUES (?, ?)")->execute([$id_genero, $id_produccion]);
            }
        }

        // 6. Reparto
        foreach (explode(',', $cast) as $actor) {
            $actor = trim($actor);
            if ($actor) {
                $stmt = $pdo->prepare("SELECT id_reparto FROM repartos WHERE nombre = ?");
                $stmt->execute([$actor]);
                $id_actor = $stmt->fetchColumn();
                if (!$id_actor) {
                    $pdo->prepare("INSERT INTO repartos (nombre) VALUES (?)")->execute([$actor]);
                    $id_actor = $pdo->lastInsertId();
                }
                $pdo->prepare("INSERT INTO repartos_producciones (id_reparto, id_produccion) VALUES (?, ?)")->execute([$id_actor, $id_produccion]);
            }
        }

        // 7. Directores
        foreach (explode(',', $directors) as $dir) {
            $dir = trim($dir);
            if ($dir) {
                $stmt = $pdo->prepare("SELECT id_director FROM directores WHERE nombre = ?");
                $stmt->execute([$dir]);
                $id_dir = $stmt->fetchColumn();
                if (!$id_dir) {
                    $pdo->prepare("INSERT INTO directores (nombre) VALUES (?)")->execute([$dir]);
                    $id_dir = $pdo->lastInsertId();
                }
                $pdo->prepare("INSERT INTO directores_producciones (id_director, id_produccion) VALUES (?, ?)")->execute([$id_dir, $id_produccion]);
            }
        }
    }

    fclose($file);
    echo "✅ Datos cargados correctamente.";
} else {
    echo "❌ Error al subir el archivo.";
}
