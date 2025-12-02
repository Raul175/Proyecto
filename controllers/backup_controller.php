<?php
    require_once('database/db.php');

    if(isset($_POST['backup'])){
        backup();
    }

    if(isset($_POST['import'])){
        import();
    }

    function backup(){
        // Directorio donde se guardará el archivo
        $directorio = 'backups/';

        // GENERACIÓN DEL NOMBRE DE ARCHIVO ÚNICO
        // Genera la cadena de fecha y hora actual (ej: 2025-12-01_15-44-00)
        $fecha = date('Y-m-d_H-i-s');

        // Combina el nombre de la BD, la fecha y las extensiones
        $nombre = 'rolvahotels_' . $fecha . '.sql.gz';
        $copiaSeguridad = $directorio . $nombre; // Ruta completa

        echo DataBase::backup($copiaSeguridad);
    }

    function import(){
        $db_host = "localhost";
        $db_user = "root";
        $db_pass = "";
        $mysql_path = "C:/xampp/mysql/bin/mysql";

        // Directorio donde se encuentran los archivos de copia de seguridad
        $directorio = 'backups/';

        // Obtener el archivo más reciente
        $archivo = buscarArchivoMasReciente($directorio, 'rolvahotels_');
        $gz_path = $directorio . $archivo;
        $sql_filename = str_replace('.gz', '', $archivo);
        $sql_path_temp = $directorio . $sql_filename; // Ruta del archivo temporal .sql

        //Descompresión del archivo
        comprimirConGzip($gz_path, $sql_path_temp);

        echo DataBase::import($db_host,$db_user,$db_pass,$sql_path_temp,$mysql_path);
    }

    function comprimirConGzip($gz_path, $output_path){
        // Verifica si la extensión Zlib está cargada en PHP
        if (!extension_loaded('zlib')) {
            die("Error: La extensión 'zlib' no está habilitada en tu PHP (php.ini).");
        }

        // Abrir el archivo .gz para lectura
        $gz = @gzopen($gz_path, 'rb');
        if ($gz === false) { return false; }

        // Abrir el archivo .sql temporal para escritura
        $out = @fopen($output_path, 'wb');
        if ($out === false) { @gzclose($gz); return false; }

        // Leer en bloques y escribir en el archivo .sql
        while (!gzeof($gz)) {
            fwrite($out, gzread($gz, 4096));
        }

        fclose($out);
        gzclose($gz);
        return true;
    }

    function buscarArchivoMasReciente($directorio, $prefix){
        $archivos = scandir($directorio, SCANDIR_SORT_DESCENDING);
        $ultimoArchivo = false;

        // SCANDIR_SORT_DESCENDING ordena alfabéticamente (Z a A).
        // el más reciente será el primero en la lista descendente.
        foreach ($archivos as $archivo) {
            if (strpos($archivo, $prefix) === 0 && str_ends_with($archivo, ".gz")) {
                // Se encontró el archivo con el prefijo y extensión correcta
                $ultimoArchivo = $archivo;
                break; // El primero es el más reciente (debido al sort descendente)
            }
        }
        return $ultimoArchivo;
    }
?>