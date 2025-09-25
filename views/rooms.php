<?php
    require_once('controllers/room_controller.php');
    require_once('controllers/hotel_controller.php');
    require_once("controllers/comentario_controller.php");
    if(isset($_SESSION['habitaciones'])){
        $habitaciones = $_SESSION['habitaciones'];
        unset($_SESSION['habitaciones']);
    }else{
        $habitaciones = selectAllRoomsFecha();
    }
    $hoteles = selectAllHotelsRooms();
    if(empty($hoteles)){
        $hoteles = [];
    }
    if(isset($_GET['entrada']) && isset($_GET['salida']) && isset($_GET['lugar']) && !empty($_GET['lugar']) && isset($_GET['npersonas'])){
        if(empty($_GET['entrada'])) {
            $_GET['entrada'] = date('Y-m-d');
        }
        if(empty($_GET['salida'])) {
            $_GET['salida'] = date('Y-m-d', strtotime('+1 day'));
        }
        buscar($_GET['lugar'], $_GET['npersonas'], $_GET['entrada'], $_GET['salida']);
        foreach ($hoteles as &$hotel) {
            if ($hotel['localidad'] === $_GET['lugarTexto']) {
                $hotel['color'] = 'red';
            }
        }
        $habitaciones = $_SESSION['habitaciones'];
        unset($_SESSION['habitaciones']);
    }
    $comentarios = selectAllComentarios();
    if (empty($comentarios)){
        $comentarios = [];
    }
    if (empty($habitaciones)){
        $habitaciones = [];
    }
    $jsonHoteles = json_encode($hoteles);

    $habitacionesPorPagina = $_GET['limit'] ?? 6;  // por ejemplo, 6 habitaciones por página
    $paginaActual = $_GET['page'] ?? 1;
    $habitacionesPorPagina = (int)$habitacionesPorPagina;
    $paginaActual = (int)$paginaActual;

    // Total habitaciones
    $totalHabitaciones = count($habitaciones);

    // Calcular páginas totales
    $totalPaginas = ceil($totalHabitaciones / $habitacionesPorPagina);

    // Calcular offset para slice
    $offset = ($paginaActual - 1) * $habitacionesPorPagina;

    // Obtener solo las habitaciones para la página actual
    $habitacionesPagina = array_slice($habitaciones, $offset, $habitacionesPorPagina);

    $entrada = urlencode($_GET['entrada'] ?? '');
    $salida = urlencode($_GET['salida'] ?? '');
    $lugar = urlencode($_GET['lugar'] ?? '');
    $npersonas = urlencode($_GET['npersonas'] ?? '');
    $lugarTexto = urlencode($_GET['lugarTexto'] ?? '');
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
    <link href="admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        @media (max-width: 768px) {
            td {
                display: block;
                width: 100% !important;
            }
            tr {
                display: block;
            }
        }
    </style>

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
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Habitaciones</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="/Proyecto/">Inicio</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Habitaciones</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header End -->


        <!-- Booking Start -->
        <?php include("layout/buscarHabitacion.php"); ?>
        <!-- Booking End -->
<input type="hidden" id="fechaEntrada" name="fechaEntrada" value="<?= isset($_GET['entrada']) ? $_GET['entrada'] : '' ?>">
                                                    <input type="hidden" id="fechaSalida" name="fechaSalida"  value="<?= isset($_GET['salida']) ? $_GET['salida'] : '' ?>">
                                                    <input type="hidden" id="npersonas" name="npersonas" value="<?= isset($_GET['npersonas']) ? $_GET['npersonas'] : '' ?>">

        <!-- Room Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <?php $a = !isset($_GET['salida']) && !isset($_GET['entrada']) ? 'Disponibles Hoy' : ''; ?>
                    <h6 class="section-title text-center text-primary text-uppercase"><?= empty($habitaciones) ? '<h1 class="mb-5">No hay disponibilidad de habitaciones</h1>' : 'Habitaciones '. $a .' <a href="habitaciones/#seccion2" class="text-dark" style="font-size: 1.2em; text-decoration: none;">
  <i class="fas fa-arrow-down"></i>
