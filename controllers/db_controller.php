<?php
    require_once('database/db.php');

    function createDB(){
        echo DataBase::createBD();
    }

    function deleteDB(){
        DataBase::deleteBD();
    }
?>