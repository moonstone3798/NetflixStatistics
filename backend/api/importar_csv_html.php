<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="procesar_csv.php" method="post" enctype="multipart/form-data">
        Selecciona un archivo CSV:
        <input type="file" name="archivo_csv" accept=".csv">
        <input type="submit" value="Subir archivo">
    </form>
</body>
</html>