</a> <h1 class="mb-5">Explora Nuestras <span class="text-primary text-uppercase">Habitaciones</span></h1>' ?></h6>
                    
                </div>
                <div class="row g-4 mb-4" id="seccion2">
                    <?php if(!empty($habitaciones)): ?>
                        <form method="get" style="margin-bottom: 0;" >
    <label for="limit">Mostrar</label>
    <select name="limit" id="limit" onchange="this.form.submit()">
        <?php foreach([3,6,9,12] as $num): ?>
            <option value="<?= $num ?>" <?= $num == $habitacionesPorPagina ? 'selected' : '' ?>><?= $num ?></option>
        <?php endforeach; ?>
    </select> habitaciones por página
    <input type="hidden" name="page" value="1">
    <input type="hidden" name="page" value="1">
    <input type="hidden" name="entrada" value="<?= $entrada ?>">
    <input type="hidden" name="salida" value="<?= $salida ?>">
    <input type="hidden" name="lugar" value="<?= $lugar ?>">
    <input type="hidden" name="npersonas" value="<?= $npersonas ?>">
    <input type="hidden" name="lugarTexto" value="<?= $lugarTexto ?>">
</form>
                        <table class="table table-borderless" style="margin-top: 0;">
    <thead>
        <tr>
            <th></th><th></th><th></th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $contador = 0; 
            foreach($habitacionesPagina as $habitacion): 
                if ($contador % 3 == 0) echo "<tr>"; // inicia fila cada 3
        ?>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="room-item shadow rounded overflow-hidden h-100">
                    <div class="position-relative">
                        <img class="img-fluid" src="images/<?= $habitacion['imagen'] ?>" alt="">
                        <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4"><?= $habitacion['PrecioUnitario'] ?>€/Noche</small>
                    </div>
                    <div class="p-4 mt-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="mb-0"><?= $habitacion['Nombre'] ?><?= empty($habitacion['Tipo']) ? "" : " - ". $habitacion['Tipo'] ?></h5>
                            <div class="ps-2">
                                <?php for($i = 0; $i < $habitacion['NEstrellas']; $i++): ?>
                                    <small class="fas fa-star text-primary"></small>
                                <?php endfor; ?>
                                <?php for($i = $habitacion['NEstrellas']; $i < 5; $i++): ?>
                                    <small class="far fa-star text-primary"></small>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <small class="border-end me-3 pe-3"><i class="fa fa-users text-primary me-2"></i><?= $habitacion['NPersonas'] ?></small>
                            <small class="border-end me-3 pe-3"><i class="fa fa-ruler-combined text-primary me-2"></i><?= $habitacion['m2'] ?>m²</small>
                            <small class="border-end me-3 pe-3"><i class="fa fa-bed text-primary me-2"></i><?= $habitacion['NumCamas'] ?></small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <?php $habitacion_serializada = serialize($habitacion); ?>
                            <form action="habitacion" method="post">
                                <input type="hidden" name="habitacion" value="<?= htmlspecialchars($habitacion_serializada) ?>">
                                <button type="submit" class="btn btn-personalizado2 py-2 px-4">Ver Detalles</button>
                            </form>
                            <?php if(isset($_SESSION['usuario'])): ?>
                                <form action="reserva" method="post">
                                    <input type="hidden" name="fechaEntrada" value="<?= $_GET['entrada'] ?? '' ?>">
                                    <input type="hidden" name="fechaSalida" value="<?= $_GET['salida'] ?? '' ?>">
                                    <input type="hidden" name="npersonas" value="<?= $_GET['npersonas'] ?? '' ?>">
                                    <input type="hidden" name="habitacion" value="<?= htmlspecialchars($habitacion_serializada) ?>">
                                    <input type="hidden" name="lugar" value="<?= $_GET['lugar'] ?? '' ?>">
                                    <button type="submit" class="btn btn-personalizado2">Reservar</button>
                                </form>
                            <?php else: ?>
                                <a data-bs-toggle="modal" data-bs-target="#InicioSesionModal" class="btn btn-personalizado2">Reservar</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                            </div>
        <?php 
            $contador++; 
            if ($contador % 3 == 0) echo "</tr>"; // cierra fila cada 3
            endforeach;

            // cierra fila si faltan columnas
            $resto = $contador % 3;
            if ($resto > 0) {
                for ($i = 0; $i < 3 - $resto; $i++) {
                    echo "<td></td>";
                }
                echo "</tr>";
            }
        ?>
    </tbody>
</table>

