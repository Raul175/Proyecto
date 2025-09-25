<?php
    require_once('controllers/cama_controller.php');
    $camas = selectAllCama();
    if (empty($camas)) {
        $camas = [];
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
                            <h6 class="m-0 font-weight-bold text-primary">Camas</h6>
                            <i class="fas fa-plus-circle fa-2x text-success" data-toggle="modal" style="cursor: pointer" data-target="#insertar"></i>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="miTabla" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($camas as $cama): ?>
                                        <tr>
                                            <td><?= $cama['Tipo'] ?></td>
                                            <td class="col-1 text-center align-middle">
                                                <i class="fas fa-trash fa-sm mr-2" data-toggle="modal" style="cursor: pointer" data-target="#eliminar<?= $cama['IdCama'] ?>"></i>
                                                <i class="fas fa-edit fa-sm" data-toggle="modal" style="cursor: pointer" data-target="#actualizar<?= $cama['IdCama'] ?>"></i>
                                                <div class="modal fade" id="eliminar<?= $cama['IdCama'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Listo para eliminarlo?</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">Seleccionar "Eliminar" si quieres eliminar el tipo de cama actual.</div>
                                                        <div id="error-message2" class="alert alert-danger" style="display: none;"></div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                                                <form id="deleteForm">
                                                                    <input type="hidden" id="id" value="<?= $cama['IdCama'] ?>"/>
                                                                    <button class="btn btn-primary" type="submit">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="actualizar<?= $cama['IdCama'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    
                                                        <!-- Encabezado del modal -->
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Actualizar Tipo de Cama</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="$('#updateForm')[0].reset(); $('[id$=\'-error\']').hide();$('.is-invalid').removeClass('is-invalid');">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <form id="updateForm" action="index.php" method="post">
                                                            <div class="modal-body">
                                                                <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                                                                <input type="hidden" class="form-control" value="<?= $cama['IdCama'] ?>" name="id1" id="id1">
                                                                <div class="form-group">
                                                                    <label for="codigo">Tipo</label>
                                                                    <input type="text" class="form-control" value="<?= $cama['Tipo'] ?>" name="tipo" id="tipo">
                                                                    <div class="invalid-feedback" style="display: none;" id="tipo-error">
                                                                        El tipo de cama es inválido o demasiado largo.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" type="button" onclick="$('#updateForm')[0].reset(); $('[id$=\'-error\']').hide();$('.is-invalid').removeClass('is-invalid');" data-dismiss="modal">Cancelar</button>
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
    <div class="modal fade" id="insertar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        
            <!-- Encabezado del modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Insertar Tipo de Cama</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="$('#insertForm')[0].reset(); $('[id$=\'-error1\']').hide();$('.is-invalid').removeClass('is-invalid');">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="insertForm" action="index.php" method="post">
                <div class="modal-body">
                    <div id="error-message1" class="alert alert-danger" style="display: none;"></div>
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <input type="text" class="form-control" name="tipo" id="tipo1">
                        <div class="invalid-feedback" style="display: none;" id="tipo-error1">
                            El tipo de cama es inválido o demasiado largo.
                        </div>
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
        $(document).ready(function() {
            $(document).on("submit", "#insertForm", function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente
            let error = 0;

            const tipo = $(this).find("#tipo1").val();

            const tipoPattern = /^[a-zA-Z0-9\s]{1,50}$/;
            if (!tipoPattern.test(tipo)) {
                $(this).find("#tipo-error1").show();
                $('#tipo1').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#tipo-error1").hide();
            }

            if (error == 0) {
                $.ajax({
                    url: '/Proyecto/camaController',
                    type: 'POST',
                    data: {
                        tipo : tipo,
                        insertar : 1
                    },
                    success: function(response) {
                        if (response == true) {
                            window.location.href = "/Proyecto/admin/camas";
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
            $(document).on("submit", "#deleteForm", function(event) {
                event.preventDefault();
                const id = $(this).find("#id").val();
                $.ajax({
                    url: '/Proyecto/camaController',
                    type: 'POST',
                    data: {
                        id : id,
                        eliminar : 1
                    },
                    success: function(response) {
                        window.location.href = "/Proyecto/admin/camas";
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
            
            const id = $(this).find("#id1").val();
            const tipo = $(this).find("#tipo").val();

            const tipoPattern = /^[a-zA-Z0-9\s]{1,50}$/;
            if (!tipoPattern.test(tipo)) {
                $(this).find("#tipo-error").show();
                $('#tipo').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#tipo-error").hide();
            }

            if (error == 0) {
                $.ajax({
                    url: '/Proyecto/camaController',
                    type: 'POST',
                    data: {
                        id : id,
                        tipo : tipo,
                        actualizar : 1
                    },
                    success: function(response) {
                        if (response == true) {
                            window.location.href = "/Proyecto/admin/camas";
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