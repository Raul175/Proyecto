<?php
    require_once("controllers/comentario_controller.php");
    $comentarios = selectAllComentarios();
    if(empty($comentarios)){
        $comentarios = [];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Hotelier - Hotel HTML Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
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


        <!-- Page Header Start -->
        <div class="container-fluid page-header mb-5 p-0" style="background-image: url(img/carousel-1.jpg);">
            <div class="container-fluid page-header-inner py-5">
                <div class="container text-center pb-5">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Contacto</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="/Proyecto/">Inicio</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Contacto</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header End -->


        <!-- Contact Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Contactanos</h6>
                    <h1 class="mb-5"><span class="text-primary text-uppercase">Contacto</span> Para cualquier consulta</h1>
                </div>
                <div class="row g-4">
                    <div class="col-12">
                        <div class="row gy-4">
                            <div class="col-md-4">
                                <h6 class="section-title text-start text-primary text-uppercase">Reserva</h6>
                                <p><i class="fa fa-envelope-open text-primary me-2"></i>book-rolva@rolvahotels.com</p>
                            </div>
                            <div class="col-md-4">
                                <h6 class="section-title text-start text-primary text-uppercase">General</h6>
                                <p><i class="fa fa-envelope-open text-primary me-2"></i>rolva@rolvahotels.com</p>
                            </div>
                            <div class="col-md-4">
                                <h6 class="section-title text-start text-primary text-uppercase">Técnico</h6>
                                <p><i class="fa fa-envelope-open text-primary me-2"></i>tech-rolva@rolvahotels.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 wow fadeIn" data-wow-delay="0.1s">
                        <iframe class="position-relative rounded w-100 h-100"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12606.308998859592!2d-6.9478139!3d37.2614216!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd10c59db8cd6193%3A0x402f39180c3ac50!2sHuelva%2C%20España!5e0!3m2!1ses!2ses!4v1713704860000!5m2!1ses!2ses"
                            frameborder="0" style="min-height: 350px; border:0;" allowfullscreen="" aria-hidden="false"
                            tabindex="0"></iframe>
                    </div>
                    <div class="col-md-6">
                        <div class="wow fadeInUp" data-wow-delay="0.2s">
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="name" placeholder="Your Name">
                                            <label for="name">Tú Nombre</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="email" placeholder="Your Email">
                                            <label for="email">Tú Email</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="subject" placeholder="Subject">
                                            <label for="subject">Asunto</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Leave a message here" id="message" style="height: 150px"></textarea>
                                            <label for="message">Mensaje</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-personalizado2 w-100 py-3" type="submit">Enviar Mensaje</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->


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
                                                        <h4><strong>Habitacion:</strong> <?= htmlspecialchars($comentario['habitacion']) ?></h4>
                                                        <small>Usuario: <?= htmlspecialchars($comentario['Nombre']) ?></small><br>
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


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
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
                            alert("Te has registrado");
                            window.location.href = "/Proyecto/";
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
            
            if (entrada == "") {
                $('#entrada').addClass('is-invalid');
                $("#entrada-error").show();
                error = 1;
            } else {    
                $('#entrada').removeClass('is-invalid');
                $("#entrada-error").hide();
            }
            if (salida == "") {
                $('#salida').addClass('is-invalid');
                $("#salida-error").show();
                error = 1;
            } else {
                $('#salida').removeClass('is-invalid');
                $("#salida-error").hide();
            }            
            const fechaInicio = new Date(entrada);
            const fechaFin = new Date(salida);
            if (entrada != "" && salida != "") {
                if (fechaInicio < hoy) {
                    $('#entrada').addClass('is-invalid');
                    $("#entrada-error").val('La fecha de entrada no puede ser menor a hoy.');
                    $("#entrada-error").show();
                    error = 1;
                }else {
                    $('#entrada').removeClass('is-invalid');
                    $("#entrada-error").hide();
                }
                if (fechaInicio > fechaFin) {
                    $('#entrada').addClass('is-invalid');
                    $("#entrada-error").val('La fecha de entrada no puede ser posterior a la de salida.');
                    $("#entrada-error").show();
                    error = 1;
                }else {
                    $('#entrada').removeClass('is-invalid');
                    $("#entrada-error").hide();
                }
            }else{
                $('#entrada').addClass('is-invalid');
                $('#salida').addClass('is-invalid');
                $("#entrada-error").show();
                $("#salida-error").show();
                error = 1;
            }

            if (lugar == '0' || lugar == null) {
                $('#lugar').addClass('is-invalid');
                $("#lugar-error").show();
                error = 1;
            }else{
                $('#lugar').removeClass('is-invalid');
                $("#lugar-error").hide();
            }

            if (npersonas == "") {
                $('#npersonas4').addClass('is-invalid');
                $("#lugar-error2").show();
                error = 1;
            }else{
                $('#npersonas4').removeClass('is-invalid');
                $("#lugar-error2").hide();
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
                    window.location.href = "/Proyecto/habitaciones?entrada="+entrada+"&salida="+salida+"&lugar="+lugar+"&npersonas="+npersonas+"&lugarTexto="+lugarTexto;
                },
                error: function() {
                    console.log(response);
                }
            });
        });
        $("#registerGForm").submit(function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente

            let error = 0;

            const nombre = $(this).find("#nombreG").val().trim();
            const apellidos = $(this).find("#apellidosG").val().trim();
            const correo = $(this).find("#correoG").val().trim();
            const contraseña = $(this).find("#passwdG").val().trim();
            const dni = $(this).find("#dniG").val().trim();
            const sexo = $(this).find("#sexoG").val().trim();
            let admin = 2;
            const fnac = $(this).find("#nacimientoG").val().trim();

            const nacimiento = new Date(fnac);
            const hoy = new Date();
            let edad = hoy.getFullYear() - nacimiento.getFullYear();
            const cumpleEsteAno = hoy.getMonth() > nacimiento.getMonth() || (hoy.getMonth() === nacimiento.getMonth() && hoy.getDate() >= nacimiento.getDate());
            if (!cumpleEsteAno) edad--;
            const esMenor = edad < 18;

            if (fnac != "") {
                if (esMenor) {
                    $(this).find("#nacimiento-errorG").text("No puedes crear una cuenta para un menor de edad")
                    $(this).find("#nacimiento-errorG").show();
                    $('#nacimiento1').addClass('is-invalid');
                    error = 1;
                }else{
                    $(this).find("#nacimiento-errorG").hide();
                }
            }else{
                $(this).find("#nacimiento-errorG").show();
                $('#nacimientoG').addClass('is-invalid');
                error = 1;
            }

            const nombrePattern = /^[a-zA-Z0-9\s]{1,100}$/;
            if (!nombrePattern.test(nombre)) {
                $(this).find("#nombre-errorG").show();
                $('#nombreG').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#nombre-errorG").hide();
            }

            const apellidosPattern = /^[A-Za-z\s]{1,100}$/;
            if (!apellidosPattern.test(apellidos)) {
                $(this).find("#apellidos-errorG").show();
                $('#apellidosG').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#apellidos-errorG").hide();
            }

            const correoPattern = /^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!correoPattern.test(correo)) {
                $(this).find("#correo-errorG").show();
                $('#correoG').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#correo-errorG").hide();
            }

            const passwordPattern = /^[A-Za-z\d@$!%*#?&_-]{6,}$/;
            if (!passwordPattern.test(contraseña)) {
                $(this).find("#passwd-errorG").show(); 
                $('#passwdG').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#passwd-errorG").hide();
            }

            const dniPattern = /^[0-9]{8}[A-Z]$/;
            if (!dniPattern.test(dni)) {
                $(this).find("#dni-errorG").show();
                $('#dniG').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#dni-errorG").hide();
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
                        nacimiento : fnac,
                        admin : admin,
                        insertar : 1
                    },
                    success: function(response) {
                        if(response){
                            alert("Te has registrado");
                            window.location.href = "/Proyecto/";
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
    </script>
</body>

</html>