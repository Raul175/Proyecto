<?php 
    $habitacion = unserialize($_POST['habitacion']);
    if (empty($habitacion)){
        $habitacion = [];
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
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Reserva</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="/Proyecto/">Home</a></li>
                            <li class="breadcrumb-item"><a href="/Proyecto/habitaciones">Habitaciones</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Reserva</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header End -->

        <!-- Booking Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Reservar Habitación</h6>
                    <h1 class="mb-5">Reservar Habitación <span class="text-primary text-uppercase"><?= $habitacion['Nombre'] ?></span></h1>
                </div>
                <div class="row g-5">
                    <div class="col-lg-6">
                        <div class="row g-3">
                            <div class="col-12 text-end">
                                <img class="img-fluid rounded w-90 wow zoomIn" data-wow-delay="0.1s" src="images/<?= $habitacion['imagen'] ?>" >
                                <h3 class="text-primary"></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="wow fadeInUp" data-wow-delay="0.2s">
                            <form id="reservaForm">
                                <div id="error-message5" class="alert alert-danger" style="display: none;"></div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <input type="hidden" id="comienzo" class="form-control" value="<?= date('Y-m-d\TH:i') ?>">
                                        <input type="hidden" id="idUser" value="<?= $_SESSION['id'] ?>">
                                        <input type="hidden" id="idHab" value="<?= $habitacion['IdHabitacion'] ?>">
                                        <input type="hidden" id="tipo" value="<?= $habitacion['Tipo'] ?>">
                                        <input type="hidden" id="monto" value="<?= $habitacion['PrecioUnitario'] ?>">
                                        <input type="hidden" id="precioReal" value="<?= $habitacion['PrecioUnitario'] ?>">
                                        <input type="hidden" id="idFactura">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="nombre2"  value="<?= $_SESSION['usuario'] ?>" placeholder="Tú Nombre">
                                            <label for="name">Nombre</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="apareceya" value="<?= $_SESSION['correo'] ?>" placeholder="Tú correo">
                                            <label for="email">Correo</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating date" id="date3" data-target-input="nearest">
                                            <input type="date" value="<?= isset($_POST['fechaEntrada']) ? $_POST['fechaEntrada'] : '' ?>" class="form-control" id="inicio" placeholder="Fecha Inicio"  />
                                            <label for="Fecha Inicio">Fecha Inicio</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating date" id="date4" data-target-input="nearest">
                                            <input type="date" value="<?= isset($_POST['fechaSalida']) ? $_POST['fechaSalida'] : '' ?>" class="form-control" id="fin" placeholder="Fecha Fin" />
                                            <label for="Fecha Fin">Fecha Fin</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating" data-target-input="nearest">
                                            <input type="text" class="form-control" id="codigo" placeholder="Cº Promocional"/>
                                            <label for="Fecha Fin">Código Promocional <font id="descuento" style="color: red;"></font></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="personas">
                                                <?php for ($i=1;$i<=$habitacion['NPersonas'];$i++): ?>
                                                    <?php
                                                        if (isset($_POST['npersonas']) && $_POST['npersonas'] == $i) {
                                                            echo '<option selected value="'.$i.'">'.$i.'</option>';
                                                        } else {
                                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                                        }
                                                    ?>
                                                <?php endfor; ?>
                                            </select>
                                            <label for="select1">Selecciona NºPersonas</label>
                                        </div>
                                    </div>
                                    <?php if ($habitacion['Tipo'] == "vip"): ?>
                                        <input type="hidden" value="null" class="form-control" id="complemento">
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="vip" placeholder="Código VIP">
                                                <label for="vip">Código VIP <font id="codvip" style="color: red;"></font></label>
                                            </div>
                                        </div>
                                    <?php elseif ($habitacion['Tipo'] == "suite" && $habitacion['suite'] != false): ?>
                                        <input type="hidden" value="null" class="form-control" id="vip">
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <select class="form-select" id="complemento">
                                                    <option selected value="0">Selecciona una Opcion</option>
                                                    <?php for ($i=0;$i<count($habitacion['suite']);$i++): ?>
                                                        <option value="<?= $habitacion['suite'][$i]['IdComplemento'] ?>"><?= $habitacion['suite'][$i]['Nombre'] ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                                <label for="select2">Selecciona un Complemento</label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="col-12">
                                        <button class="btn btn-personalizado2 w-100 py-3" type="submit">Reservar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->

        <div class="modal fade" id="confirmarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmar Reserva</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Seleccionar "Confirmar" para terminar de confirmar la reserva. <p>Tienes hasta 1 hora para confirmar.</p></div>
                    <div class="modal-footer">
                        <a class="btn btn-secondary" href="/Proyecto/">Más Tarde</a>
                        <form id="confirmarForm">
                            <button class="btn btn-primary" type="submit">Confirmar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="pagoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmar Reserva</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Seleccionar "Confirmar" para terminar de confirmar la reserva. <p>Tienes hasta 12 horas para pagar.</p></div>
                    <div class="modal-footer">
                        <a class="btn btn-secondary" href="/Proyecto/">Más Tarde</a>
                        <div id="paypal-button-container"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="paypalLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Iniciar sesión en PayPal</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="paypal-login-button-container"></div>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Footer Start -->
        <div style="max-height: 600px; overflow: hidden;">
            <?php include("layout/pie.php"); ?>
        </div>
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
    <script src="https://www.paypal.com/sdk/js?client-id=AfMDco8ClulVQKaAyjfOJpXrSbNS1H_1nqgJ-dOM9dM9dz2HcxDN0WbHDfMHDCJirPZjpkIJZiQRCWgJ&currency=EUR"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
        $("h3").html("Precio: " + $("#monto").val() + "€");
        $('#vip').on('change', function () {
            const habitacion = $("#idHab").val();
            const vip = $(this).val();

            $.ajax({
                url: '/Proyecto/roomController',
                method: 'POST',
                data: { 
                    habitacion: habitacion,
                    vip : vip,
                    CompVIP : 1
                },
                success: function (response) {
                    if(response != false){
                        $("#codvip").html("Aplicado!");
                    }else{
                        $("#codvip").html("No Existe");
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error AJAX:', error);
                }
            });
        });
        $('#codigo').on('change', function () {
            const codigo = $(this).val();
            const habitacion = $("#idHab").val();
            const precio = $("#monto").val();

            $.ajax({
                url: '/Proyecto/codPromController',
                method: 'POST',
                data: { 
                    codigo: codigo,
                    habitacion: habitacion,
                    precio : precio
                },
                success: function (response) {
                    if(!isNaN(response) && !isNaN(parseFloat(response))){
                        $("#monto").val(parseFloat(response).toFixed(2));
                        $("#descuento").html("Correcto!");
                    }else{
                        $("#monto").val($("#precioReal").val());
                        $("#descuento").html("Incorrecto");
                    }
                    $("h3").html("Precio: " + $("#monto").val() + "€");
                },
                error: function (xhr, status, error) {
                    console.error('Error AJAX:', error);
                }
            });
        });
        function mostrarModalPago(monto){
            $('#pagoModal').modal('show');
            const usuario = $("#idUser").val();
            const habitacion = $("#idHab").val();
            const factura = $("#idFactura").val();
            $('#pagoModal').off('shown.bs.modal').on('shown.bs.modal', function () {
                    $('#paypal-button-container').empty(); // Limpia si ya estaba renderizado antes
                    paypal.Buttons({
                        style: {
                            layout: 'vertical',
                            shape: 'rect',
                            color: 'gold',
                            tagline: false
                        },
                        createOrder: function(data, actions) {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        value: monto
                                    }
                                }]
                            });
                        },
                        onApprove: function(data, actions) {
                            return actions.order.capture().then(function(details) {
                                const email = details.payer.email_address;
                                const nombre = details.payer.name.given_name + ' ' + details.payer.name.surname;
                                $.ajax({
                                    url: '/Proyecto/reservaController',
                                    type: 'POST',
                                    data: {
                                        usuario : usuario,
                                        habitacion : habitacion,
                                        factura : factura,
                                        monto : monto,
                                        email : email,
                                        nombre : nombre,
                                        finicio : $("#inicio").val(),
                                        ffin : $("#fin").val(),
                                        pagar : 1
                                    },
                                    success: function(response) {
                                        if (response) {
                                            window.location.href = "/Proyecto/";
                                        }else {
                                            alert(response);
                                        }
                                    },
                                    error: function() {
                                        alert('Ocurrió un error al procesar la solicitud.');
                                    }
                                });
                            });
                            
                        },
                        onError: function(err) {
                            console.log(err);
                            alert('Hubo un error con PayPal: ' + err.message);
                        },
                        fundingSource: paypal.FUNDING.PAYPAL
                    }).render('#paypal-button-container');
            });
        }
        $("#confirmarForm").submit(function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente

            const comienzo = $("#comienzo").val();
            const usuario = $("#idUser").val();
            const habitacion = $("#idHab").val();
            const factura = $("#idFactura").val();

            let error = "";

            if (error == "") {
                $.ajax({
                    url: '/Proyecto/reservaController',
                    type: 'POST',
                    data: {
                        comienzo : comienzo,
                        usuario : usuario,
                        habitacion : habitacion,
                        factura : factura,
                        confirmar : 1
                    },
                    success: function(response) {
                        if (response == 1) {
                            $('#confirmarModal').modal('hide');
                            mostrarModalPago($("#monto").val());
                        }else {
                            $("#error-message5").html(response);
                            $("#error-message5").show();
                        }
                    },
                    error: function() {
                        $("#error-message5").html('Ocurrió un error al procesar la solicitud.');
                        $("#error-message5").show();
                    }
                });
            }else{
                $("#error-message5").html(error);
                $("#error-message5").show();
            }
        });
        
        
        $("#reservaForm").submit(function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente

            const comienzo = $("#comienzo").val();
            const inicio = $("#inicio").val();
            const fin = $("#fin").val();
            const usuario = $("#idUser").val();
            const habitacion = $("#idHab").val();
            const codigo = $("#codigo").val();
            const npersonas = $("#personas").val();
            const monto = $("#monto").val();
            const nombre = $("#nombre2").val();
            const correo = $("#apareceya").val();
            const tipo = $("#tipo").val();
            let vip = $("#vip").val();
            let complemento = $("#complemento").val();

            let error = "";

            const nombrePattern = /^[a-zA-Z0-9\s]{1,100}$/;
            if (!nombrePattern.test(nombre)) {
                error = "El nombre es inválido o demasiado largo (máx. 100 caracteres)";
            }

            const correoPattern = /^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!correoPattern.test(correo)) {
                error = 'El correo está mal introducido';
            }

            if (!$("#vip").length) {
                vip = "";
            }
            if (!$("#complemento").length) {
                complemento = "";
            }else if (complemento == 0){
                error = "Selecciona un complemento";
            }          

            const vipPattern = /^[a-zA-Z0-9\s]{1,50}$/;
            if (!vipPattern.test(vip) && vip != "") {
                error = "El codigo de vip es inválido o demasiado largo";
            }

            const fechaInicio = new Date(inicio);
            const fechaFin = new Date(fin);
            let hoy = new Date();
            hoy.setHours(0, 0, 0, 0);
            const fechacomienzo = new Date(comienzo);
            fechacomienzo.setHours(0, 0, 0, 0);
            fechaInicio.setHours(0, 0, 0, 0);
            fechaFin.setHours(0, 0, 0, 0);
            if (inicio != "" && fin != "") {
                if (fechaInicio < hoy) {
                    error = 'La fecha de inicio no puede ser menor o igual a hoy.';
                }
                if (fechaInicio > fechaFin) {
                    error = 'La fecha de inicio no puede ser posterior a la de fin.';
                }
            }else{
                error = "Introduce las fechas";
            }

            if (error == "") {
                $.ajax({
                    url: '/Proyecto/reservaController',
                    type: 'POST',
                    data: {
                        comienzo : comienzo,
                        finicio : inicio,
                        fin : fin,
                        usuario : usuario,
                        habitacion : habitacion,
                        codigo : codigo,
                        npersonas : npersonas,
                        vip : vip,
                        tipo : tipo,
                        complemento : complemento,
                        monto : monto,
                        nombre : nombre,
                        correo : correo,
                        inicio : 1
                    },
                    success: function(response) {
                        if (response.split("-")[0] == 1) {
                            $("#idFactura").val(response.split("-")[1]);
                            $("#comienzo").val(new Date().toISOString().slice(0, 16));
                            $('#confirmarModal').modal('show');
                        }else {
                            $("#error-message5").html(response);
                            $("#error-message5").show();
                        }
                    },
                    error: function() {
                        $("#error-message5").html('Ocurrió un error al procesar la solicitud.');
                        $("#error-message5").show();
                    }
                });
            }else{
                $("#error-message5").html(error);
                $("#error-message5").show();
            }
        });
        $("#loginForm").submit(function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente

            const correo = $("#correo").val();
            const password = $("#password").val();

            let error = "";

            const correoPattern = /^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!correoPattern.test(correo)) {
                error = 'El correo está mal introducido';
            }

            //const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
            //if (!passwordPattern.test(password)) {
            //    error = 'La contraseña está mal introducida';
            //}

            if (error == "") {
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

            const nombre = $("#nombre").val();
            const correo = $("#correo1").val();
            const password = $("#password1").val();

            let error = "";

            const nombrePattern = /^[a-zA-Z0-9\s]{1,100}$/;
            if (!nombrePattern.test(nombre)) {
                error = "El nombre es inválido o demasiado largo (máx. 100 caracteres)";
            }

            const correoPattern = /^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!correoPattern.test(correo)) {
                error = 'El correo está mal introducido';
            }

            //const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
            //if (!passwordPattern.test(password)) {
            //    error = 'La contraseña está mal introducida';
            //}

            if (error == "") {
                $.ajax({
                    url: '/Proyecto/userController',
                    type: 'POST',
                    data: {
                        correo: correo,
                        password: password,
                        nombre : nombre,
                        insertar : 1
                    },
                    success: function(response) {
                        if(response == true){
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

            let error = "";
            

            if (lugar == '0') {
                $('#lugar').addClass('is-invalid');
                $("#lugar-error").show();
            }

            if (npersonas == "") {
                $('#npersonas4').addClass('is-invalid');
                $("#lugar-error2").show();
                return;
            }


            $.ajax({
                url: '/Proyecto/roomController',
                type: 'POST',
                data: {
                    lugar: lugar,
                    npersonas: npersonas,
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