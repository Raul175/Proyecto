<?php
    require_once('models/db_model.php');
    require_once('models/factura_model.php');

    function createFactura($monto){
        return Factura::createFactura($monto);
    }

    function updateFactura($factura,$reserva,$nombre,$email){
        return Factura::updateFactura($factura,$reserva,$nombre,$email);
    }
?>