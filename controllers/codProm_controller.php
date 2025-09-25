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