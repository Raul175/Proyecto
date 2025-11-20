<?php
    session_start();
    require_once 'Router.php';
    use Bramus\Router\Router;

    $router = new Router();

    //Comprobar y ajustar las reservas
    require_once('controllers/reserva_controller.php');
    ajustar();

    //Rutas a las views del usuario
    $router->get("/index.php", function(){ include "views/home.php";unset($_SESSION['habitaciones']); });
    $router->get("/", function(){ include "views/home.php";unset($_SESSION['habitaciones']); });
    $router->get("/sobre", function(){ include "views/about.php";unset($_SESSION['habitaciones']); });
    $router->get("/servicio", function(){ include "views/service.php";unset($_SESSION['habitaciones']); });
    $router->get("/habitaciones", function(){ include "views/rooms.php"; });
    $router->get("/contacto", function(){ include "views/contact.php";unset($_SESSION['habitaciones']); });
    $router->get("/politicasPrivacidad", function(){ include "views/privacypolicies.php";unset($_SESSION['habitaciones']); });
    $router->match("GET|POST", "/habitacion", function(){ include "views/room.php";unset($_SESSION['habitaciones']); });
    $router->match("GET|POST", "/reserva", function(){ include "views/reserva.php";unset($_SESSION['habitaciones']); });
    $router->match("GET|POST", "/user", function(){ include "views/user.php";unset($_SESSION['habitaciones']); });

    //Rutas a las views del admin
    $router->get("/admin", function(){ 
        //if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
            include "admin/admin.php";unset($_SESSION['habitaciones']); 
        //}else{
        //    header("Location: /Proyecto");
        //}
    });
    $router->get("/admin/habitaciones", function(){ 
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
            include "admin/habitaciones.php";unset($_SESSION['habitaciones']); 
        }else{
            header("Location: /Proyecto");
        }
    });
    $router->get("/admin/hoteles", function(){ 
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
            include "admin/hoteles.php";unset($_SESSION['habitaciones']);
        }else{
            header("Location: /Proyecto");
        } 
    });
    $router->get("/admin/localidades", function(){ 
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
            include "admin/localidades.php";unset($_SESSION['habitaciones']); 
        }else{
            header("Location: /Proyecto");
        }
    });
    $router->get("/admin/usuarios", function(){ 
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
            include "admin/usuarios.php";unset($_SESSION['habitaciones']);
        }else{
            header("Location: /Proyecto");
        }
     });
    $router->get("/admin/codigos", function(){ 
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
            include "admin/codigos.php";unset($_SESSION['habitaciones']); 
        }else{
            header("Location: /Proyecto");
        }
    });
    $router->get("/admin/aplicarCodProm", function(){
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
            include "admin/aplicarCodProm.php";unset($_SESSION['habitaciones']);
        }else{
            header("Location: /Proyecto");
        }
    });
    $router->get("/admin/aplicarCama", function(){ 
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
            include "admin/aplicarCama.php";unset($_SESSION['habitaciones']); 
        }else{
            header("Location: /Proyecto");
        }
    });
    $router->get("/admin/aplicarComplemento", function(){ 
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
            include "admin/aplicarComplemento.php";unset($_SESSION['habitaciones']); 
        }else{
            header("Location: /Proyecto");
        }
    });
    $router->get("/admin/camas", function(){ 
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
            include "admin/camas.php";unset($_SESSION['habitaciones']); 
        }else{
            header("Location: /Proyecto");
        }
    });
    $router->get("/admin/complementos", function(){ 
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
            include "admin/complementos.php";unset($_SESSION['habitaciones']); 
        }else{
            header("Location: /Proyecto");
        }
    });
    $router->get("/admin/facturas", function(){ 
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
            include "admin/facturas.php";unset($_SESSION['habitaciones']); 
        }else{
            header("Location: /Proyecto");
        }
    });

    //Rutas a las views del gerente
    $router->get("/gerente", function(){ 
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 2){
            include "gerente/gerente.php";unset($_SESSION['habitaciones']); 
        }else{
            header("Location: /Proyecto");
        }
    });
    $router->get("/gerente/habitaciones", function(){ 
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 2){
            include "gerente/habitaciones.php";unset($_SESSION['habitaciones']); 
        }else{
            header("Location: /Proyecto");
        }
    });
    $router->get("/gerente/hoteles", function(){ 
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 2){
            include "gerente/hoteles.php";unset($_SESSION['habitaciones']);
        }else{
            header("Location: /Proyecto");
        } 
    });
    $router->get("/gerente/aplicarCodProm", function(){
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 2){
            include "gerente/aplicarCodProm.php";unset($_SESSION['habitaciones']);
        }else{
            header("Location: /Proyecto");
        }
    });
    $router->get("/gerente/aplicarCama", function(){ 
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 2){
            include "gerente/aplicarCama.php";unset($_SESSION['habitaciones']); 
        }else{
            header("Location: /Proyecto");
        }
    });
    $router->get("/gerente/aplicarComplemento", function(){ 
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 2){
            include "gerente/aplicarComplemento.php";unset($_SESSION['habitaciones']); 
        }else{
            header("Location: /Proyecto");
        }
    });
    $router->get("/gerente/facturas", function(){ 
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 2){
            include "gerente/facturas.php";unset($_SESSION['habitaciones']); 
        }else{
            header("Location: /Proyecto");
        }
    });

    //Controladores
    $router->match("GET|POST", "/userController", function(){ require_once("controllers/users_controller.php"); });
    $router->match("GET|POST", "/clientController", function(){ require_once("controllers/client_controller.php"); });
    $router->match("GET|POST", "/adminController", function(){ require_once("controllers/admin_controller.php"); });
    $router->match("GET|POST", "/gerenteController", function(){ require_once("controllers/gerente_controller.php"); });
    $router->match("GET|POST", "/dbController", function(){ require_once("controllers/db_controller.php"); });
    $router->match("GET|POST", "/roomController", function(){ require_once("controllers/room_controller.php"); });
    $router->match("GET|POST", "/hotelController", function(){ require_once("controllers/hotel_controller.php"); });
    $router->match("GET|POST", "/localidadController", function(){ require_once("controllers/localidad_controller.php"); });
    $router->match("GET|POST", "/codPromController", function(){ require_once("controllers/codProm_controller.php"); });
    $router->match("GET|POST", "/aplicaCodPromController", function(){ require_once("controllers/aplicaCodProm_controller.php"); });
    $router->match("GET|POST", "/aplicaCamaController", function(){ require_once("controllers/aplicaCama_controller.php"); });
    $router->match("GET|POST", "/aplicaComplementoController", function(){ require_once("controllers/aplicaComplemento_controller.php"); });
    $router->match("GET|POST", "/reservaController", function(){ require_once("controllers/reserva_controller.php"); });
    $router->match("GET|POST", "/facturaController", function(){ require_once("controllers/factura_controller.php"); });
    $router->match("GET|POST", "/camaController", function(){ require_once("controllers/cama_controller.php"); });
    $router->match("GET|POST", "/complementoController", function(){ require_once("controllers/complemento_controller.php"); });
    $router->match("GET|POST", "/comentarioController", function(){ require_once("controllers/comentario_controller.php"); });

    //Modelos
    $router->match("GET|POST", "/userModel", function(){ require_once("models/users_model.php"); });
    $router->match("GET|POST", "/clientModel", function(){ require_once("models/client_model.php"); });
    $router->match("GET|POST", "/adminModel", function(){ require_once("models/admin_model.php"); });
    $router->match("GET|POST", "/gerenteModel", function(){ require_once("models/gerente_model.php"); });
    $router->match("GET|POST", "/dbModel", function(){ require_once("models/db_model.php"); });
    $router->match("GET|POST", "/roomModel", function(){ require_once("models/room_model.php"); });
    $router->match("GET|POST", "/hotelModel", function(){ require_once("models/hotel_model.php"); });
    $router->match("GET|POST", "/localidadModel", function(){ require_once("models/localidad_model.php"); });
    $router->match("GET|POST", "/codPromModel", function(){ require_once("models/codProm_model.php"); });
    $router->match("GET|POST", "/aplicaCodPromModel", function(){ require_once("models/aplicaCodProm_model.php"); });
    $router->match("GET|POST", "/aplicaCamaModel", function(){ require_once("models/aplicaCama_model.php"); });
    $router->match("GET|POST", "/aplicaComplementoModel", function(){ require_once("models/aplicaComplemento_model.php"); });
    $router->match("GET|POST", "/reservaModel", function(){ require_once("models/reserva_model.php"); });
    $router->match("GET|POST", "/facturaModel", function(){ require_once("models/factura_model.php"); });
    $router->match("GET|POST", "/camaModel", function(){ require_once("models/cama_model.php"); });
    $router->match("GET|POST", "/complementoModel", function(){ require_once("models/complemento_model.php"); });
    $router->match("GET|POST", "/comentarioModel", function(){ require_once("models/comentario_model.php"); });

    $router->run();
?>