<!-- Navegación simple -->
<div class="pagination" style="display: flex; justify-content: flex-end; margin-top: 0.2rem; gap: 0.25rem;">
    <?php if($paginaActual > 1): ?>
        <a href="/Proyecto/habitaciones?page=<?= $paginaActual - 1 ?>&limit=<?= $habitacionesPorPagina ?>&entrada=<?= $entrada ?>&salida=<?= $salida ?>&lugar=<?= $lugar ?>&npersonas=<?= $npersonas ?>&lugarTexto=<?= $lugarTexto ?>" class="btn btn-personalizado2">&laquo; Anterior</a>

    <?php endif; ?>

    <?php for($p=1; $p <= $totalPaginas; $p++): ?>
        <a href="/Proyecto/habitaciones?page=<?= $p ?>&limit=<?= $habitacionesPorPagina ?>&entrada=<?= $entrada ?>&salida=<?= $salida ?>&lugar=<?= $lugar ?>&npersonas=<?= $npersonas ?>&lugarTexto=<?= $lugarTexto ?>" class="btn btn-personalizado2 <?= $p == $paginaActual ? 'active' : '' ?>"><?= $p ?></a>

    <?php endfor; ?>

    <?php if($paginaActual < $totalPaginas): ?>
        <a href="/Proyecto/habitaciones?page=<?= $paginaActual + 1 ?>&limit=<?= $habitacionesPorPagina ?>&entrada=<?= $entrada ?>&salida=<?= $salida ?>&lugar=<?= $lugar ?>&npersonas=<?= $npersonas ?>&lugarTexto=<?= $lugarTexto ?>" class="btn btn-personalizado2">Siguiente &laquo;</a>

    <?php endif; ?>
</div>
                <?php endif; ?>
            </div>
            <div class="row g-4">
                <h1 class="text-center">Búsqueda por Provincias</h1>
                <div id="mapa" style="height: 600px; width: 100%;"></div>
            </div>
        </div>
                                        </div>
        <!-- Room End -->

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

    <script src="js/highmaps.js"></script>
    <script src="https://code.highcharts.com/mapdata/countries/es/es-all.js"></script>
    <script src="admin/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
    $('#miTabla').DataTable({
        paging: true,
        searching: false,
        info: true,
        ordering: false,
        lengthMenu: [3, 6, 9],
        pageLength: 6,
        language: {
            paginate: {
                previous: "Anterior",
                next: "Siguiente"
            },
            lengthMenu: "Mostrar _MENU_ habitaciones"
        },
        drawCallback: function() {
            // Esto fuerza a que DataTables vuelva a aplicar el CSS flex después de paginar
            $('#miTabla tbody tr').css('display', 'flex');
        }
    });
});
    </script>


    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
        $(document).ready(function() {
            if (window.history.replaceState) {
                const urlSinParametros = window.location.protocol + "//" + window.location.host + window.location.pathname;
                window.history.replaceState({}, document.title, urlSinParametros);
            }
            const hoteles = <?php echo $jsonHoteles; ?>;
            Highcharts.mapChart('mapa', {
            chart: {
                map: 'countries/es/es-all',
                backgroundColor: '#DAA880'
            },
            
            title: {
                text: ''
            },
            legend: {
                enabled: false
            },
            
            plotOptions: {
                map: {
                    nullColor: '#eeeeee'
                },
                
            },
            
            tooltip: {
                useHTML: true,
                formatter: function () {
                    return `
                        <span style="color: black; font-weight: bold;">${this.point.localidad}</span><br>
                    `;
                }
            },
            series: [{
                name: 'España',
                data: Object.values(hoteles),
                joinBy: ['name', 'localidad'],
                keys: ['habitaciones','id','localidad','idLocalidad','nombre','habitaciones','color'],
                colorKey: 'color',
                events: {
                    click: function (e) {
                        const lugarTexto = e.point.localidad;
                        const fechaEntrada = $('#fechaEntrada').val();
                        const fechaSalida = $('#fechaSalida').val();
                        const npersonas = $('#npersonas').val();
                        const lugar = e.point.idLocalidad;
                        window.location.href = `/Proyecto/habitaciones?entrada=${fechaEntrada}&salida=${fechaSalida}&lugar=${lugar}&npersonas=${npersonas}&lugarTexto=${lugarTexto}`;
                    }
                }
            }],
        });
        });
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
            let admin = $(this).find("#admin1").is(":checked");

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
            const lugarTexto = $("#lugarTexto").val();
            let hoy = new Date();
            hoy.setHours(0, 0, 0, 0);

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
            fechaInicio.setHours(0, 0, 0, 0);
            fechaFin.setHours(0, 0, 0, 0);
            if (entrada != "" && salida != "") {
                if (fechaInicio < hoy) {
                    $('#entrada').addClass('is-invalid');
                    $("#entrada-error").text('La fecha de entrada no puede ser menor a hoy.');
                    $("#entrada-error").show();
                    error = 1;
                }else {
                    $('#entrada').removeClass('is-invalid');
                    $("#entrada-error").hide();
                    if (fechaInicio > fechaFin) {
                        $('#entrada').addClass('is-invalid');
                        $("#entrada-error").text('La fecha de entrada no puede ser posterior a la de salida.');
                        $("#entrada-error").show();
                        error = 1;
                    }else {
                        $('#entrada').removeClass('is-invalid');
                        $("#entrada-error").hide();
                    }
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
    </script>
</body>

</html>