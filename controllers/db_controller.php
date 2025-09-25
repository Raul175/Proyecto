<?php
    require_once('models/db_model.php');

    function createDB(){
        echo DataBase::createBD();
    }

    function deleteDB(){
        DataBase::deleteBD();
    }
?>