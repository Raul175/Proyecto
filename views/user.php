<?php
    require_once("controllers/users_controller.php");
    require_once("controllers/reserva_controller.php");
    require_once("controllers/comentario_controller.php");
    $usuario = selectUserId($_SESSION['id']);
    $reservas = selectReservasUserId($_SESSION['id']);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>RolvaHotels</title>
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

        <!-- Information Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-12">
                        <h2>MODIFICA TUS DATOS</h2>
                        <form id="updateForm">
                            <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                            <input type="hidden" class="form-control" value="<?= $usuario['IdUsuario'] ?>" name="id1" id="id1">

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" value="<?= $usuario['Nombre'] ?>" name="nombre" id="nombre">
                                    <div class="invalid-feedback" style="display: none;" id="nombre-error">
                                        El nombre es inválido o demasiado largo (máx. 100 caracteres).
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nombre">Apellido</label>
                                    <input type="text" class="form-control" value="<?= $usuario['Apellidos'] ?>" name="apellidos" id="apellidos">
                                    <div class="invalid-feedback" style="display: none;" id="apellidos-error">
                                        Los apellidos son inválidos o demasiado largos (máx. 100 caracteres).
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="correo">Correo</label>
                                    <input type="text" class="form-control" value="<?= $usuario['Correo'] ?>" name="correo" id="correo">
                                    <div class="invalid-feedback" style="display: none;" id="correo-error">
                                        El correo está mal introducido (ejemplo@gmail.com).
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="passwd">Contraseña</label>
                                    <input type="password" class="form-control" value="" name="passwd" id="passwd">
                                    <div class="invalid-feedback" style="display: none;" id="passwd-error">
                                        La contraseña esta mal introducida.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="correo">DNI</label>
                                    <input type="text" class="form-control" value="<?= $usuario['DNI'] ?>" name="dni" id="dni">
                                    <div class="invalid-feedback" style="display: none;" id="dni-error">
                                        El DNI está mal introducido (99999999J).
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="domicilio">Domicilio</label>
                                    <input type="text" class="form-control" value="<?= $usuario['Domicilio'] ?>" name="domicilio" id="domicilio">
                                    <div class="invalid-feedback" style="display: none;" id="domicilio-error">
                                        El domicilio esta mal introducida.
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="form-group col-md-6">
                                    <label for="correo">Sexo</label>
                                    <select class="form-control" id="sexo" name="sexo">
                                        <?php 
                                            if ($usuario['Sexo'] == "hombre"){
                                                echo '
                                                    <option value="hombre" selected>Hombre</option>
                                                    <option value="mujer">Mujer</option>
                                                    <option value="otro">Otro</option>
                                                ';
                                            }elseif ($usuario['Sexo'] == "mujer"){
                                                echo '
                                                    <option value="hombre">Hombre</option>
                                                    <option value="mujer" selected>Mujer</option>
                                                    <option value="otro">Otro</option>
                                                ';
                                            }else{
                                                echo '
                                                    <option value="hombre">Hombre</option>
                                                    <option value="mujer">Mujer</option>
                                                    <option value="otro" selected>Otro</option>
                                                ';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="domicilio">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" name="nacimiento" value="<?= $usuario['FNacimiento'] ?>" id="nacimiento">
                                    <div class="invalid-feedback" style="display: none;" id="nacimiento-error">
                                        Eres menor de edad.
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="form-group col-lg-3 col-md-5">
                                    <button type="submit" class="btn btn-personalizado2 w-100">Modificar Datos</button>
                                </div>
                                <div class="form-group col-lg-3 col-md-5">
                                    <button id="baja" type="button" class="btn btn-personalizado2 w-100">Dar baja</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <hr class="my-5 border-top border-2 border-secondary">
                <div class="row g-5">
                    <div class="col-lg-12">
                        <h2>HISTORIAL DE RESERVAS</h2>
                        <table class="table table-bordered" id="miTabla" width="100%" cellspacing="0">
                            <thead class="bg-dark">
                                <tr>
                                    <th class="col-4">Fecha Entrada</th>
                                    <th class="col-4">Fecha Salida</th>
                                    <th class="col-3">Estado</th>
                                    <th class="col-1">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if (!$reservas) {
                                        echo "<tr><td colspan='4' class='text-center'>No tienes reservas</td></tr>";
                                    }else {
                                        foreach ($reservas as $reserva) {
                                            $hoy = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
                                            $id = $reserva['IdReserva'];
                                            $idHab = $reserva['IdHabitacion'];
                                            $idUser = $_SESSION['id'];
                                            $comentario = empty(selectComentario($idHab, $_SESSION['id'])) ? "" : selectComentario($idHab, $_SESSION['id']);
                                            $idComentario = $comentario['Comentario'] ?? null;
                                            $Comentario = $comentario['IdComentario'] ?? null;
                                            $estrellas = $comentario['NEstrellas'] ?? 0;
                                            $incidente = $reserva['Incidencia'];
                                            $comienzo = date('Y-m-d\TH:i');
                                            $botonConfirmar = $reserva['Estado'] == "Por Confirmar" ? "<a href='#' id='confirmar' data-comienzo='$comienzo' data-idreserva='$id'><i class='fas fa-check text-success'></i></a>" : "";
                                            $botonPagar = $reserva['Estado'] == "Por Pagar" ? "<a href='#' id='pagar' data-idreserva='$id'><i class='fas fa-money-bill text-success'></i></a>" : "";
                                            echo "<tr>";
                                                echo "<td id='finicio-$id' class='fw-bold'>" . (new DateTime($reserva['FInicio']))->format('d/m/Y') . "</td>";
                                                echo "<td id='ffin-$id' class='fw-bold'>" . (new DateTime($reserva['FFin']))->format('d/m/Y') . "</td>";
                                                echo "<td class='fw-bold'>" . $reserva['Estado'] . "</td>";
                                                echo "<span id='monto-$id' class='fw-bold d-none'>" . $reserva['Precio'] . "</span>"; //Está oculto
                                                if ($reserva['Estado'] == "Cancelado" || $reserva['Estado'] == "Pagado") {
                                                    if (new DateTime($reserva['FInicio']) <= $hoy && new DateTime($reserva['FFin']) >= $hoy){
                                                        echo "<td class='text-center'><a href='#' id='incidente' data-idreserva='$id' data-incidente='$incidente'><i class='fas fa-solid fa-clipboard-list text-secondary'></i></a></td>";
                                                    }else{
                                                        echo "<td class='text-center'><i class='fas fa-lock text-secondary' title='cancelado'></i></td>";
                                                    }
                                                }elseif ($reserva['Estado'] != "Completado" && $reserva['Estado'] != "En Proceso") {
                                                    echo "<td class='text-center'>
                                                        <a href='#' id='cancelar' data-idreserva='$id'><i class='fas fa-times-circle text-danger'></i></a>
                                                        $botonConfirmar
                                                        $botonPagar
                                                    </td>";
                                                }else {
                                                    echo "<td class='text-center'><a href='#' id='comentar' data-iduser='$idUser' data-estrellas='$estrellas' data-comentario='$idComentario' data-idhab='$idHab'><i class='fas fa-comment-dots text-secondary' title='No se puede cancelar'></i></a></td>";
                                                }
                                            echo "</tr>";
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Information End -->
         
        <!--  Modal -->
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
                    <div class="modal-body">Seleccionar "Confirmar" para terminar de confirmar la reserva. <p>Tienes hasta 1 día para pagar.</p></div>
                    <div class="modal-footer">
                        <a class="btn btn-secondary" href="/Proyecto/">Más Tarde</a>
                        <div id="paypal-button-container"></div>
                    </div>
                </div>
            </div>
        </div>

        <!--  Modal -->
         <div class="modal fade" id="comentarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Escribe tu comentario</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="comentForm">
                        <div class="modal-body" style="background-color: #daa880 !important;">
                            <div id="error-message1" class="alert alert-danger" style="display: none;"></div>
                            <div class="form-group">
                                <label for="tipo">Comentario:</label>
                                <input type="hidden" class="form-control" value="<?= date('Y-m-d') ?>" id="fecha">
                                <input type="hidden" class="form-control" name="usuario" id="usuario">
                                <input type="hidden" name="puntuacion" id="puntuacion">
                                <input type="hidden" class="form-control" name="habitacion" id="habitacion">
                                <textarea class="form-control" id="comentario" name="comentario" rows="4" placeholder="Escribe tu comentario aquí..."></textarea>
                                <div class="invalid-feedback" style="display: none;" id="comentario-error">
                                    Escribe un comentario.
                                </div>
                                <div class="ps-2" id="estrellas"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-personalizado2" onclick="$('#comentForm')[0].reset(); $('[id$=\'-error\']').hide();$('.fa-star').removeClass('fas').addClass('far'); $('#puntuacion').val('');" type="button" data-dismiss="modal">Reiniciar</button>
                            <button type="submit" class="btn btn-personalizado2">Insertar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--  Modal -->
         <div class="modal fade" id="incidenciaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Escribe tu incidencia</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="incidenciaForm">
                        <div class="modal-body">
                            <div id="error-message1" class="alert alert-danger" style="display: none;"></div>
                            <div class="form-group">
                                <label for="tipo">Incidencia:</label>
                                <input type="hidden" class="form-control" name="reserva" id="reserva">
                                <textarea class="form-control" id="incidencia" name="incidencia" rows="4" placeholder="Escribe tu incidencia aquí..."></textarea>
                                <div class="invalid-feedback" style="display: none;" id="incidencia-error">
                                    Escribe una incidencia.
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-personalizado2" onclick="$('#incidenciaForm')[0].reset(); $('[id$=\'-error\']').hide();$('.fa-star').removeClass('fas').addClass('far');$('#incidencia').val('');" type="button" data-dismiss="modal">Reiniciar</button>
                            <button type="submit" class="btn btn-personalizado2">Insertar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Newsletter Start -->
        <div class="container newsletter mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="row justify-content-center">
                 <div class="col-lg-10 border rounded p-1 d-none">
                    
                </div>
            </div>
        </div>
        <!-- Newsletter Start -->

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
    <script src="admin/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="admin/vendor/datatables/myDataTable.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=AfMDco8ClulVQKaAyjfOJpXrSbNS1H_1nqgJ-dOM9dM9dz2HcxDN0WbHDfMHDCJirPZjpkIJZiQRCWgJ&currency=EUR"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
        $(document).on("click", "#incidente", function(event) {
            event.preventDefault();
            $("#reserva").val($(this).data('idreserva'));
            $("#incidencia").val($(this).data('incidente'));
            $('#incidenciaModal').modal('show');
        });
        $(document).on("click", "#baja", function(event) {
            event.preventDefault();
            const usuario = $('#id1').val();
            if (confirm("¿Estás seguro de que deseas darte de baja? Esta acción no se puede deshacer.")) {
                $.ajax({
                    url: '/Proyecto/userController',
                    type: 'POST',
                    data: {
                        id : usuario,
                        eliminar : 1
                    },
                    success: function(response) {
                        if (response == true) {
                            window.location.href = "/Proyecto/";
                        } else {
                            alert(response);
                            $("#error-message").html(response);
                            $("#error-message").show();
                        }
                    },
                    error: function() {
                        $("#error-message").html('Ocurrió un error al procesar la solicitud.');
                        $("#error-message").show();
                    }
                });
            }
        });
            
    
        $(document).on("click", "#comentar", function(event) {
            event.preventDefault();
            $("#comentario").val($(this).data('comentario'));
            $("#puntuacion").val($(this).data('estrellas'));
            $("#habitacion").val($(this).data('idhab'));
            $("#usuario").val($(this).data('iduser'));

            const contenedor = document.getElementById('estrellas');
            for (let i = 0; i < 5; i++) {
                const estrella = document.createElement('small');
                estrella.classList.add('fa-star', 'text-primary', 'estrella');

                if (i < $(this).data('estrellas')) {
                    estrella.classList.add('fas'); // Estrella rellena
                } else {
                    estrella.classList.add('far'); // Estrella vacía
                }

                estrella.setAttribute('data-value', i);
                contenedor.appendChild(estrella);
            }

            const estrellas = document.querySelectorAll('.fa-star');

            estrellas.forEach((star, index) => {
                star.addEventListener('click', () => {
                const valor = index + 1;

                estrellas.forEach((s, i) => {
                    if (i < valor) {
                        s.classList.remove('far');
                        s.classList.add('fas');
                    } else {
                        s.classList.remove('fas');
                        s.classList.add('far');
                    }
                });

                $('#puntuacion').val(valor);
                });
            });

            $('#comentarModal').modal('show');
        });
        jQuery('#comentarModal').on('hidden.bs.modal', function (e) {
            $('#comentForm')[0].reset(); $('[id$=\'-error\']').hide();$('.fa-star').removeClass('fas').addClass('far'); $('#puntuacion').val('');
            $('#estrellas').empty();
        })
        function mostrarModalPago(monto,reserva,inicio,fin) {
            $('#pagoModal').modal('show');
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
                                        reserva : reserva,
                                        finicio : inicio,
                                        ffin : fin,
                                        monto : monto,
                                        email : email,
                                        nombre : nombre,
                                        pagar : 1
                                    },
                                    success: function(response) {
                                        if (response) {
                                            window.location.href = "/Proyecto/user";
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
        $(document).on("click", "#pagar", function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente

            const reserva = $(this).data('idreserva');
            mostrarModalPago($("#monto-"+reserva).text(),reserva,$("#finicio-"+reserva).text(),$("#ffin-"+reserva).text());
  
        });
        $(document).on("click", "#confirmar", function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente

            const reserva = $(this).data('idreserva');
            const comienzo = $(this).data('comienzo');

            $.ajax({
                url: '/Proyecto/reservaController',
                type: 'POST',
                data: {
                    reserva : reserva,
                    comienzo : comienzo,
                    confirmar : 1
                },
                success: function(response) {
                    if (response == 1) {
                        mostrarModalPago($("#monto-"+reserva).text(),reserva,$("#finicio-"+reserva).text(),$("#ffin-"+reserva).text());
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

        });
        $(document).on("submit", "#incidenciaForm", function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente
            let error = 0;
            
            const reserva = $(this).find("#reserva").val();
            const incidencia = $(this).find("#incidencia").val().trim();
            
            const incidenciaPattern = /^[a-zA-Z0-9\s]{1,500}$/;
            if (!incidenciaPattern.test(incidencia)) {
                $(this).find("#incidencia-error").show();
                error = 1;
            }else{
                $(this).find("#incidencia-error").hide();
            }

            if (error == 0) {
                $.ajax({
                    url: '/Proyecto/comentarioController',
                    type: 'POST',
                    data: {
                        reserva : reserva,
                        incidencia : incidencia,
                        insertarIncidencia : 1
                    },
                    success: function(response) {
                        if (response == true) {
                            window.location.href = "/Proyecto/user";
                            alert("Incidencia introducida con exito!!");
                        } else {
                            alert(response);
                            $("#error-message").html(response);
                            $("#error-message").show();
                        }
                    },
                    error: function() {
                        $("#error-message").html('Ocurrió un error al procesar la solicitud.');
                        $("#error-message").show();
                    }
                });
            }else{
                $("#error-message").html("Algún campo no es correcto");
                $("#error-message").show();
            }
        });
        $(document).on("submit", "#comentForm", function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente
            let error = 0;
            
            const idHab = $(this).find("#habitacion").val();
            const comentario = $(this).find("#comentario").val().trim();
            const idUser = $(this).find("#usuario").val();
            const puntuacion = $(this).find("#puntuacion").val();
            const fecha = $(this).find("#fecha").val();

            const comentarioPattern = /^[a-zA-Z0-9\s]{1,500}$/;
            if (!comentarioPattern.test(comentario)) {
                $(this).find("#comentario-error").show();
                error = 1;
            }else{
                $(this).find("#comentario-error").hide();
            }

            if (error == 0) {
                $.ajax({
                    url: '/Proyecto/comentarioController',
                    type: 'POST',
                    data: {
                        habitacion : idHab,
                        usuario : idUser,
                        comentario : comentario,
                        estrellas : puntuacion,
                        fecha : fecha,
                        insertar : 1
                    },
                    success: function(response) {
                        if (response == true) {
                            window.location.href = "/Proyecto/user";
                        } else {
                            alert(response);
                            $("#error-message").html(response);
                            $("#error-message").show();
                        }
                    },
                    error: function() {
                        $("#error-message").html('Ocurrió un error al procesar la solicitud.');
                        $("#error-message").show();
                    }
                });
            }else{
                $("#error-message").html("Algún campo no es correcto");
                $("#error-message").show();
            }
        });
        $(document).on("submit", "#updateForm", function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente
            let error = 0;
            
            const id = $(this).find("#id1").val();
            const nombre = $(this).find("#nombre").val().trim();
            const apellidos = $(this).find("#apellidos").val();
            const correo = $(this).find("#correo").val().trim();
            const contraseña = $(this).find("#passwd").val().trim();
            const dni = $(this).find("#dni").val().trim();
            const sexo = $(this).find("#sexo").val().trim();
            const domicilio = $(this).find("#domicilio").val().trim();
            const fnac = $(this).find("#nacimiento").val().trim();
            const admin = 0;

            const nombrePattern = /^[a-zA-Z0-9\s]{1,100}$/;
            if (!nombrePattern.test(nombre)) {
                $(this).find("#nombre-error").show();
                $('#nombre').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#nombre-error").hide();
            }

            const apellidosPattern = /^[A-Za-z\s]{1,100}$/;
            if (!apellidosPattern.test(apellidos)) {
                $(this).find("#apellidos-error").show();
                $('#apellidos').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#apellidos-error").hide();
            }

            const correoPattern = /^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!correoPattern.test(correo)) {
                $(this).find("#correo-error").show();
                $('#correo').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#correo-error").hide();
            }

            const passwordPattern = /^[A-Za-z\d@$!%*#?&_-]{6,}$/;
            if (!passwordPattern.test(contraseña)) {
                $(this).find("#passwd-error").show(); 
                $('#passwd').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#passwd-error").hide();
            }

            const dniPattern = /^[0-9]{1,8}[A-Z]$/;
            if (!dniPattern.test(dni)) {
                $(this).find("#dni-error").show();
                $('#dni').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#dni-error").hide();
            }

            const domicilioPattern = /^[a-zA-Z0-9º\s]{1,50}$/;
            if (!domicilioPattern.test(domicilio)) {
                $(this).find("#domicilio-error").show();
                $('#domicilio').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#domicilio-error").hide();
            }

            const nacimiento = new Date(fnac);
            const hoy = new Date();
            let edad = hoy.getFullYear() - nacimiento.getFullYear();
            const cumpleEsteAno = hoy.getMonth() > nacimiento.getMonth() || (hoy.getMonth() === nacimiento.getMonth() && hoy.getDate() >= nacimiento.getDate());
            if (!cumpleEsteAno) edad--;
            const esMenor = edad < 18;

            if (fnac != "") {
                if (esMenor) {
                    $(this).find("#nacimiento-error").text("No puedes crear una cuenta para un menor de edad")
                    $(this).find("#nacimiento-error").show();
                    $('#nacimiento').addClass('is-invalid');
                    error = 1;
                }else{
                    $(this).find("#nacimiento-error").hide();
                    $('#nacimiento').removeClass('is-invalid');
                }
            }else{
                $(this).find("#nacimiento-error").show();
                $('#nacimiento').addClass('is-invalid');
                error = 1;
            }

            if (error == 0) {
                $.ajax({
                    url: '/Proyecto/userController',
                    type: 'POST',
                    data: {
                        id : id,
                        nombre : nombre,
                        apellidos : apellidos,
                        correo : correo,
                        password : contraseña,
                        dni : dni,
                        sexo : sexo,
                        domicilio : domicilio,
                        nacimiento : fnac,
                        admin : admin,
                        actualizar : 1
                    },
                    success: function(response) {
                        if (response == true) {
                            window.location.href = "/Proyecto/user";
                        } else {
                            $("#error-message").html(response);
                            $("#error-message").show();
                        }
                    },
                    error: function() {
                        $("#error-message").html('Ocurrió un error al procesar la solicitud.');
                        $("#error-message").show();
                    }
                });
            }else{
                $("#error-message").html("Algún campo no es correcto");
                $("#error-message").show();
            }
        });
        $(document).on("click", "#cancelar", function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente
            
            const reserva = $(this).data('idreserva');

            $.ajax({
                url: '/Proyecto/userController',
                type: 'POST',
                data: {
                    reserva : reserva,
                    cancelar : 1
                },
                success: function(response) {
                    if (response == true) {
                        window.location.href = "/Proyecto/user";
                    } else {
                        $("#error-message").html(response);
                        $("#error-message").show();
                    }
                },
                error: function() {
                    $("#error-message").html('Ocurrió un error al procesar la solicitud.');
                    $("#error-message").show();
                }
            });
        });
    </script>
</body>

</html>