<?php
    require_once('controllers/aplicaCodProm_controller.php');
    require_once('controllers/codProm_controller.php');
    $codigos = selectAllCodProm();
    if (empty($codigos)) {
        $codigos = [];
    }
    $codAplicados = selectAllAplica();
    if (empty($codAplicados)) {
        $codAplicados = [];
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
    <style>
        .modal-header, .modal-body, .modal-footer{
            background-color: var(--segundo-primary);
            color: var(--color-letra);
            border-color: var(--color-letra);
        }

        .modal-footer button:hover{
            background-color: var(--segundo-light);
            color: var(--segundo-primary);
            border-color: var(--color-letra);
        }

        .modal-footer button{
            background-color: var(--segundo-primary);
            color: var(--color-letra);
            border-color: var(--color-letra);
        }

        .modal-header span{
            color: var(--color-letra);
        }

        #contenido{
            border-color: var(--color-letra);
        }
    </style>

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
                            <h6 class="m-0 font-weight-bold text-primary">Aplicar Código Promocinal</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="miTabla" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Hotel</th>
                                            <th class="col-2"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($codAplicados as $codAplicado): ?>
                                        <tr>
                                            <td><?= $codAplicado['habitacion']['Nombre'] ?></td>
                                            <td><?= $codAplicado['habitacion']['FK_IdHotel'] ?></td>
                                            <td class="text-center align-middle">
                                                <i class="fas fa-plus-circle" data-toggle="modal" data-idhabitacion="<?= $codAplicado['habitacion']['IdHabitacion'] ?>" style="cursor: pointer; font-size: 1.5rem;" data-target="#insertar"></i>
                                                <?php if (count($codAplicado['codigos']) > 0): ?>
                                                    <i class="fas fa-eye ml-2" data-toggle="modal" style="cursor: pointer; font-size: 1.5rem;" data-target="#codigos<?= $codAplicado['habitacion']['IdHabitacion'] ?>"></i>
                                                    <div class="modal fade" tabindex="-1"  id="codigos<?= $codAplicado['habitacion']['IdHabitacion'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <!-- Encabezado del modal -->
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Códigos de <?= $codAplicado['habitacion']['Nombre'] ?></h5>
                                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                <table class="table table-bordered p-0 m-0" id="miTabla2" width="100%" cellspacing="0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Código</th>
                                                                            <th class="col-2">Descuento</th>
                                                                            <th class="col-2">F_Inicio</th>
                                                                            <th class="col-2">F_Fin</th>
                                                                            <th class="col-2"></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php foreach($codAplicado['codigos'] as $codigo): ?>
                                                                        <tr>
                                                                            <td><?= $codigo['Codigo'] ?></td>
                                                                            <td><?= $codigo['Descuento'] ?>%</td>
                                                                            <td><?= $codigo['FInicio'] ?></td>
                                                                            <td><?= $codigo['FFin'] ?></td>
                                                                            <td>
                                                                                <i class="fas fa-trash fa-sm" data-idhabitacion="<?= $codAplicado['habitacion']['IdHabitacion'] ?>" data-idcodigo="<?= $codigo['IdCodigo']?>" data-toggle="modal" style="cursor: pointer" data-target="#eliminar"></i>
                                                                                <i class="fas fa-edit fa-sm" data-toggle="modal" data-fin="<?= $codigo['FFin'] ?>" data-inicio="<?= $codigo['FInicio'] ?>" data-idhabitacion="<?= $codAplicado['habitacion']['IdHabitacion'] ?>" data-idcodigo="<?= $codigo['IdCodigo']?>" style="cursor: pointer" data-target="#actualizar"></i>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
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
    <!-- Insertar Modal -->
    <div class="modal fade" id="insertar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        
            <!-- Encabezado del modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Aplicar Código</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="$('#insertForm')[0].reset(); $('[id$=\'-error1\']').hide();$('.is-invalid').removeClass('is-invalid');">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="insertForm" action="index.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                    <div class="form-group">
                        <label for="codigo">Código</label>
                        <select class="form-control" id="codigo" name="codigo">
                            <option value="">Seleccione una opción</option>
                            <?php foreach ($codigos as $codigo): ?>
                                <option value="<?= $codigo['IdCodigo'] ?>"><?= $codigo['Codigo'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback" style="display: none;" id="codigo-error1">
                            El código no tiene que estar vacio.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="codigo">Fecha Inicio</label>
                        <input type="date" class="form-control" name="codigo" id="finicio">
                        <div class="invalid-feedback" style="display: none;" id="finicio-error1">
                            Ingresa la fecha de inicio.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="codigo">Fecha Fin</label>
                        <input type="date" class="form-control" name="codigo" id="ffin">
                        <div class="invalid-feedback" style="display: none;" id="ffin-error1">
                            Ingresa la fecha de fin.
                        </div>
                    </div>
                    <input type="hidden" id="idHabitacion">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" onclick="$('#insertForm')[0].reset(); $('[id$=\'-error1\']').hide();$('.is-invalid').removeClass('is-invalid');" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Insertar</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <!-- Eliminar Modal -->
    <div class="modal fade" id="eliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Listo para eliminarlo?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Seleccionar "Eliminar" si quieres eliminar la localidad actual.</div>
            <div id="error-message1" class="alert alert-danger" style="display: none;"></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <form id="deleteForm">
                        <input type="hidden" id="idHabitacion1"/>
                        <input type="hidden" id="idCodigo1"/>
                        <button class="btn btn-primary" type="submit">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Actualizar Modal -->
    <div class="modal fade" id="actualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar Código</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="$('#updateForm')[0].reset(); $('[id$=\'-error\']').hide();$('.is-invalid').removeClass('is-invalid');">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="updateForm" action="index.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div id="error-message2" class="alert alert-danger" style="display: none;"></div>
                    <input type="hidden" id="idHabitacion2"/>
                    <input type="hidden" id="idCodigo2"/>
                    <div class="form-group">
                        <label for="codigo">Fecha Inicio</label>
                        <input type="date" class="form-control" name="codigo" id="inicio2">
                        <div class="invalid-feedback" style="display: none;" id="finicio-error">
                            Ingresa la fecha de inicio.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="codigo">Fecha Fin</label>
                        <input type="date" class="form-control" name="codigo" id="fin2">
                        <div class="invalid-feedback" style="display: none;" id="ffin-error">
                            Ingresa la fecha de fin.
                        </div>
                    </div>
                    <input type="hidden" id="idHabitacion">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" onclick="$('#updateForm')[0].reset(); $('[id$=\'-error\']').hide();$('.is-invalid').removeClass('is-invalid');" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
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
    <script src="vendor/datatables/myDataTable2.js"></script>

    <script src="js/demo/datatables-demo.js"></script>

    <script>
        $(document).on("submit", "#insertForm", function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente
            let error = 0;

            const codigo = $(this).find("#codigo").val();
            const habitacion = $(this).find("#idHabitacion").val();
            const inicio = $(this).find("#finicio").val();
            const fin = $(this).find("#ffin").val();

            const hoy = new Date();

            if(codigo == ""){
                $(this).find("#codigo-error1").show();
                $('#codigo').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#codigo-error1").hide();
            }

            if (!inicio) {
                $(this).find("#finicio-error1").show();
                $('#finicio').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#finicio-error1").hide();
            }

            if (!fin) {
                $(this).find("#ffin-error1").show();
                $('#ffin').addClass('is-invalid');
                error = 1;
            }else{
                $(this).find("#ffin-error1").hide();
            }

            const fechaInicio = new Date(inicio);
            const fechaFin = new Date(fin);
            hoy.setHours(0, 0, 0, 0);
            fechaInicio.setHours(0, 0, 0, 0);
            fechaFin.setHours(0, 0, 0, 0);
            if (fechaInicio < hoy) {
                $(this).find("#finicio-error1").html('La fecha de inicio no puede ser menor a hoy.');
                $(this).find("#finicio-error1").show();
                $('#finicio').addClass('is-invalid');
                error = 1;
            }

            if (fechaInicio > fechaFin) {
                $(this).find("#finicio-error1").html('La fecha de inicio no puede ser posterior a la de fin.');
                $(this).find("#finicio-error1").show();
                $(this).find("#ffin-error1").html('La fecha de inicio no puede ser posterior a la de fin.');
                $(this).find("#ffin-error1").show();
                $('#finicio').addClass('is-invalid');
                error = 1;
            }

            if (error == 0) {
                $.ajax({
                    url: '/Proyecto/aplicaCodPromController',
                    type: 'POST',
                    data: {
                        codigo : codigo,
                        habitacion : habitacion,
                        finicio : inicio,
                        fin : fin,
                        aplicar : 1
                    },
                    success: function(response) {
                        if (response == true) {
                            window.location.href = "/Proyecto/admin/aplicarCodProm";
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
        $(document).ready(function() {
            $(document).on('click', '.fa-plus-circle', function () {
                var idHabitacion = $(this).data('idhabitacion');
                $('#idHabitacion').val(idHabitacion);
            });
            $(document).on('click', '.fa-edit', function () {
                var idHabitacion = $(this).data('idhabitacion');
                var idCodigo = $(this).data('idcodigo');
                var inicio = $(this).data('inicio');
                var fin = $(this).data('fin');
                $('#idHabitacion2').val(idHabitacion);
                $('#idCodigo2').val(idCodigo);
                $('#inicio2').val(inicio);
                $('#fin2').val(fin);
            });
            $(document).on('click', '.fa-trash', function () {
                var idHabitacion = $(this).data('idhabitacion');
                var idCodigo = $(this).data('idcodigo');
                $('#idHabitacion1').val(idHabitacion);
                $('#idCodigo1').val(idCodigo);
            });
            $(document).on("submit", "#updateForm", function(event) {
                event.preventDefault(); // Evita que se envíe el form automáticamente
                let error = 0;

                const codigo = $(this).find("#idCodigo2").val();
                const habitacion = $(this).find("#idHabitacion2").val();
                const inicio = $(this).find("#inicio2").val();
                const fin = $(this).find("#fin2").val();

                const hoy = new Date();

                if (!inicio) {
                    $(this).find("#finicio-error").show();
                    $('#finicio').addClass('is-invalid');
                    error = 1;
                }else{
                    $(this).find("#finicio-error").hide();
                }

                if (!fin) {
                    $(this).find("#ffin-error").show();
                    $('#ffin').addClass('is-invalid');
                    error = 1;
                }else{
                    $(this).find("#ffin-error").hide();
                }

                const fechaInicio = new Date(inicio);
                const fechaFin = new Date(fin);
                hoy.setHours(0, 0, 0, 0);
                fechaInicio.setHours(0, 0, 0, 0);
                fechaFin.setHours(0, 0, 0, 0);
                if (fechaInicio <= hoy) {
                    $(this).find("#finicio-error").html('La fecha de inicio no puede ser menor a hoy.');
                    $(this).find("#ffin-error").show();
                    $(this).find("#ffin-error").show();
                    error = 1;
                }

                if (fechaInicio > fechaFin) {
                $(this).find("#finicio-error").html('La fecha de inicio no puede ser posterior a la de fin.');
                $(this).find("#finicio-error").show();
                $('#finicio').addClass('is-invalid');
                $(this).find("#ffin-error").html('La fecha de inicio no puede ser posterior a la de fin.');
                $(this).find("#ffin-error").show();
                $('#ffin').addClass('is-invalid');
                error = 1;
            }

                if (error == 0) {
                    $.ajax({
                        url: '/Proyecto/aplicaCodPromController',
                        type: 'POST',
                        data: {
                            codigo : codigo,
                            habitacion : habitacion,
                            finicio : inicio,
                            fin : fin,
                            update : 1
                        },
                        success: function(response) {
                            if (response == true) {
                                window.location.href = "/Proyecto/admin/aplicarCodProm";
                            } else {
                                $("#error-message2").html(response);
                                $("#error-message2").show();
                            }
                        },
                        error: function() {
                            $("#error-message2").html('Ocurrió un error al procesar la solicitud.');
                            $("#error-message2").show();
                        }
                    });
                }else{
                    $("#error-message2").html("Algún campo no es correcto");
                    $("#error-message2").show();
                }
            });
            $(document).on("submit", "#deleteForm", function(event) {
                event.preventDefault();

                const codigo = $(this).find("#idCodigo1").val();
                const habitacion = $(this).find("#idHabitacion1").val();

                $.ajax({
                    url: '/Proyecto/aplicaCodPromController',
                    type: 'POST',
                    data: {
                        codigo : codigo,
                        habitacion : habitacion,
                        eliminar : 1
                    },
                    success: function(response) {
                        window.location.href = "/Proyecto/admin/aplicarCodProm";
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