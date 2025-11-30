<?php
    require_once('database/db.php');
    require_once('models/cama_model.php');

    if(isset($_POST['insertar'])){
        $cama = Cama::checkCama($_POST['tipo']);
        if(!empty($cama) && $cama[0]['Tipo'] == $_POST['tipo']){
            echo "Ya existe este tipo de cama";
        }else{
            createCama($_POST['tipo']);
        }
    }
    if(isset($_POST['actualizar'])){
        $cama = Cama::checkCama($_POST['tipo']);
        if(!empty($cama) && $cama[0]['Tipo'] == $_POST['tipo'] && $cama[0]['IdCama'] != $_POST['id']){
            echo "Ya existe este tipo de cama";
        }else{
            updateCama($_POST['id'], $_POST['tipo']);
        }
    }
    if(isset($_POST['eliminar'])){
        deleteCama($_POST['id']);
    }

    if(isset($_POST['aplicar'])){
        $aplicaciones = Cama::checkAplicar($_POST['habitacion'], $_POST['cama']);
        //if(!empty($aplicaciones) && $aplicaciones['IdCama'] == $_POST['cama'] && $aplicaciones['IdHabitacion'] == $_POST['habitacion']){
        //    echo "Ya existe esta aplicación";
        //}else{
            aplicarCama($_POST['habitacion'], $_POST['cama']);
        //}
    }
    if(isset($_POST['eliminar1'])){
        deleteAplica($_POST['habitacion'], $_POST['cama']);
    }
    

    function selectAllCama(){
        return Cama::selectAllCama();
    }

    function selectAllCamaRoom($habitacion){
        return Cama::selectAllCamaRoom($habitacion);
    }

    function createCama($tipo){
        echo Cama::createCama($tipo);
    }

    function deleteCama($id){
        echo Cama::deleteCama($id);
    }

    function updateCama($id, $tipo){
        echo Cama::updateCama($id, $tipo);
    }

    function selectAllAplica(){
        require_once('controllers/room_controller.php');
        $habitaciones = selectAllRooms();
        if(empty($habitaciones)){
            $habitaciones =  [];
        }
        $aplicados = Cama::selectAllAplica();
        if(empty($aplicados)){
            $aplicados = [];
        }
        $codAplicados = [];

        foreach ($habitaciones as $habitacion) {
            $codAplicados[$habitacion['IdHabitacion']] = [
                'habitacion' => $habitacion,
                'camas' => []
            ];
            foreach ($aplicados as $aplicado) {
                if($habitacion['IdHabitacion'] == $aplicado['IdHabitacion']){
                    $codAplicados[$habitacion['IdHabitacion']]['camas'][] = $aplicado;
                }
            }
        }

        return $codAplicados;
    }

    function selectAllAplicaGerente(){
        require_once('controllers/room_controller.php');
        $habitaciones = selectAllRoomsGerente($_SESSION['id']);
        if(empty($habitaciones)){
            $habitaciones =  [];
        }
        $aplicados = Cama::selectAllAplica();
        if(empty($aplicados)){
            $aplicados = [];
        }
        $codAplicados = [];

        foreach ($habitaciones as $habitacion) {
            $codAplicados[$habitacion['IdHabitacion']] = [
                'habitacion' => $habitacion,
                'camas' => []
            ];
            foreach ($aplicados as $aplicado) {
                if($habitacion['IdHabitacion'] == $aplicado['IdHabitacion']){
                    $codAplicados[$habitacion['IdHabitacion']]['camas'][] = $aplicado;
                }
            }
        }

        return $codAplicados;
    }

    function aplicarCama($habitacion, $cama){
        echo Cama::aplicarCama($habitacion, $cama);
    }
    
    function deleteAplica($habitacion, $cama){
        echo Cama::deleteAplica($habitacion, $cama);
    }
?>