<?php
    require_once('database/db.php');
    require_once('models/users_model.php');
    require_once('models/client_model.php');
    require_once('models/admin_model.php');
    require_once('models/gerente_model.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

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
        if(!empty($usuario) && ($usuario['Correo'] == $_POST['correo'] || $usuario['DNI'] == $_POST['dni']) && $usuario['IdUsuario'] != $_POST['id']){
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

        /* Enviar correo electrónico de aviso */
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.gmail.com';
        $phpmailer->SMTPAuth = true;
        $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $phpmailer->Port = 587;
        $phpmailer->Username = 'raugon9@gmail.com';
        $phpmailer->Password = 'wqfr eyqm equc awqf';
        $phpmailer->setFrom('raugon9@gmail.com', 'Registro exitoso');
        $phpmailer->addAddress($correo, $nombre);
        $phpmailer->isHTML(true);
        $phpmailer->Subject = '¡Tu cuenta en RolvaHotels está lista!';

        $phpmailer->Body = "
        <body style=\"font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;\">

            <table role=\"presentation\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"table-layout: fixed;\">
                <tr>
                    <td align=\"center\" style=\"padding: 20px 0;\">
                        
                        <table role=\"presentation\" width=\"600\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);\">
                            
                            <tr>
                                <td style=\"padding: 40px 40px 30px 40px; text-align: center;\">
                                    
                                    <h2 style=\"color: #333333; margin-top: 0; font-size: 22px;\">¡Registro Completado con Éxito!</h2>
                                    
                                    <p style=\"color: #555555; line-height: 1.6;\">
                                        Hola <strong>$nombre $apellidos</strong>,
                                    </p>
                                    
                                    <p style=\"color: #555555; line-height: 1.6;\">
                                        Este mensaje confirma que tu registro en nuestra plataforma ha sido completado exitosamente.
                                    </p>
                                    
                                    <p style=\"color: #555555; line-height: 1.6;\">
                                        Tu cuenta está activa y lista para ser utilizada.
                                    </p>

                                    <div style=\"background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin: 25px 0; border: 1px solid #eeeeee;\">
                                        <p style=\"color: #333333; margin: 0; font-size: 16px;\">
                                            Tu Email de Acceso: <strong>$correo</strong>
                                        </p>
                                    </div>

                                    <p style=\"color: #555555; line-height: 1.6; font-size: 14px;\">
                                        Recuerda utilizar la contraseña que elegiste durante el proceso de registro para iniciar sesión.
                                    </p>
                                    
                                </td>
                            </tr>
                            
                            <tr>
                                <td style=\"padding: 20px 40px; border-top: 1px solid #eeeeee; text-align: center; background-color: #f4f4f4; border-radius: 0 0 8px 8px;\">
                                    <p style=\"margin: 0; color: #888888; font-size: 12px;\">
                                        Si tienes alguna duda, por favor responde a este correo.
                                    </p>
                                    <p style=\"margin: 5px 0 0 0; color: #888888; font-size: 12px;\">
                                        El equipo de RolvaHotels
                                    </p>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </body>
        ";

        if(!$phpmailer->send()){
            echo "No existe su correo electrónico o no se ha podido enviar el correo de confirmación.";
        }
        }elseif ($admin == 1) {
            echo admin::createAdmin($id);
        }else{
            echo gerente::createGerente($id, $nacimiento);
        }
    }

    function deleteUser($id){
        echo admin::deleteUser($id);
    }

    function updateUser($id, $nombre, $apellidos, $correo, $contraseña, $dni, $sexo, $domicilio, $nacimiento, $admin){
        echo admin::updateUser($id, $nombre, $apellidos, $correo, $contraseña, $dni, $sexo, $admin);
        if ($admin == 0) {
            echo cliente::updateClient($id, $domicilio, $nacimiento);
        }elseif ($admin == 2) {
            echo gerente::updateGerente($id, $nacimiento);
        }
    }
?>