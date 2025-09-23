<?php
    require_once('models/db_model.php');
    require_once('models/aplicaCodProm_model.php');
    require_once('models/codProm_model.php');
    require_once('controllers/room_controller.php');

    if(isset($_POST['aplicar'])){
        $aplicaciones = Aplicar::checkAplicar($_POST['habitacion'], $_POST['codigo']);
        if(!empty($aplicaciones) && $aplicaciones['IdCodigo'] == $_POST['codigo'] && $aplicaciones['IdHabitacion'] == $_POST['habitacion']){
            echo "Ya existe esta aplicación";
        }else{
            aplicarCodProm($_POST['habitacion'], $_POST['codigo'], $_POST['finicio'], $_POST['fin']);
        }
    }
    if(isset($_POST['update'])){
        $aplicaciones = Aplicar::checkAplicar($_POST['habitacion'], $_POST['codigo']);
        // if(!empty($aplicaciones) && $aplicaciones['IdCodigo'] == $_POST['codigo'] && $aplicaciones['IdHabitacion'] == $_POST['IdCodigo']){
        //     echo "Ya existe esta aplicación";
        // }else{
            updateAplica($_POST['habitacion'], $_POST['codigo'], $_POST['finicio'], $_POST['fin']);
        // }
    }
    if(isset($_POST['eliminar'])){
        deleteAplica($_POST['habitacion'], $_POST['codigo']);
    }

    function selectAllAplica(){
        $habitaciones = selectAllRooms();
        if(empty($habitaciones)){
            $habitaciones =  [];
        }
        $aplicados = Aplicar::selectAllAplica();
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
        echo Aplicar::aplicarCodProm($habitacion, $codigo, $inicio, $fin);
    }

    function updateAplica($habitacion, $codigo, $inicio, $fin){
        echo Aplicar::updateAplica($habitacion, $codigo, $inicio, $fin);
    }

    function deleteAplica($habitacion, $codigo){
        echo Aplicar::deleteAplica($habitacion, $codigo);
    }
?>