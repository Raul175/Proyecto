<?php
    require_once('controllers/reserva_controller.php');
    $reservas = selectAllReservas();
    if (empty($reservas) || !is_array($reservas)) {
        $reservas = [];
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
                            <h6 class="m-0 font-weight-bold text-primary">Facturas</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="miTabla" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Habitación</th>
                                            <th>Usuario</th>
                                            <th>F_Entrada</th>
                                            <th>F_Salida</th>
                                            <th>Estado</th>
                                            <th>Precio</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($reservas as $reserva): ?>
                                        <tr>
                                            <td><?= $reserva['Habitacion'] ?></td>
                                            <td><?= $reserva['Usuario'] ?></td>
                                            <td><?= $reserva['FEntrada'] ?></td>
                                            <td><?= $reserva['FSalida'] ?></td>
                                            <td><?= $reserva['Estado'] ?></td>
                                            <th><?= $reserva['Precio'] ?? 0 ?>€</th>
                                            <th class="text-center align-middle"><?php if ($reserva['Incidencia'] != null) echo '<i data-toggle="modal" data-target="#eliminar" data-incidencia='.$reserva['Incidencia'].' data-usuario='.$reserva['Usuario'].' data-correo='.$reserva['Correo'].'  style="cursor: pointer" data-reserva='.$reserva['Reserva'].' class="fas fa-exclamation-circle"></i>' ?></th>
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
    <!-- Eliminar Modal -->
    <div class="modal fade" id="eliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Listo para resolver la incidencia?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Seleccionar "Enviar Técnico" para resolver la incidencia.
                <p id="persona5"></p>
            </div>
            <div id="error-message1" class="alert alert-danger" style="display: none;"></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <form id="deleteForm">
                        <input type="hidden" id="reserva"/>
                        <input type="hidden" id="usuario"/>
                        <input type="hidden" id="incidencia"/>
                        <input type="hidden" id="correo"/>
                        <button class="btn btn-primary" type="submit">Enviar Técnico</button>
                    </form>
                </div>
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
            $(document).on('click', '.fa-exclamation-circle', function () {
                var reserva = $(this).data('reserva');
                var usuario = $(this).data('usuario');
                var correo = $(this).data('correo');
                var incidencia = $(this).data('incidencia');
                $('#reserva').val(reserva);
                $('#usuario').val(usuario);
                $('#correo').val(correo);
                $('#incidencia').val(incidencia);
                $('#persona5').text("Incidencia: " + incidencia);
            });
            $(document).on("submit", "#deleteForm", function(event) {
                event.preventDefault();

                const reserva = $(this).find("#reserva").val();
                const usuario = $(this).find("#usuario").val();
                const correo = $(this).find("#correo").val();
                const incidencia = $(this).find("#incidencia").val();

                $.ajax({
                    url: '/Proyecto/reservaController',
                    type: 'POST',
                    data: {
                        reserva : reserva,
                        usuario : usuario,
                        correo : correo,
                        incidencia : incidencia,
                        resolver : 1
                    },
                    success: function(response) {
                        window.location.href = "/Proyecto/admin/facturas";
                        alert("Se le ha informado al usuario de que va de camino un técnico");
                    },
                    error: function() {
                        $("#error-message2").html('Ocurrió un error al procesar la solicitud.');
                        $("#error-message2").show();
                    }
                });
            })
        });
    </script>

</body>

</html>