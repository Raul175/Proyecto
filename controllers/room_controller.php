<?php
    require_once('models/db_model.php');
    require_once('models/room_model.php');
    require_once('models/hotel_model.php');

    if(isset($_POST['insertar'])){
        $img = $_POST['img'];

        if (strpos($img, 'data:image/png;base64,') === 0) {
            $img_extension = '.png';  // Imagen PNG
        } elseif (strpos($img, 'data:image/jpeg;base64,') === 0 || strpos($img, 'data:image/jpg;base64,') === 0) {
            $img_extension = '.jpg';  // Imagen JPG/JPEG
        } elseif (strpos($img, 'data:image/webm;base64,') === 0) {
            $img_extension = '.webm'; // Imagen WEBM
        }

        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace('data:image/jpg;base64,', '', $img);
        $img = str_replace('data:image/webm;base64,', '', $img);

        $img_data = base64_decode($img);
        $img_name = uniqid() . $img_extension;
        $upload_dir = 'images/';
        $file_path = $upload_dir . $img_name;

        $habitacion = Habitacion::checkRoom($_POST['nombre']);
        if(!empty($habitacion) && $habitacion[0]['nombre'] == $_POST['nombre']){
            echo "Ya existe esta habitación";
        }else{
            createRoom($_POST['nombre'], $_POST['tipo'], $_POST['npersonas'], $_POST['precio'], $_POST['m2'], $_POST['hotel'], $img_name, $_POST['vip']);
            file_put_contents($file_path, $img_data);
        }
    }
    if(isset($_POST['actualizar'])){
        $habitacion = Habitacion::checkRoom($_POST['nombre']);
        if(!empty($habitacion) && $habitacion[0]['nombre'] == $_POST['nombre'] && $habitacion[0]['idHabitacion'] != $_POST['id']){
            echo "Ya existe esta habitación";
        }else{
            updateRoom($_POST['id'],$_POST['nombre'], $_POST['tipo'], $_POST['npersonas'], $_POST['precio'], $_POST['m2'], $_POST['hotel']);
        }
    }
    if(isset($_POST['eliminar'])){
        deleteRoom($_POST['id']);
    }
    if(isset($_POST['search'])){
        buscar($_POST['lugar'],$_POST['npersonas'],$_POST['entrada'],$_POST['salida']);
    }
    if(isset($_POST['CompVIP'])){
        $habitacion = Habitacion::checkVIP($_POST['habitacion'],$_POST['vip']);
        if(!empty($habitacion)){
            echo true;
        }else{
            echo false;
        }
    }
    if (isset($_POST['añadir'])) {
        echo Habitacion::añadir($_POST['habitacion'],$_POST['caja'],$_POST['wifi'],$_POST['bar']);
    }

    function buscar($lugar, $npersonas, $entrada, $salida){
        require_once('controllers/cama_controller.php');
        $habitaciones = Habitacion::searchRoom($lugar, $npersonas, $entrada, $salida);
        if ($habitaciones != false) {
            foreach ($habitaciones as &$room) {
                $room['FK_IdHotel'] = Hotel::selectHotel($room['FK_IdHotel'])['Nombre'];
                $room['suite'] = Habitacion::selectSuite($room['IdHabitacion']);
                $room['camas'] = selectAllCamaRoom($room['IdHabitacion']);
            }
        }
        $_SESSION['habitaciones'] = $habitaciones;
        return true."-".$entrada."-".$salida;
    }

    function selectAllRooms(){
        $rooms = Habitacion::selectAllRooms();
        if ($rooms != false) {
            foreach ($rooms as &$room) {
                $room['hotel_ubi'] = Hotel::selectHotel($room['FK_IdHotel'])['Ubicacion'];
                $room['FK_IdHotel'] = Hotel::selectHotel($room['FK_IdHotel'])['Nombre'];
                $room['suite'] = Habitacion::selectSuite($room['IdHabitacion']);
            }
        }
        return $rooms;
    }

    function selectRoom($habitacion){
        $room = Habitacion::selectRoom($habitacion);
        return $room;
    }

    function total(){
        $total = Habitacion::total();
        return $total;
    }

    function selectAllRoomsFecha(){
        require_once('controllers/cama_controller.php');
        $rooms = Habitacion::selectAllRoomsFecha();
        if ($rooms != false) {
            foreach ($rooms as &$room) {
                $room['hotel_ubi'] = Hotel::selectHotel($room['FK_IdHotel'])['Ubicacion'];
                $room['FK_IdHotel'] = Hotel::selectHotel($room['FK_IdHotel'])['Nombre'];
                $room['suite'] = Habitacion::selectSuite($room['IdHabitacion']);
                $room['camas'] = selectAllCamaRoom($room['IdHabitacion']);
            }
        }
        
        return $rooms;
    }

    function selectAllRoomsFechaLimite(){
        require_once('controllers/cama_controller.php');
        $rooms = Habitacion::selectAllRoomsFechaLimite();
        if ($rooms != false) {
            foreach ($rooms as &$room) {
                $room['FK_IdHotel'] = Hotel::selectHotel($room['FK_IdHotel'])['Nombre'];
                $room['suite'] = Habitacion::selectSuite($room['IdHabitacion']);
                $room['camas'] = selectAllCamaRoom($room['IdHabitacion']);
            }
        }
        return $rooms;
    }

    function selectAllSuite(){
        $rooms = Habitacion::selectAllSuite();
        if (empty($rooms)) {
            $rooms = [];
        }
        foreach ($rooms as &$room) {
            $room['FK_IdHotel'] = Hotel::selectHotel($room['FK_IdHotel'])['Nombre'];
        }
        return $rooms;
    }

    function createRoom($nombre, $tipo, $nPersonas, $precioUnitario, $m2, $fkIdHotel, $img, $vip){
        echo Habitacion::createRoom($nombre, $tipo, $nPersonas, $precioUnitario, $m2, $fkIdHotel, $img, $vip);
    }

    function deleteRoom($id){
        echo Habitacion::deleteRoom($id);
    }

    function updateRoom($id, $nombre, $tipo, $nPersonas, $precioUnitario, $m2, $fkIdHotel){
        echo Habitacion::updateRoom($id, $nombre, $tipo, $nPersonas, $precioUnitario, $m2, $fkIdHotel);
    }
?>