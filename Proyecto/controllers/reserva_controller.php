<?php
    require_once('models/db_model.php');
    require_once('models/reserva_model.php');
    require_once('controllers/factura_controller.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';
    require 'PHPMailer/Exception.php';

    extract($_POST);

    if(isset($_POST['inicio'])){
        $comprobar = Reserva::checkReserva($habitacion,$usuario,$finicio,$fin);
        if(count($comprobar) > 0){
            echo "Ya existe una reserva en esas fechas o ya tienes una reserva en esa habitación";
            return;
        }
        if($tipo == "vip"){
            require_once('models/room_model.php');
            if (Habitacion::comprobarSuite($habitacion)['Codigo'] != $vip || $vip == "") {
                echo "El campo de codigo VIP es incorrecto";
                return;
            }
        }
        $factura = createFactura($monto);
        if($factura == false){
            echo "Error al realizar la reserva";
            return;
        }
        echo reservar($habitacion,$usuario,$factura,$comienzo,$finicio,$fin,$codigo,$vip,$complemento,$nombre,$correo) . "-" . $factura;
    }
    if(isset($_POST['confirmar'])){
        if(isset($_POST['reserva'])){
            confirmar(null,null,null,$comienzo, $reserva);
        }else{
            confirmar($habitacion,$usuario,$factura,$comienzo, null);
        }
    }
    if(isset($_POST['pagar'])){
        if(isset($_POST['reserva'])){
            pagar(null,null,null, $monto, $email, $nombre, $finicio, $ffin, $reserva);
        }else{
            pagar($habitacion,$usuario,$factura, $monto, $email, $nombre, $finicio, $ffin, null);
        }
    }

    if(isset($_POST['resolver'])){
        /* Enviar correo electrónico de aviso */
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.gmail.com';
        $phpmailer->SMTPAuth = true;
        $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $phpmailer->Port = 587;
        $phpmailer->Username = 'raugon9@gmail.com';
        $phpmailer->Password = 'xavn wldq nnsh jhuv';
        $phpmailer->setFrom('raugon9@gmail.com', 'Sistema de Reservas');
        $phpmailer->addAddress($correo, $usuario);
        $phpmailer->isHTML(true);
        $phpmailer->Subject = 'Aviso de Incidencia';

        $phpmailer->Body = "
            <h2>Buenas señor/a, ".$usuario."</h2>
            <p>Se dirige un técnico para resolver la incidencia ".$incidencia."</p>
            <p>Gracias por confiar en nosotros.</p>
        ";

        if(!$phpmailer->send()){
            echo "No existe su correo electrónico o no se ha podido enviar el correo de confirmación.";
        }
        Reserva::resolver($reserva);
    }

    if(isset($_POST['cancelar'])){
        cancelar($reserva);
    }
    if(isset($_POST['comprobar'])){
        ajustar();
        exit;
    }
    if(isset($_POST['insertarIncidencia'])){
        echo Reserva::insertarIncidencia($reserva, $incidencia);
    }

    function reservar($habitacion,$usuario,$factura,$comienzo,$inicio,$fin,$codigo,$vip,$complemento,$nombre,$correo){
        echo Reserva::reservar($habitacion,$usuario,$factura,$comienzo,$inicio,$fin,$codigo,$vip,$complemento, $nombre, $correo);
    }

    function confirmar($habitacion,$usuario,$factura,$comienzo,$reserva){
        echo Reserva::confirmar($habitacion,$usuario,$factura,$comienzo, $reserva);
    }

    function pagar($habitacion,$usuario,$factura,$monto,$email,$nombre,$finicio,$ffin,$reserva){
        $reservas = Reserva::selectReserva($habitacion,$usuario,$factura,$reserva);
        /* Enviar correo electrónico de confirmación */
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.gmail.com';
        $phpmailer->SMTPAuth = true;
        $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $phpmailer->Port = 587;
        $phpmailer->Username = 'raugon9@gmail.com';
        $phpmailer->Password = 'xavn wldq nnsh jhuv';
        $phpmailer->setFrom('raugon9@gmail.com', 'Sistema de Reservas');
        $phpmailer->addAddress($reservas['correo'], $reservas['nombre']);
        $phpmailer->isHTML(true);
        $phpmailer->Subject = 'Factura de tu reserva';

        $phpmailer->Body = "
            <h2>Gracias por tu pago</h2>
            <p>Tu reserva ha sido confirmada.</p>
            <ul>
                <li><strong>Fecha de inicio:</strong> $finicio</li>
                <li><strong>Fecha de fin:</strong> $ffin</li>
                <li><strong>Total:</strong> $monto €</li>
            </ul>
            <p>Gracias por confiar en nosotros.</p>
        ";

        if(!$phpmailer->send()){
            echo "No existe su correo electrónico o no se ha podido enviar el correo de confirmación.";
        }

        echo updateFactura($factura,$reserva,$nombre,$email);

        echo Reserva::pagar($habitacion,$usuario,$factura, $reserva);
    }
    function cancelar($reserva){
        echo Reserva::cancelar($reserva);
    }
    function ajustar(){
        Reserva::ajustar();
    }

    function selectAllReservas(){
        return Reserva::selectAllReservas();
    }

    function selectReservasUserId($id){
        return Reserva::selectReservasUserId($id);
    }
?>