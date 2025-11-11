<?php
    require_once('models/db_model.php');
    require_once('models/users_model.php');
    require_once('models/client_model.php');
    require_once('models/admin_model.php');
    require_once('models/gerente_model.php');

    if(!isset($_POST['admin'])){
        $_POST['admin'] = 0;
    }
    if(isset($_POST['login'])){
        login($_POST['correo'], $_POST['password']);
    }
    if(isset($_POST['insertar'])){
        $usuario = users::checkUser($_POST['correo'], $_POST['dni']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        if(!empty($usuario) && ($usuario['Correo'] == $_POST['correo'] || $usuario['DNI'] == $_POST['dni'])){
            echo "Ya existe este usuario";
        }else{
            createUser($_POST['nombre'], $_POST['apellidos'], $_POST['correo'], $password, $_POST['dni'], $_POST['sexo'], $_POST['domicilio'], $_POST['nacimiento'], $_POST['admin']);
        }
    }
    if(isset($_POST['actualizar'])){
        $usuario = users::checkUser($_POST['correo'], $_POST['dni']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        if(!empty($usuario) && ($usuario['Correo'] == $_POST['correo'] || $usuario['DNI'] == $_POST['dni'])  && $usuario['IdUsuario'] != $_POST['id']){
            echo "Ya existe este usuario";
        }else{
            updateUser($_POST['id'],$_POST['nombre'], $_POST['apellidos'], $_POST['correo'], $password, $_POST['dni'], $_POST['sexo'], $_POST['domicilio'], $_POST['nacimiento'], $_POST['admin']);
        }
    }
    if(isset($_POST['eliminar'])){
        deleteUser($_POST['id']);
    }

    function login($correo,$contraseña){
        $user = users::selectUser($correo,$contraseña);
        if ($user && password_verify($contraseña, $user['Contrasena'])) {
            users::iniciarSesion($user['Nombre'],$user['IdUsuario'],$correo,$user['Admin']);
            echo $user['Admin'];
        }else{
            echo "Este correo o contraseña no existen";
        }
    }

    function logout(){
        users::cerrarSesion();
    }

    function selectAllUsers(){
        return users::selectAllUsers();
    }

    function selectUserId($id){
        return users::selectUserId($id);
    }

    function selectAllUsersGerente(){
        return users::selectAllUsersGerente();
    }

    function createUser($nombre, $apellidos, $correo, $contraseña, $dni, $sexo, $domicilio, $nacimiento, $admin){
        $id = admin::createUser($nombre, $apellidos, $correo, $contraseña, $dni, $sexo, $admin);
        if ($admin == 0) {
            echo cliente::createClient($id, $domicilio, $nacimiento);
        }elseif ($admin == 2) {
            echo admin::createAdmin($id);
        }else{
            echo gerente::createGerente($id, $nacimiento);
        }
    }

    function deleteUser($id){
        echo admin::deleteUser($id);
    }

    function updateUser($id, $nombre, $apellidos, $correo, $contraseña, $dni, $sexo, $domicilio, $nacimiento, $admin){
        $id = admin::updateUser($id, $nombre, $apellidos, $correo, $contraseña, $dni, $sexo, $admin);
        if ($admin == 0) {
            echo cliente::updateClient($id, $domicilio, $nacimiento);
        }elseif ($admin == 1) {
            echo gerente::updateGerente($id, $nacimiento);
        }
    }
?>