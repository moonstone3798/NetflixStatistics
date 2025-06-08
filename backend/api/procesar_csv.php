<?php
require '../config/conexion.php';
define ('SITE_ROOT', realpath(dirname(__FILE__)));
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["archivo_csv"]) && $_FILES["archivo_csv"]["error"] == 0) {
        $nombre_archivo = $_FILES["archivo_csv"]["name"];
        $tipo_archivo = $_FILES["archivo_csv"]["type"];
        $tamano_archivo = $_FILES["archivo_csv"]["size"];
        $archivo_temporal = $_FILES["archivo_csv"]["tmp_name"];
        $ruta_destino = "uploads/" . $nombre_archivo; // Ruta donde guardar el archivo 

        if ($tipo_archivo == "text/csv" || $tipo_archivo == "application/vnd.ms-excel") {

            if (move_uploaded_file($archivo_temporal, $ruta_destino)) {
                echo "El archivo " . basename($nombre_archivo) . " ha sido subido.";

                if (($archivo = fopen($ruta_destino, "r")) !== FALSE) {

                    $encabezados = fgetcsv($archivo, 1000, ',');

                    while (($datos = fgetcsv($archivo, 0, ",")) !== FALSE) { 
                        
                        $show_id = $datos[0];

                        $type = $datos[1];
                        $sql="SELECT * FROM tipos_produccion WHERE nombre = '".mysqli_real_escape_string($cnx,$type)."' ";
                        $res=mysqli_query($cnx,$sql);
                        if(mysqli_num_rows($res)==1){
                            $row=mysqli_fetch_array($res);
                            echo "ya existe el tipo produccion ".$row['nombre'];
                            
                            $id_tipo = $row['id_tipo_produccion'];
                        }else{
                            echo "no existe el tipo produccion, debo insertar en la tabla tipos_produccion";
                            $insert="INSERT INTO tipos_produccion SET nombre = '".mysqli_real_escape_string($cnx,$type)."' ";
                            $res=mysqli_query($cnx,$insert);

                            $id_tipo = mysqli_insert_id($cnx);
                        }

                        $title = $datos[2];

                        $directors = $datos[3];; // es una lista
                        $array_director = explode(",", $directors);

                        foreach ($array_director as $key => $director) {
                            $sql="SELECT * FROM directores WHERE nombre = '".mysqli_real_escape_string($cnx,$director)."' ";
                            $res=mysqli_query($cnx,$sql);
                            $id_directores=[];
                            if(mysqli_num_rows($res)==1){
                                $row=mysqli_fetch_array($res);
                                echo "ya existe el director ".$row['nombre'];
                                
                                $id_directores[] = $row['id_director'];
                            }else{
                                echo "no existe el director, debo insertar en la tabla directores";
                                $insert="INSERT INTO directores SET nombre = '".mysqli_real_escape_string($cnx,$director)."' ";
                                $res=mysqli_query($cnx,$insert);

                                 $id_directores[] = mysqli_insert_id($cnx);
                            }
                        }


                        $casts = $datos[4];; // es una lista
                        $array_cast = explode(",", $casts);

                        foreach ($array_cast as $key => $reparto) {
                            $sql="SELECT * FROM repartos WHERE nombre = '".mysqli_real_escape_string($cnx,$reparto)."' ";
                            $res=mysqli_query($cnx,$sql);
                            $id_repartos=[];
                            if(mysqli_num_rows($res)==1){
                                $row=mysqli_fetch_array($res);
                                echo "ya existe el reparto ".$row['nombre'];
                                
                                $id_repartos[] = $row['id_reparto'];
                            }else{
                                echo "no existe el reparto, debo insertar en la tabla repartos";
                                $insert="INSERT INTO repartos SET nombre = '".mysqli_real_escape_string($cnx,$reparto)."' ";
                                $res=mysqli_query($cnx,$insert);

                                 $id_repartos[] = mysqli_insert_id($cnx);
                            }
                        }

                        $countrys = $datos[5];; // es una lista
                        $array_country = explode(",", $countrys);

                        foreach ($array_country as $key => $pais) {
                            $sql="SELECT * FROM paises WHERE nombre = '".mysqli_real_escape_string($cnx,$pais)."' ";
                            $res=mysqli_query($cnx,$sql);
                            $id_paises=[];
                            if(mysqli_num_rows($res)==1){
                                $row=mysqli_fetch_array($res);
                                echo "ya existe el pais ".$row['nombre'];

                                $id_paises[] = $row['id_pais'];
                            }else{
                                echo "no existe el pais, debo insertar en la tabla paises";
                                $insert="INSERT INTO paises SET nombre = '".mysqli_real_escape_string($cnx,$pais)."' ";
                                $res=mysqli_query($cnx,$insert);
                                
                                $id_paises[] = mysqli_insert_id($cnx);
                            }
                        }

                        $date_added = $datos[6];
                        $release_year = $datos[7];

                        //echo "<br>".$datos[9]."<br>";

                        if( empty($datos[9]) ){
                            $duration = NULL;
                        }else{
                            $duration = mysqli_real_escape_string($cnx,$datos[9]);
                        }

                        //echo "<br>".$duration."<br>";

                        $genres = $datos[10]; // es una lista
                        $array_generos = explode(",", $genres);

                        foreach ($array_generos as $key => $genero) {
                            $sql="SELECT * FROM generos WHERE nombre = '".mysqli_real_escape_string($cnx,$genero)."' ";
                            $res=mysqli_query($cnx,$sql);
                            $id_generos=[];
                            if(mysqli_num_rows($res)==1){
                                $row=mysqli_fetch_array($res);
                                echo "ya existe el genero ".$row['nombre'];

                                $id_generos[] = $row['id_genero'];
                            }else{
                                echo "no existe el genero, debo insertar en la tabla generos";
                                $insert="INSERT INTO generos SET nombre = '".mysqli_real_escape_string($cnx,$genero)."' ";
                                $res=mysqli_query($cnx,$insert);
                                
                                $id_generos[] = mysqli_insert_id($cnx);
                            }
                        }

                        $language = $datos[11];
                        $sql="SELECT * FROM idiomas WHERE idioma = '".mysqli_real_escape_string($cnx,$language)."' ";
                        $res=mysqli_query($cnx,$sql);
                        if(mysqli_num_rows($res)==1){
                            $row=mysqli_fetch_array($res);
                            echo "ya existe el idioma ".$row['idioma'];
                            
                            $id_idioma = $row['id_idioma'];
                        }else{
                            echo "no existe el idioma, debo insertar en la tabla idiomas";
                            $insert="INSERT INTO idiomas SET idioma = '".mysqli_real_escape_string($cnx,$language)."' ";
                            $res=mysqli_query($cnx,$insert);

                            $id_idioma = mysqli_insert_id($cnx);
                        }

                        $description = $datos[12];
                        $popularity = $datos[13];
                        $vote_count = $datos[14];
                        $rating = $datos[8];
                        $vote_avarage = $datos[15];
                        $budget = $datos[16];
                        $revenue = $datos[17];

                        //DATOS EXTRAS
                        $insert = "INSERT INTO datos_extras SET
                        popularidad = $popularity ,
                        votos = $vote_count , 
                        rating = $rating ,
                        promedio_votos = $vote_avarage,
                        presupuesto = $budget ,
                        ganancia = $revenue ";
                        $res=mysqli_query($cnx,$insert);
                        $id_datos_extras = mysqli_insert_id($cnx);

                        //PRODUCCIONES
                        $insert = "INSERT INTO producciones SET
                        titulo = '".mysqli_real_escape_string($cnx,$title)."' ,
                        fecha_ingreso = '".mysqli_real_escape_string($cnx,$date_added)."' , 
                        anio_realizacion = ".mysqli_real_escape_string($cnx,$release_year)." ,
                        duracion = '$duration' ,
                        descripcion = '".mysqli_real_escape_string($cnx,$description)."' ,
                        id_idioma = $id_idioma ,
                        id_datos_extras = $id_datos_extras ,
                        id_tipo = $id_tipo ";

                        //echo $insert;exit;

                        $res=mysqli_query($cnx,$insert);
                        $id_produccion = mysqli_insert_id($cnx);

                        foreach ($id_paises as $key => $id_pais) {
                            $insert = "INSERT INTO producciones_paises SET
                            id_pais = $id_pais ,
                            id_produccion = $id_produccion ";
                            $res=mysqli_query($cnx,$insert);
                            $id_produccion = mysqli_insert_id($cnx);
                        }

                        foreach ($id_generos as $key => $id_genero) {
                            $insert = "INSERT INTO generos_producciones SET
                            id_genero = $id_genero ,
                            id_produccion = $id_produccion ";
                            $res=mysqli_query($cnx,$insert);
                            $id_produccion = mysqli_insert_id($cnx);
                        }

                        foreach ($id_directores as $key => $id_director) {
                            $insert = "INSERT INTO directores_producciones SET
                            id_director = $id_director ,
                            id_produccion = $id_produccion ";
                            $res=mysqli_query($cnx,$insert);
                            $id_produccion = mysqli_insert_id($cnx);
                        }

                        foreach ($id_repartos as $key => $id_reparto) {
                            $insert = "INSERT INTO repartos_producciones SET
                            id_reparto = $id_reparto ,
                            id_produccion = $id_produccion ";
                            $res=mysqli_query($cnx,$insert);
                            $id_produccion = mysqli_insert_id($cnx);
                        }
                        
                    }
                    fclose($archivo);
                }
            } else {
                echo "Hubo un problema al subir el archivo.";
            }
        } else {
            echo "El tipo de archivo no es válido (debe ser .csv).";
        }
    } else {
        echo "Error al subir el archivo. Código de error: " . $_FILES["archivo_csv"]["error"];
    }
}
?>