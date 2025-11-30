<?php
    require_once('controllers/hotel_controller.php');
    require_once('controllers/localidad_controller.php');
    require_once('controllers/users_controller.php');
    
    $hoteles = selectAllHotels();
    if (empty($hoteles)) {
        $hoteles = [];
    }
    $localidades = selectAllLocalidades();
    if (empty($localidades)) {
        $localidades = [];
    }
    $gerentes = selectAllUsersGerente();
    if (empty($gerentes)) {
        $gerentes = [];
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
                            <h6 class="m-0 font-weight-bold text-primary">Hoteles</h6>
                            <i class="fas fa-plus-circle fa-2x text-success" data-toggle="modal" style="cursor: pointer" data-target="#insertar"></i>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="miTabla" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Ubicación</th>
                                            <th>Localidad</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($hoteles as $hotel): ?>
                                        <tr>
                                            <td><?= $hotel['Nombre'] ?></td>
                                            <td><?= $hotel['Ubicacion'] ?></td>
                                            <td><?= $hotel['FK_IdLocalidad'] ?></td>
                                            <td class="col-1 text-center align-middle">
                                                <i class="fas fa-trash fa-sm mr-2" data-toggle="modal" style="cursor: pointer" data-target="#eliminar<?= $hotel['IdHotel'] ?>"></i>
                                                <i class="fas fa-edit fa-sm" data-toggle="modal" style="cursor: pointer" data-target="#actualizar<?= $hotel['IdHotel'] ?>"></i>
                                                <div class="modal fade" id="eliminar<?= $hotel['IdHotel'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Listo para eliminarlo?</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">Seleccionar "Eliminar" si quieres eliminar el hotel actual.</div>
                                                        <div id="error-message2" class="alert alert-danger" style="display: none;"></div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                                                <form id="deleteForm">
                                                                    <input type="hidden" id="idHotel" value="<?= $hotel['IdHotel'] ?>"/>
                                                                    <button class="btn btn-primary" type="submit">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="actualizar<?= $hotel['IdHotel'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    
                                                        <!-- Encabezado del modal -->
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Actualizar Hotel</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="$('#updateForm')[0].reset();$('[id$=\'-error\']').hide();$('.is-invalid').removeClass('is-invalid');">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <form id="updateForm" action="index.php" method="post">
                                                            <div class="modal-body">
                                                                <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                                                                <input type="hidden" class="form-control" value="<?= $hotel['IdHotel'] ?>" name="id1" id="id1">
                                                                <div class="form-group">
                                                                    <label for="nombre">Nombre</label>
                                                                    <input type="text" class="form-control" value="<?= $hotel['Nombre'] ?>" name="nombre" id="nombre">
                                                                    <div class="invalid-feedback" style="display: none;" id="nombre-error">
                                                                        El nombre es inválido o demasiado largo (máx. 100 caracteres).
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="ubicacion">Ubicación</label>
                                                                    <input type="text" class="form-control" value="<?= $hotel['Ubicacion'] ?>" name="ubicacion" id="ubicacion">
                                                                    <div class="invalid-feedback" style="display: none;" id="ubicacion-error">
                                                                        La ubicación es inválida o demasiado larga (máx. 100 caracteres).
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="localidad">Localidad</label>
                                                                    <select class="form-control" id="localidad" name="localidad">
                                                                        <option value="">Seleccione una opción</option>
                                                                        <?php foreach ($localidades as $localidad): ?>
                                                                            <option value="<?= $localidad['IdLocalidad'] ?>" <?= $hotel['FK_IdLocalidad'] == $localidad['Nombre'] ? 'selected' : '' ?>><?= $localidad['Nombre'] ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <div class="invalid-feedback" style="display: none;" id="localidad-error">
                                                                        La localidad no tiene que estar vacia.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" type="button" onclick="$('#updateForm')[0].reset();$('[id$=\'-error\']').hide();$('.is-invalid').removeClass('is-invalid');" data-dismiss="modal">Cancelar</button>
                                                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            </td>
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
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="$('#insertForm')[0].reset(); $('[id$=\'-error1\']').hide();$('.is-invalid').removeClass('is-invalid');">
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
    <div class="modal fade" id="insertar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        
            <!-- Encabezado del modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Insertar Hotel</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="insertForm" action="index.php" method="post">
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
                        <label for="ubicacion">Ubicación</label>
                        <input type="text" class="form-control" name="ubicacion1" id="ubicacion1">
                        <div class="invalid-feedback" style="display: none;" id="ubicacion-error1">
                            La ubicación es inválida o demasiado larga (máx. 100 caracteres).
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="localidad">Localidad</label>
                        <select class="form-control" id="localidad1" name="localidad1">
                            <option value="">Seleccione una opción</option>
                            <?php foreach ($localidades as $localidad): ?>
                                <option value="<?= $localidad['IdLocalidad'] ?>"><?= $localidad['Nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback" style="display: none;" id="localidad-error1">
                            La localidad no tiene que estar vacia.
                        </div>
                    </div>
                    <div class="form-group">
                    <!-- Mirar más tarde -->
                    <label for="localidad">Gerentes</label>
                        <select class="form-control" id="gerente" name="gerente">
                            <option value="">Seleccione una opción</option>
                            <?php foreach ($gerentes as $gerente): ?>
                                <option value="<?= $gerente['IdUsuario'] ?>"><?= $gerente['Nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback" style="display: none;" id="usuario-error1">
                            El usuario no tiene que estar vacia.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" onclick="$('#insertForm')[0].reset(); $('[id$=\'-error1\']').hide();$('.is-invalid').removeClass('is-invalid');" data-dismiss="modal">Cancelar</button>
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
        $(document).on("submit", "#insertForm", function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente
            let error = 0;

            const nombre =  $(this).find("#nombre1").val();
            const ubicacion = $(this).find("#ubicacion1").val();
            const localidad =  $(this).find("#localidad1").val();
            const gerente =  $(this).find("#gerente").val();

            const nombrePattern = /^[a-zA-Z0-9\s]{1,100}$/;
            if (!nombrePattern.test(nombre)) {
                $("#nombre-error1").show();
                $('#nombre1').addClass('is-invalid');
                error = 1;
            }else{
                $("#nombre-error1").hide();
            }

            if (!nombrePattern.test(ubicacion)) {
                $(this).find("#ubicacion-error1").show();
                $('#ubicacion1').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#ubicacion-error1").hide();
            }

            if(localidad == ""){
                $("#localidad-error1").show();
                $('#localidad1').addClass('is-invalid');
                error = 1;
            }else{
                $("#localidad-error1").hide();
            }

            if (error == 0) {
                $.ajax({
                    url: '/Proyecto/hotelController',
                    type: 'POST',
                    data: {
                        nombre : nombre,
                        ubicacion : ubicacion,
                        localidad : localidad,
                        usuario : gerente,
                        insertar : 1
                    },
                    success: function(response) {
                        if (response == true) {
                            window.location.href = "/Proyecto/admin/hoteles";
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
        });
        $(document).ready(function() {
            $(document).on("submit", "#deleteForm", function(event) {
                event.preventDefault();
                id =  $(this).find("#idHotel").val();
                $.ajax({
                    url: '/Proyecto/hotelController',
                    type: 'POST',
                    data: {
                        id : id,
                        eliminar : 1
                    },
                    success: function(response) {
                        window.location.href = "/Proyecto/admin/hoteles";
                    },
                    error: function() {
                        $("#error-message2").html('Ocurrió un error al procesar la solicitud.');
                        $("#error-message2").show();
                    }
                });
            })
            $(document).on("submit", "#updateForm", function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente
            let error = 0;
            
            const id =  $(this).find("#id1").val();
            const nombre =  $(this).find("#nombre").val();
            const ubicacion = $(this).find("#ubicacion").val();
            const localidad =  $(this).find("#localidad").val();

            const nombrePattern = /^[a-zA-Z0-9\s]{1,500}$/;
            if (!nombrePattern.test(nombre)) {
               $(this).find("#nombre-error").show();
                $(this).find("#nombre").addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#nombre-error").hide();
            }

            if (!nombrePattern.test(ubicacion)) {
                $(this).find("#ubicacion-error").show();
                $('#ubicacion').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#ubicacion-error").hide();
            }

            if(localidad == ""){
                $(this).find("#localidad").addClass('is-invalid');
                $(this).find("#localidad-error").show();
                error = 1;
            }else{
                $(this).find("#localidad-error").hide();
            }

            if (error == 0) {
                $.ajax({
                    url: '/Proyecto/hotelController',
                    type: 'POST',
                    data: {
                        id : id,
                        nombre : nombre,
                        ubicacion : ubicacion,
                        localidad : localidad,
                        actualizar : 1
                    },
                    success: function(response) {
                        if (response == true) {
                            window.location.href = "/Proyecto/admin/hoteles";
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