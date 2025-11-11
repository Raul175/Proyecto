<?php
    require_once('models/db_model.php');
    require_once('models/codProm_model.php');

    if(isset($_POST['insertar'])){
        $codProm = CodigoPromocional::checkCodProm($_POST['codigo'],null);
        if(!empty($codProm) && $codProm[0]['codigo'] == $_POST['codigo']){
            echo "Ya existe este código";
        }else{
            createCodProm($_POST['codigo'], $_POST['descuento']);
        }
    }
    if(isset($_POST['actualizar'])){
        $codProm = CodigoPromocional::checkCodProm($_POST['codigo'],null);
        if(!empty($codProm) && $codProm[0]['codigo'] == $_POST['codigo'] && $codProm[0]['idCodigo'] != $_POST['id']){
            echo "Ya existe este código";
        }else{
            updateCodProm($_POST['id'], $_POST['codigo'], $_POST['descuento']);
        }
    }
    if(isset($_POST['eliminar'])){
        deleteCodProm($_POST['id']);
    }
    if(isset($_POST['precio'])){
        $codigo = $_POST['codigo'] ?? null;
        $habitacion = $_POST['habitacion'] ?? null;
        $codProm = CodigoPromocional::checkCodProm($codigo,$habitacion);
        if(!empty($codProm)){
            $precio = str_replace(',', '.', $_POST['precio']);
            $precio = floatval($_POST['precio']);
            $descuento = floatval($codProm[0]['descuento']);
            $precioFinal = $precio - ($precio * $descuento/100);
            echo $precioFinal;
        }else{
            echo false;
        }
    }

    if(isset($_POST['aplicar'])){
        $aplicaciones = CodigoPromocional::checkAplicar($_POST['habitacion'], $_POST['codigo']);
        if(!empty($aplicaciones) && $aplicaciones['IdCodigo'] == $_POST['codigo'] && $aplicaciones['IdHabitacion'] == $_POST['habitacion']){
            echo "Ya existe esta aplicación";
        }else{
            aplicarCodProm($_POST['habitacion'], $_POST['codigo'], $_POST['finicio'], $_POST['fin']);
        }
    }
    if(isset($_POST['update'])){
        $aplicaciones = CodigoPromocional::checkAplicar($_POST['habitacion'], $_POST['codigo']);
        // if(!empty($aplicaciones) && $aplicaciones['IdCodigo'] == $_POST['codigo'] && $aplicaciones['IdHabitacion'] == $_POST['IdCodigo']){
        //     echo "Ya existe esta aplicación";
        // }else{
            updateAplica($_POST['habitacion'], $_POST['codigo'], $_POST['finicio'], $_POST['fin']);
        // }
    }
    if(isset($_POST['eliminar1'])){
        deleteAplica($_POST['habitacion'], $_POST['codigo']);
    }
    
    function selectAllAplica(){
        require_once('controllers/room_controller.php');
        $habitaciones = selectAllRooms();
        if(empty($habitaciones)){
            $habitaciones =  [];
        }
        $aplicados = CodigoPromocional::selectAllAplica();
        if(empty($aplicados)){
            $aplicados = [];
        }
        $codAplicados = [];

        foreach ($habitaciones as $habitacion) {
            $codAplicados[$habitacion['IdHabitacion']] = [
                'habitacion' => $habitacion,
                'codigos' => []
            ];
            foreach ($aplicados as &$aplicado) {
                if($habitacion['IdHabitacion'] == $aplicado['IdHabitacion']){
                    $codAplicados[$habitacion['IdHabitacion']]['codigos'][] = $aplicado;
                }
            }
        }

        return $codAplicados;
    }

    function selectAllAplicaGerente(){
        $habitaciones = selectAllRoomsGerente($_SESSION['id']);
        if(empty($habitaciones)){
            $habitaciones =  [];
        }
        $aplicados = CodigoPromocional::selectAllAplica();
        if(empty($aplicados)){
            $aplicados = [];
        }
        $codAplicados = [];

        foreach ($habitaciones as $habitacion) {
            $codAplicados[$habitacion['IdHabitacion']] = [
                'habitacion' => $habitacion,
                'codigos' => []
            ];
            foreach ($aplicados as &$aplicado) {
                if($habitacion['IdHabitacion'] == $aplicado['IdHabitacion']){
                    $codAplicados[$habitacion['IdHabitacion']]['codigos'][] = $aplicado;
                }
            }
        }

        return $codAplicados;
    }

    function aplicarCodProm($habitacion, $codigo, $inicio, $fin){
        echo CodigoPromocional::aplicarCodProm($habitacion, $codigo, $inicio, $fin);
    }

    function updateAplica($habitacion, $codigo, $inicio, $fin){
        echo CodigoPromocional::updateAplica($habitacion, $codigo, $inicio, $fin);
    }

    function deleteAplica($habitacion, $codigo){
        echo CodigoPromocional::deleteAplica($habitacion, $codigo);
    }

    function selectAllCodProm(){
        return CodigoPromocional::selectAllCodProm();
    }

    function createCodProm($codigo, $descuento){
        echo CodigoPromocional::createCodProm($codigo, $descuento);
    }

    function deleteCodProm($id){
        echo CodigoPromocional::deleteCodProm($id);
    }

    function updateCodProm($id, $codigo, $descuento){
        echo CodigoPromocional::updateCodProm($id, $codigo, $descuento);
    }
?>