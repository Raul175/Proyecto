<?php
    require_once('database/db.php');
    require_once('models/reserva_model.php');
    require_once('models/room_model.php');
    require_once('models/suite_model.php');
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
            if (Suite::comprobarSuite($habitacion)['Codigo'] != $vip || $vip == "") {
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
        $phpmailer->Password = 'wqfr eyqm equc awqf';
        $phpmailer->setFrom('raugon9@gmail.com', 'RolvaHotels');
        $phpmailer->addAddress($correo, $usuario);
        $phpmailer->isHTML(true);
        $phpmailer->Subject = 'Aviso de Incidencia';

        $phpmailer->Body = '
            <div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333333; max-width: 600px; margin: 0 auto;">
    
                <h2 style="color: #2c3e50; margin-bottom: 20px;">Estimado/a huésped $usuario,</h2>

                <p style="margin-bottom: 20px;">
                    Le contactamos con una actualización inmediata sobre el estado de la incidencia "$incidencia" reportada en su habitación.
                </p>

                <hr style="border: 0; border-top: 1px solid #eeeeee;">

                <div style="background-color: #ebf5fb; padding: 15px; border-radius: 5px; margin-bottom: 25px; border-left: 5px solid #3498db;">
                    <h3 style="color: #27ae60; margin-top: 0; font-size: 1.2em;">🛠️ Solución en Curso: Equipo de Mantenimiento Despachado</h3>
                    <p style="margin-bottom: 0;">
                        Confirmamos que el reporte ha sido recibido y priorizado. Un técnico de mantenimiento ya se dirige a su habitación para diagnosticar e iniciar la reparación del problema.
                    </p>
                </div>

                <h3 style="color: #f39c12; margin-top: 25px; font-size: 1.1em;">⏱️ Próximos Pasos</h3>
                
                <p>Para garantizar una resolución rápida y con la mínima interrupción a su estancia:</p>
                
                <ul style="padding-left: 20px;">
                    <li style="margin-bottom: 10px;">
                        Apreciaríamos que, si es posible, facilite el acceso a la habitación al personal de mantenimiento a su llegada.
                    </li>
                    <li>
                        Si fuera necesario, nuestro equipo se comunicará con usted directamente a su número de contacto o al teléfono de la habitación antes de ingresar.
                    </li>
                </ul>

                <p style="margin-top: 30px;">
                    Lamentamos profundamente cualquier inconveniente que esto pueda causarle durante su estancia. Nuestro objetivo es restaurar su comodidad con la mayor brevedad.
                </p>

                <p style="margin-top: 20px;">
                    Atentamente,
                </p>
                <p style="font-weight: bold; margin-top: 5px; color: #34495e;">
                    El Equipo de Atención al Huésped de RolvaHotels
                </p>
            </div>
        ';

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
        $phpmailer->SMTPDebug = 2;
        $phpmailer->Debugoutput = 'html';
        $phpmailer->Host = 'smtp.gmail.com';
        $phpmailer->SMTPAuth = true;
        $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $phpmailer->Port = 587;
        $phpmailer->Username = 'raugon9@gmail.com';
        $phpmailer->Password = 'wqfr eyqm equc awqf';
        $phpmailer->setFrom('raugon9@gmail.com', 'Sistema de Reservas');
        $phpmailer->addAddress($reservas['correo'], $reservas['nombre']);
        $phpmailer->isHTML(true);
        $phpmailer->Subject = 'Factura de tu reserva';

        $phpmailer->Body = "
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"table-layout: fixed; background-color: #f4f4f4; font-family: Arial, sans-serif;\">
    <tr>
        <td align=\"center\" style=\"padding: 20px 0 30px 0;\">
            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" style=\"border-collapse: collapse; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);\">
                <tr>
                    <td style=\"padding: 40px 30px 40px 30px;\">
                        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
                            <tr>
                                <td style=\"color: #333333; font-size: 24px; font-weight: bold; padding-bottom: 20px; border-bottom: 1px solid #eeeeee;\">
                                    <h2>✅ Gracias por tu pago</h2>
                                </td>
                            </tr>
                            <tr>
                                <td style=\"padding: 20px 0 20px 0; color: #555555; font-size: 16px; line-height: 24px;\">
                                    <p>Tu reserva ha sido confirmada con éxito. A continuación, encontrarás los detalles de tu compra:</p>
                                </td>
                            </tr>
                            <tr>
                                <td style=\"padding-bottom: 30px;\">
                                    <ul style=\"list-style: none; padding: 0; margin: 0;\">
                                        <li style=\"padding: 8px 0; border-bottom: 1px dashed #dddddd;\">
                                            <strong style=\"color: #333333;\">Fecha de inicio:</strong> <span style=\"float: right; color: #007bff;\">$finicio</span>
                                        </li>
                                        <li style=\"padding: 8px 0; border-bottom: 1px dashed #dddddd;\">
                                            <strong style=\"color: #333333;\">Fecha de fin:</strong> <span style=\"float: right; color: #007bff;\">$ffin</span>
                                        </li>
                                        <li style=\"padding: 10px 0 0 0;\">
                                            <strong style=\"color: #333333; font-size: 18px;\">Total pagado:</strong> <span style=\"float: right; color: #28a745; font-size: 18px; font-weight: bold;\">$monto €</span>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style=\"padding: 10px 0 0 0; color: #555555; font-size: 16px; line-height: 24px;\">
                                    <p>¡Gracias por confiar en nuestros servicios! Si tienes alguna pregunta, no dudes en contactarnos.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor=\"#f7f7f7\" style=\"padding: 15px 30px 15px 30px; border-top: 1px solid #eeeeee; text-align: center; color: #aaaaaa; font-size: 12px;\">
                        Este es un correo electrónico automático, por favor no respondas a este mensaje.
                    </td>
                </tr>
            </table>
            </td>
    </tr>
</table>
";
        echo updateFactura($factura,$reserva,$reservas['nombre'],$reservas['correo']);

        echo Reserva::pagar($habitacion,$usuario,$factura, $reserva);

        if(!$phpmailer->send()){
            echo "No existe su correo electrónico o no se ha podido enviar el correo de confirmación......";
        }

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

    function selectAllReservasGerente($id){
        return Reserva::selectAllReservasGerente($id);
    }

    function selectReservasUserId($id){
        return Reserva::selectReservasUserId($id);
    }
?>