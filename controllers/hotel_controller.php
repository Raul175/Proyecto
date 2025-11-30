<?php
    require_once('database/db.php');
    require_once('models/hotel_model.php');
    require_once('models/localidad_model.php');

    if(isset($_POST['insertar'])){
        $hotel = Hotel::checkHotel($_POST['nombre']);
        if(!empty($hotel) && $hotel[0]['Nombre'] == $_POST['nombre']){
            echo "Ya existe este hotel";
        }else{
            createHotel($_POST['nombre'], $_POST['localidad'], $_POST['ubicacion'], $_POST['usuario']);
        }
    }
    if(isset($_POST['actualizar'])){
        $hotel = Hotel::checkHotel($_POST['nombre']);
        if(!empty($hotel) && $hotel[0]['Nombre'] == $_POST['nombre'] && $hotel[0]['IdHotel'] != $_POST['id']){
            echo "Ya existe este hotel";
        }else{
            updateHotel($_POST['id'], $_POST['nombre'], $_POST['localidad'], $_POST['ubicacion']);
        }
    }
    if(isset($_POST['eliminar'])){
        deleteHotel($_POST['id']);
    }

    function selectAllHotels(){
        $hotels = Hotel::selectAllHotels();
        if (is_array($hotels)) {
            foreach ($hotels as &$hotel) {
                $hotel['FK_IdLocalidad'] = Localidad::selectLocalidad($hotel['FK_IdLocalidad']);
            }
            return $hotels;
        }
    }

    function selectAllHotelsRooms(){
        $hoteles = [];
        $datos = Hotel::selectAllHotelsRooms();
        if (empty($datos)) {
            return [];
        }
        foreach ($datos as $fila) {
            $hotelId = $fila['hotel_IdHotel'];
            $hoteles[$hotelId] = [
                'id' => $fila['hotel_IdHotel'],
                'nombre' => $fila['hotel_nombre'],
                'ubicacion' => $fila['hotel_ubicacion'],
                'idLocalidad' => $fila['hotel_FK_IdLocalidad'],
                'localidad' => Localidad::selectLocalidad($fila['hotel_FK_IdLocalidad']),
                'habitaciones' => []
            ];

            if ($fila['hab_IdHabitacion']) {
                $hoteles[$hotelId]['habitaciones'][] = [
                    'id' => $fila['hab_IdHabitacion'],
                    'nombre' => $fila['hab_nombre'],
                    'tipo' => $fila['hab_Tipo'],
                    'precio' => $fila['hab_PrecioUnitario'],
                    'm2' => $fila['hab_m2'],
                    'imagen' => $fila['hab_Imagen'],
                ];
            }
        }

        $hoteles = array_values($hoteles);
        return $hoteles;
    }

    function selectAllHotelsGerente($id){
        $hotels = Hotel::selectAllHotelsGerente($id);
        if (is_array($hotels)) {
            foreach ($hotels as &$hotel) {
                $hotel['FK_IdLocalidad'] = Localidad::selectLocalidad($hotel['FK_IdLocalidad']);
            }
            return $hotels;
        }
    }

    function selectAllHotelsLocal(){
        $hoteles = [];
        $datos = Hotel::selectAllHotelsLocal();
        if (empty($datos)) {
            return [];
        }
        foreach ($datos as $fila) {
            $hotelId = $fila['hotel_IdHotel'];
            $hoteles[$hotelId] = [
                'id' => $fila['hotel_IdHotel'],
                'nombre' => $fila['hotel_nombre'],
                'ubicacion' => $fila['hotel_ubicacion'],
                'idLocalidad' => $fila['hotel_FK_IdLocalidad'],
                'localidad' => Localidad::selectLocalidad($fila['hotel_FK_IdLocalidad']),
                'habitaciones' => []
            ];

            if ($fila['hab_IdHabitacion']) {
                $hoteles[$hotelId]['habitaciones'][] = [
                    'id' => $fila['hab_IdHabitacion'],
                    'nombre' => $fila['hab_nombre'],
                    'tipo' => $fila['hab_Tipo'],
                    'precio' => $fila['hab_PrecioUnitario'],
                    'm2' => $fila['hab_m2'],
                    'imagen' => $fila['hab_Imagen'],
                ];
            }
        }

        $hoteles = array_values($hoteles);
        return $hoteles;
    }

    function selectAllHotelsLocalGerente($id){
        $hoteles = [];
        $datos = Hotel::selectAllHotelsLocalGerente($id);
        if (empty($datos)) {
            return [];
        }
        foreach ($datos as $fila) {
            $hotelId = $fila['hotel_IdHotel'];
            $hoteles[$hotelId] = [
                'id' => $fila['hotel_IdHotel'],
                'nombre' => $fila['hotel_nombre'],
                'ubicacion' => $fila['hotel_ubicacion'],
                'idLocalidad' => $fila['hotel_FK_IdLocalidad'],
                'localidad' => Localidad::selectLocalidad($fila['hotel_FK_IdLocalidad']),
                'habitaciones' => []
            ];

            if ($fila['hab_IdHabitacion']) {
                $hoteles[$hotelId]['habitaciones'][] = [
                    'id' => $fila['hab_IdHabitacion'],
                    'nombre' => $fila['hab_nombre'],
                    'tipo' => $fila['hab_Tipo'],
                    'precio' => $fila['hab_PrecioUnitario'],
                    'm2' => $fila['hab_m2'],
                    'imagen' => $fila['hab_Imagen'],
                ];
            }
        }

        $hoteles = array_values($hoteles);
        return $hoteles;
    }

    function createHotel($nombre , $fkIdLocalidad, $ubicacion, $usuario){
        echo Hotel::createHotel($nombre, $fkIdLocalidad, $ubicacion, $usuario);
    }

    function deleteHotel($id){
        echo Hotel::deleteHotel($id);
    }

    function updateHotel($id, $nombre, $fkIdLocalidad, $ubicacion){
        echo Hotel::updateHotel($id, $nombre, $fkIdLocalidad, $ubicacion);
    }
?>