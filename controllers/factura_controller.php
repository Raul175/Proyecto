<?php
    require_once('database/db.php');
    require_once('models/factura_model.php');

    function createFactura($monto){
        return Factura::createFactura($monto);
    }

    function updateFactura($factura,$reserva,$nombre,$email){
        return Factura::updateFactura($factura,$reserva,$nombre,$email);
    }
?>