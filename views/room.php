<?php 
    require_once("controllers/comentario_controller.php");
    $habitacion = unserialize($_POST['habitacion']);
    if (empty($habitacion)){
        $habitacion = [];
    }
    $comentarios = selectAllComentario($habitacion['IdHabitacion']);
    if (empty($comentarios)){
        $comentarios = [];
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Habitación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/Proyecto/">

    <!-- Favicon -->
    <link href="/Proyecto/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">  

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="/Proyecto/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/Proyecto/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="/Proyecto/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/Proyecto/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/Proyecto/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Header Start -->
        <?php include("layout/cabecera.php"); ?>
        <!-- Header End -->

        <!-- Encabezado de página -->
        <div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-1.jpg);">
            <div class="container-fluid page-header-inner py-5">
                <div class="container text-center pb-5">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Detalles de Habitación</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="/Proyecto/">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="/Proyecto/habitaciones">Habitaciones</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Detalle</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Detalles de habitación -->
        <div class="container py-5">
            <div class="row">
                <!-- Imagen principal -->
                <div class="col-lg-6">
                    <img src="images/<?= $habitacion['imagen'] ?>" class="img-fluid rounded mb-4" alt="Imagen habitación">
                </div>

                <!-- Información -->
                <div class="col-lg-6">
                    <h2 class="mb-3"><?= $habitacion['Nombre'] ?><?= empty($habitacion['Tipo']) ? "" : " - ". $habitacion['Tipo'] ?></h2>
                    <p><i class="fa fa-map-marker-alt text-primary me-2"></i><b> Hotel: </b> <?= $habitacion['FK_IdHotel'] ?></p>
                    <p><i class="fas fa-map me-2"></i><b>Direccion:</b> <?= $habitacion['hotel_ubi'] ?> <i class="fas fa-envelope me-2"></i><b>Codigo Postal:</b> <?= $habitacion['hotel_ubi'] ?></p>
                    <p><strong>Precio:</strong> <?= $habitacion['PrecioUnitario'] ?>€/Noche</p>
                    <p><strong>Capacidad:</strong> <?= $habitacion['NPersonas'] ?> personas</p>
                    <p><strong>Camas: <br></strong> 
                    <?php foreach ($habitacion['camas'] as $cama): ?> 
                        <?= $cama['camas']." cama/s de ".$cama['Tipo']."<br>" ?>
                    <?php endforeach; ?>
                    <p><strong>Superficie:</strong> <?= $habitacion['m2'] ?> m²</p>
                    <div class="ps-2">
                    <?= $habitacion['CajaFuerte'] === 1 || $habitacion['CajaFuerte'] === null ? '' : '<i class="fa-solid fa-vault fa-1x ml-4"></i>' ?>
                    <?= $habitacion['Wifi'] == 1 || $habitacion['Wifi'] === null ? '' : '<i class="fas fa-wifi fa-1x ml-4"></i>' ?>
                    <?= $habitacion['Minibar'] == 1 || $habitacion['Minibar'] === null ? '' : '<i class="fas fa-wine-bottle fa-1x ml-4"></i>' ?>
                    </div>
                    
                    <?php 
                        if(isset($_SESSION['usuario'])){
                            $habitacion_serializada = serialize($habitacion);
                        ?>
                        <form action="reserva" method="post">
                            <input type="hidden" name="habitacion" value="<?= htmlspecialchars($habitacion_serializada) ?>">
                            <button type="submit" class="btn btn-personalizado2 py-2 px-4">Reservar</button>
                        </form>
                        <?php
                        }else{
                            echo '<a data-bs-toggle="modal" data-bs-target="#InicioSesionModal" id="IniciarSesion" class="btn btn-personalizado2 px-4 py-2 mt-3">Reservar</a>';
                        }
                    ?>
                </div>
            </div>
        </div>

        <!-- Newsletter Start -->
        <div class="container newsletter mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="row justify-content-center">
                <div class="col-lg-10 border rounded p-1">
                    <div class="border rounded text-center p-1">
                        <div class="bg-white rounded text-center p-5">
                            <div id="comentariosCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                
                                if (empty($comentarios)){
                                    echo '<div class="carousel-item active sin-fondo"><div class="row"><div class="col-md-12 text-center"><p>No hay comentarios disponibles.</p></div></div></div>';
                                }else{
                                    $comentarios = array_chunk($comentarios, 3); //Convierte el array de comentarios en grupos de 3 para el carrusel
                                    foreach ($comentarios as $grupos => $grupo):
                                    ?>
                                    <div class="carousel-item <?= $grupos == 0 ? 'active' : '' ?> sin-fondo">
                                        <div class="row">
                                            <?php foreach ($grupo as $comentario): ?>
                                                <div class="col-md-4">
                                                    <div class="bg-white rounded text-center p-3 m-2">
                                                        <h4><strong>Usuario:</strong> <?= htmlspecialchars($comentario['Nombre']) ?></h4>
                                                        <small>Fecha: <?= (new DateTime($comentario['Fecha']))->format('d/m/Y') ?></small>
                                                        <div class=" my-2">
                                                        <?php 
                                                        $estrellas = $comentario['NEstrellas'];
                                                        for ($i = 0; $i < $estrellas; $i++): ?>
                                                            <small class="fas fa-star text-primary"></small>
                                                        <?php endfor; ?>
                                                        <?php for ($i = $estrellas; $i < 5; $i++): ?>
                                                            <small class="far fa-star text-primary"></small>
                                                        <?php endfor; ?>
                                                        </div>
                                                        <p class="texto-comentario"><?= htmlspecialchars($comentario['Comentario']) ?></p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <?php endforeach;} ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#comentariosCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#comentariosCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Newsletter Start -->

        <!-- Footer Start -->
        <?php include("layout/pie.php"); ?>
        <!-- Footer End -->

    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
        $("#loginForm").submit(function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente

            const correo = $("#correo").val();
            const password = $("#password").val();

            let error = 0;

            const correoPattern = /^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!correoPattern.test(correo)) {
                $('#correo').addClass('is-invalid');
                $("#correo6-error").show();
                error = "Algún dato está mal introducido, revisa el correo y la contraseña";
            }else{
                $('#correo').removeClass('is-invalid');
                $("#correo6-error").hide();
            }

            const passwordPattern = /^[A-Za-z\d@$!%*#?&_-]{6,}$/;
            if (!passwordPattern.test(password)) {
                $('#password').addClass('is-invalid');
                $("#password-error").show();
                error = "Algún dato está mal introducido, revisa el correo y la contraseña";
            }else{
                $('#password').removeClass('is-invalid');
                $("#password-error").hide();
            }

            if (error == 0) {
                $.ajax({
                    url: '/Proyecto/userController',
                    type: 'POST',
                    data: {
                        correo: correo,
                        password: password,
                        login : 1
                    },
                    success: function(response) {
                        if (response == 1) {
                            window.location.href = "/Proyecto/admin";
                        } else if (response == 2) {
                            window.location.href = "/Proyecto/gerente";
                        } else if (response == 0) {
                            window.location.href = "/Proyecto/";
                        } else {
                            $("#error-message").html("Contraseña o correo mal introducidos");
                            $("#error-message").show();
                        }
                    },
                    error: function() {
                        $("#error-message").html('Ocurrió un error al procesar la solicitud.');
                        $("#error-message").show();
                    }
                });
            }else{
                $("#error-message").html(error);
                $("#error-message").show();
            }
        });
        $("#registerForm").submit(function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente

            let error = 0;

            const nombre = $(this).find("#nombre1").val().trim();
            const apellidos = $(this).find("#apellidos1").val().trim();
            const correo = $(this).find("#correo1").val().trim();
            const contraseña = $(this).find("#passwd1").val().trim();
            const dni = $(this).find("#dni1").val().trim();
            const sexo = $(this).find("#sexo1").val().trim();
            const domicilio = $(this).find("#domicilio1").val().trim();
            let admin = 0;
            const fnac = $(this).find("#nacimiento1").val().trim();

            const nacimiento = new Date(fnac);
            const hoy = new Date();
            let edad = hoy.getFullYear() - nacimiento.getFullYear();
            const cumpleEsteAno = hoy.getMonth() > nacimiento.getMonth() || (hoy.getMonth() === nacimiento.getMonth() && hoy.getDate() >= nacimiento.getDate());
            if (!cumpleEsteAno) edad--;
            const esMenor = edad < 18;

            if (fnac != "") {
                if (esMenor) {
                    $(this).find("#nacimiento-error1").text("No puedes crear una cuenta para un menor de edad")
                    $(this).find("#nacimiento-error1").show();
                    $('#nacimiento1').addClass('is-invalid');
                    error = 1;
                }else{
                    $(this).find("#nacimiento-error1").hide();
                }
            }else{
                $(this).find("#nacimiento-error1").show();
                $('#nacimiento1').addClass('is-invalid');
                error = 1;
            }

            const nombrePattern = /^[a-zA-Z0-9\s]{1,100}$/;
            if (!nombrePattern.test(nombre)) {
                $(this).find("#nombre-error1").show();
                $('#nombre1').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#nombre-error1").hide();
            }

            const apellidosPattern = /^[A-Za-z\s]{1,100}$/;
            if (!apellidosPattern.test(apellidos)) {
                $(this).find("#apellidos-error1").show();
                $('#apellidos1').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#apellidos-error1").hide();
            }

            const correoPattern = /^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!correoPattern.test(correo)) {
                $(this).find("#correo-error1").show();
                $('#correo1').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#correo-error1").hide();
            }

            const passwordPattern = /^[A-Za-z\d@$!%*#?&_-]{6,}$/;
            if (!passwordPattern.test(contraseña)) {
                $(this).find("#passwd-error1").show(); 
                $('#passwd1').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#passwd-error1").hide();
            }

            const dniPattern = /^[0-9]{8}[A-Z]$/;
            if (!dniPattern.test(dni)) {
                $(this).find("#dni-error1").show();
                $('#dni1').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#dni-error1").hide();
            }

            const domicilioPattern = /^[a-zA-Z0-9º\s]{1,50}$/;
            if (!domicilioPattern.test(domicilio)) {
                $(this).find("#domicilio-error1").show();
                $('#domicilio1').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#domicilio-error1").hide();
            }

            if (error == 0) {
                $.ajax({
                    url: '/Proyecto/userController',
                    type: 'POST',
                    data: {
                        nombre : nombre,
                        apellidos : apellidos,
                        correo : correo,
                        nombre : nombre,
                        password : contraseña,
                        dni : dni,
                        sexo : sexo,
                        domicilio : domicilio,
                        nacimiento : fnac,
                        admin : admin,
                        insertar : 1
                    },
                    success: function(response) {
                        if(response){
                            window.location.href = "/Proyecto/";
                            alert("Te has registrado correctamente");
                        }else{
                            $("#error-message1").html(response);
                            $("#error-message1").show();
                        }
                    },
                    error: function() {
                        $("#error-message1").html('Ocurrió un error al procesar la solicitud.');
                        $("#error-message1").show();
                    }
                });
            }else{
                $("#error-message1").html(error);
                $("#error-message1").show();
            }
        });
        $("#searchForm").submit(function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente

            const lugar = $("#lugar").val();
            const npersonas = $("#npersonas4").val();
            const entrada = $("#entrada").val();
            const salida = $("#salida").val();
            let hoy = new Date();
            hoy = hoy.toISOString().split('T')[0];

            let error = 0;
            
            const fechaInicio = new Date(entrada);
            const fechaFin = new Date(salida);
            if (entrada != "" && salida != "") {
                if (fechaInicio < hoy) {
                    $('#entrada').addClass('is-invalid');
                    $("#entrada-error").val('La fecha de entrada no puede ser menor a hoy.');
                    $("#entrada-error").show();
                    error = 1;
                }
                if (fechaInicio > fechaFin) {
                    $('#entrada').addClass('is-invalid');
                    $("#entrada-error").val('La fecha de entrada no puede ser posterior a la de salida.');
                    $("#entrada-error").show();
                    error = 1;
                }
            }else{
                $('#entrada').addClass('is-invalid');
                $('#salida').addClass('is-invalid');
                $("#entrada-error").show();
                $("#salida-error").show();
                error = 1;
            }

            if (lugar == '0') {
                $('#lugar').addClass('is-invalid');
                $("#lugar-error").show();
                error = 1;
            }

            if (npersonas == "") {
                $('#npersonas4').addClass('is-invalid');
                $("#lugar-error2").show();
                error = 1;
            }

            if(error == 1){
                return;
            }

            $.ajax({
                url: '/Proyecto/roomController',
                type: 'POST',
                data: {
                    lugar: lugar,
                    npersonas: npersonas,
                    entrada : entrada,
                    salida : salida,
                    search : 1
                },
                success: function(response) {
                    window.location.href = "/Proyecto/habitaciones";
                },
                error: function() {
                    console.log(response);
                }
            });
        });
    </script>
</body>
</html>