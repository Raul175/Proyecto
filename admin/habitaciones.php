<?php
    require_once('controllers/room_controller.php');
    require_once('controllers/hotel_controller.php');
    $habitaciones = selectAllRooms();
    if (empty($habitaciones)) {
        $habitaciones = [];
    }
    $hoteles = selectAllHotels();
    if (empty($hoteles)) {
        $hoteles = [];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include("layout/cabeceraAdmin.php"); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav id="navbar" class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline mostaza small"><?php echo $_SESSION['usuario']; ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="/Proyecto/admin?cerrarSesion" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar Sesión
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="card shadow mb-4" id="contenido">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold">Habitaciones</h6>
                            <i class="fas fa-plus-circle fa-2x" data-toggle="modal" style="cursor: pointer" data-target="#insertar"></i>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="miTabla" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Nº Personas</th>
                                            <th>m2</th>
                                            <th>Tipo</th>
                                            <th>Precio Unitario</th>
                                            <th>Hotel</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($habitaciones as $habitacion): ?>
                                        <tr>
                                            <td><?= $habitacion['Nombre'] ?></td>
                                            <td><?= $habitacion['NPersonas'] ?></td>
                                            <td><?= $habitacion['m2'] ?></td>
                                            <td><?= empty($habitacion['Tipo']) ? "Normal" : $habitacion['Tipo'] ?></td>
                                            <td><?= $habitacion['PrecioUnitario'] ?></td>
                                            <td><?= $habitacion['FK_IdHotel'] ?></td>
                                            <td class="col-1 text-center align-middle">
                                                <i class="fas fa-trash fa-sm mr-2" data-toggle="modal" style="cursor: pointer" data-target="#eliminar<?= $habitacion['IdHabitacion'] ?>"></i>
                                                <i class="fas fa-edit fa-sm mr-2" data-toggle="modal" style="cursor: pointer" data-target="#actualizar<?= $habitacion['IdHabitacion'] ?>"></i>
                                                <i class="fas fa-gear fa-sm" data-toggle="modal" style="cursor: pointer" data-target="#añadir<?= $habitacion['IdHabitacion'] ?>"></i>
                                                <div class="modal fade" id="añadir<?= $habitacion['IdHabitacion'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Listo para eliminarla?</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h5 class="modal-title" id="exampleModalLabel">Escoge los añadidos para esta habitación.</h5>
                                                            <form id="addForm">
                                                                <input type="hidden" value="<?= $habitacion['IdHabitacion'] ?>" class="form-check-input mr-4" name="habitacion" id="habitacion">
                                                                <div class="form-group d-flex justify-content-center mb-2">
                                                                    <i class="fa-solid fa-vault fa-2x ml-4"></i>
                                                                    <input type="checkbox" class="form-check-input mr-4" name="caja" id="caja" <?= $habitacion['CajaFuerte'] === 1 || $habitacion['CajaFuerte'] === null ? '' : 'checked' ?>>
                                                                </div>
                                                                <div class="form-group d-flex justify-content-center mb-2">
                                                                    <i class="fas fa-wifi fa-2x ml-4"></i>
                                                                    <input type="checkbox" class="form-check-input mr-4" name="wifi" id="wifi" <?= $habitacion['Wifi'] === 1 || $habitacion['Wifi'] === null ? '' : 'checked' ?>>
                                                                </div>
                                                                <div class="form-group d-flex justify-content-center mb-3">
                                                                    <i class="fas fa-wine-bottle fa-2x ml-4"></i>
                                                                    <input type="checkbox" class="form-check-input mr-4" name="bar" id="bar" <?= $habitacion['Minibar'] === 1 || $habitacion['Minibar'] === null ? '' : 'checked' ?>>
                                                                </div>
                                                        </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-primary" type="submit">Añadir</button>
                                                                </form>
                                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="eliminar<?= $habitacion['IdHabitacion'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Listo para eliminarla?</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">Seleccionar "Eliminar" si quieres eliminar la habitación actual.</div>
                                                        <div id="error-message2" class="alert alert-danger" style="display: none;"></div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                                                <form id="deleteForm" action="#" method="post">
                                                                    <input type="hidden" id="idHab" value="<?= $habitacion['IdHabitacion'] ?>"/>
                                                                    <button class="btn btn-primary" type="submit">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="actualizar<?= $habitacion['IdHabitacion'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    
                                                        <!-- Encabezado del modal -->
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Actualizar Habitación</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="$('#updateForm')[0].reset(); $('[id$=\'-error\']').hide();$('.is-invalid').removeClass('is-invalid');">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <form id="updateForm" action="#" method="post">
                                                            <div class="modal-body">
                                                                <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                                                                <input style="display: none;" name="id" value="<?= $habitacion['IdHabitacion'] ?>" id="id">
                                                                <div class="form-group">
                                                                    <label for="nombre">Nombre</label>
                                                                    <input type="text" class="form-control" name="nombre" value="<?= $habitacion['Nombre'] ?>" id="nombre">
                                                                    <div class="invalid-feedback" style="display: none;" id="nombre-error">
                                                                        El nombre es inválido o demasiado largo (máx. 100 caracteres).
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="precio">Precio</label>
                                                                    <input type="number" name="precio"  value="<?= $habitacion['PrecioUnitario'] ?>" class="form-control" id="precio">
                                                                    <div class="invalid-feedback" style="display: none;" id="precio-error">
                                                                        El precio unitario debe ser un número válido con hasta 2 decimales.
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="m2">m2</label>
                                                                    <input type="number" class="form-control"  value="<?= $habitacion['m2'] ?>" name="m2" id="m2">
                                                                    <div class="invalid-feedback" style="display: none;" id="m2-error">
                                                                        Los m2 deben ser un número válido con hasta 2 decimales
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="npersonas">NºPersonas</label>
                                                                    <input type="number" class="form-control"  value="<?= $habitacion['NPersonas'] ?>" name="npersonas" id="npersonas">
                                                                    <div class="invalid-feedback" style="display: none;" id="npersonas-error">
                                                                        El número de personas debe ser un entero positivo.
                                                                    </div>
                                                                </div>
                                                                <div class="form-group" style="display: none;">
                                                                    <label for="tipo">Tipo</label>
                                                                    <select class="form-control" id="tipo" name="tipo">
                                                                        <option value="">Seleccione una opción</option>
                                                                        <option value="suite" <?= $habitacion['Tipo'] === 'suite' ? 'selected' : '' ?>>Suite</option>
                                                                        <option value="vip" <?= $habitacion['Tipo'] === 'vip' ? 'selected' : '' ?>>VIP</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="hotel">Hotel</label>
                                                                    <select class="form-control" id="hotel" name="hotel">
                                                                        <option value="">Seleccione una opción</option>
                                                                        <?php foreach ($hoteles as $hotel): ?>
                                                                            <option value="<?= $hotel['IdHotel'] ?>" <?= $habitacion['FK_IdHotel'] == $hotel['Nombre'] ? 'selected' : '' ?>><?= $hotel['Nombre'] ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <div class="invalid-feedback" style="display: none;" id="hotel-error">
                                                                        Selecciona un hotel
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" onclick="$('#updateForm')[0].reset(); $('[id$=\'-error\']').hide();$('.is-invalid').removeClass('is-invalid');" type="button" data-dismiss="modal">Cancelar</button>
                                                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            </td>
                                            <!-- Eliminar Registro Modal -->
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Listo para salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccionar "Cerrar Sesión" si quieres terminar la sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="/Proyecto/admin?cerrarSesion">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Insertar Modal -->
    <div class="modal fade" id="insertar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        
            <!-- Encabezado del modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Insertar Habitación</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="$('#insertForm')[0].reset(); $('[id$=\'-error1\']').hide();$('.is-invalid').removeClass('is-invalid');">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="insertForm" action="index.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div id="error-message1" class="alert alert-danger" style="display: none;"></div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" name="nombre" id="nombre1">
                        <div class="invalid-feedback" style="display: none;" id="nombre-error1">
                            El nombre es inválido o demasiado largo (máx. 100 caracteres).
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" name="precio" class="form-control" id="precio1">
                        <div class="invalid-feedback" style="display: none;" id="precio-error1">
                            El precio unitario debe ser un número válido con hasta 2 decimales.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="m2">m2</label>
                        <input type="number" class="form-control" name="m2" id="m21">
                        <div class="invalid-feedback" style="display: none;" id="m2-error1">
                            Los m2 deben ser un número válido con hasta 2 decimales
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="npersonas">NºPersonas</label>
                        <input type="number" class="form-control" name="npersonas" id="npersonas1">
                        <div class="invalid-feedback" style="display: none;" id="npersonas-error1">
                            El número de personas debe ser un entero positivo.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <select class="form-control" id="tipo1" name="tipo1">
                            <option value="">Seleccione una opción</option>
                            <option value="suite">Suite</option>
                            <option value="vip">VIP</option>
                        </select>
                    </div>
                    <div class="form-group" id="vipInput" style="display:none;">
                        <label for="vip">Código VIP</label>
                        <input type="text" class="form-control" id="vip" name="vip">
                        <div class="invalid-feedback" style="display: none;" id="codvip-error1">
                            El código es inválido o demasiado largo (máx. 100 caracteres).
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hotel">Hotel</label>
                        <select class="form-control" id="hotel1" name="hotel1">
                            <option value="">Seleccione una opción</option>
                            <?php foreach ($hoteles as $hotel): ?>
                                <option value="<?= $hotel['IdHotel'] ?>"><?= $hotel['Nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback" style="display: none;" id="hotel-error1">
                            Selecciona un hotel
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="img">Imagen</label>
                        <input type="file" name="img" id="img" accept="image/jpeg,image/png,image/webm">
                        <div class="invalid-feedback" style="display: none;" id="img-error1"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" onclick="$('#insertForm')[0].reset(); $('[id$=\'-error1\']').hide();$('.is-invalid').removeClass('is-invalid');" type="button" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Insertar</button>
                </div>
            </form>
        </div>
    </div>
</div>

    

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="vendor/datatables/myDataTable.js"></script>

    <script src="js/demo/datatables-demo.js"></script>

    <script>
        $('#tipo1').on('change', function() {
            if ($(this).val() === 'vip') {
                $('#vipInput').show();
            } else {
                $('#vipInput').hide();
            }
        });
        $(document).on("submit", "#insertForm", function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente
            let error = 0;

            const nombre = $(this).find("#nombre1").val();
            const tipo = $(this).find("#tipo1").val();
            const nPersonas = $(this).find("#npersonas1").val();
            const precioUnitario = $(this).find("#precio1").val();
            const m2 = $(this).find("#m21").val();
            const hotel = $(this).find("#hotel1").val();
            const img = document.getElementById("img").files[0];
            const vip = $(this).find("#vip").val();

            const nombrePattern = /^[a-zA-Z0-9\s]{1,100}$/;
            if (!nombrePattern.test(nombre)) {
                $('#nombre1').addClass('is-invalid');
                $(this).find("#nombre-error1").show();
                error = 1;
            }

            const nPersonasPattern = /^[1-9][0-9]*$/;
            if (!nPersonasPattern.test(nPersonas)) {
                $('#npersonas1').addClass('is-invalid');
                $(this).find("#npersonas-error1").show();
                error = 1;
            }else{
                $(this).find("#npersonas-error1").hide();
            }

            const decimalPattern = /^\d+(\.\d{1,2})?$/;
            if (!decimalPattern.test(precioUnitario)) {
                $('#precio1').addClass('is-invalid');
                $(this).find("#precio-error1").show();
                error = 1;
            }else{
                $(this).find("#precio-error1").hide();
            }

            if(tipo == "vip"){
                const vipPattern = /^[a-zA-Z0-9\s]{1,100}$/;
                if (!vipPattern.test(vip)) {
                    $('#vip').addClass('is-invalid');
                    $(this).find("#codvip-error1").show();
                    error = 1;
                }else{
                    $(this).find("#codvip-error1").hide();
                }
            }

            if (!decimalPattern.test(m2)) {
                $('#m21').addClass('is-invalid');
                $(this).find("#m2-error1").show();
                error = 1;
            }else{
                $(this).find("#m2-error1").hide();
            }

            if(hotel == ""){
                $('#hotel1').addClass('is-invalid');
                $(this).find("#hotel-error1").show();
                error = 1;
            }else{
                $(this).find("#hotel-error1").hide();
            }

            if (!img) {
                $('#img').addClass('is-invalid');
                $(this).find("#img-error1").html("Selecciona una imagen");
                $(this).find("#img-error1").show();
                error = 1;
            }else{
                const tiposPermitidos = ['image/jpg', 'image/png', 'image/webm'];
                const maxSize = 5 * 1024 * 1024; // 5MB
                if (!tiposPermitidos.includes(img.type)) {
                    $('#img').addClass('is-invalid');
                    $(this).find("#img-error1").html('Tipo de archivo no permitido. Solo PNG');
                    $(this).find("#img-error1").show();
                    error = 1;
                }else if(img.size > maxSize) {ç
                    $('#img').addClass('is-invalid');
                    $(this).find("#img-error1").html('La imagen no debe superar los 5 MB');
                    $(this).find("#img-error1").show();
                    error = 1;
                }else{
                    $(this).find("#img-error1").hide();
                }
                const reader = new FileReader();
                reader.onloadend = function () {
                    if (error == 0) {
                        $.ajax({
                            url: '/Proyecto/roomController',
                            type: 'POST',
                            data: {
                                nombre : nombre,
                                tipo : tipo,
                                npersonas : nPersonas,
                                precio : precioUnitario,
                                m2 : m2,
                                hotel : hotel,
                                img : reader.result,
                                vip : vip,
                                insertar : 1
                            },
                            success: function(response) {
                                if (response == true) {
                                    window.location.href = "/Proyecto/admin/habitaciones";
                                } else {
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
                        $("#error-message1").html("Algún campo no es correcto");
                        $("#error-message1").show();
                    }
                };

                reader.onerror = function() {
                    console.log("Hubo un error al leer el archivo.");
                };

                reader.readAsDataURL(img);
            }
        });
        $(document).ready(function() {
            $(document).on("submit", "#addForm", function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente
            let error = 0;

            let caja = $(this).find("#caja").is(":checked") ? 0 : 1;
            let bar = $(this).find("#bar").is(":checked") ? 0 : 1;
            let wifi = $(this).find("#wifi").is(":checked") ? 0 : 1;
            let habitacion = $(this).find("#habitacion").val();

            $.ajax({
                url: '/Proyecto/roomController',
                type: 'POST',
                data: {
                    caja : caja,
                    bar : bar,
                    wifi : wifi,
                    habitacion : habitacion,
                    añadir : 1
                },
                success: function(response) {
                    window.location.href = "/Proyecto/admin/habitaciones";
                    alert("Complementos añadidos con exito");
                },
                error: function() {
                    $("#error-message2").html('Ocurrió un error al procesar la solicitud.');
                    $("#error-message2").show();
                }
            });
        });
            $(document).on("submit", "#deleteForm", function(event) {
                event.preventDefault();
                id = $(this).find("#idHab").val();
                $.ajax({
                    url: '/Proyecto/roomController',
                    type: 'POST',
                    data: {
                        id : id,
                        eliminar : 1
                    },
                    success: function(response) {
                        window.location.href = "/Proyecto/admin/habitaciones";
                    },
                    error: function() {
                        $("#error-message2").html('Ocurrió un error al procesar la solicitud.');
                        $("#error-message2").show();
                    }
                });
            })
            $(document).on("submit", "#updateForm", function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente
            let error = "";

            const id = $(this).find("#id").val();
            const nombre = $(this).find("#nombre").val();
            const tipo = $(this).find("#tipo").val();
            const nPersonas = $(this).find("#npersonas").val();
            const precioUnitario = $(this).find("#precio").val();
            const m2 = $(this).find("#m2").val();
            const hotel = $(this).find("#hotel").val();

            const nombrePattern = /^[a-zA-Z0-9._\s]{1,500}$/;
            if (!nombrePattern.test(nombre)) {
                $('#nombre').addClass('is-invalid');
                $(this).find("#nombre-error").show();
                error = 1;
            }else{
                $(this).find("#nombre-error").hide();
            }

            const nPersonasPattern = /^[1-9][0-9]*$/;
            if (!nPersonasPattern.test(nPersonas)) {
                $('#npersonas').addClass('is-invalid');
                $(this).find("#npersonas-error").show();
                error = 1;
            }else{
                $(this).find("#npersonas-error").hide();
            }

            const decimalPattern = /^\d+(\.\d{1,2})?$/;
            if (!decimalPattern.test(precioUnitario)) {
                $('#precio').addClass('is-invalid');
                $(this).find("#precio-error").show();
                error = 1;
            }else{
                $(this).find("#precio-error").hide();
            }

            if (!decimalPattern.test(m2)) {
                $('#m2').addClass('is-invalid');
                $(this).find("#m2-error").show();
                error = 1;
            }else{
                $(this).find("#m2-error").hide();
            }

            if(hotel == ""){
                $('#hotel').addClass('is-invalid');
                $(this).find("#hotel-error").show();
                error = 1;
            }else{
                $(this).find("#hotel-error").hide();
            }

            if (error == "") {
                $.ajax({
                    url: '/Proyecto/roomController',
                    type: 'POST',
                    data: {
                        id : id,
                        nombre : nombre,
                        tipo : tipo,
                        npersonas : nPersonas,
                        precio : precioUnitario,
                        m2 : m2,
                        hotel : hotel,
                        actualizar : 1
                    },
                    success: function(response) {
                        if (response == true) {
                            window.location.href = "/Proyecto/admin/habitaciones";
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
        });
    </script>
</body>

</html>