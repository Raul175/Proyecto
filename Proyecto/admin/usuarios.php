<?php
    require_once('controllers/users_controller.php');
    $usuarios = selectAllUsers();
    if (empty($usuarios)) {
        $usuarios = [];
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
                            <h6 class="m-0 font-weight-bold text-primary">Usuarios</h6>
                            <i class="fas fa-plus-circle fa-2x text-success" data-toggle="modal" style="cursor: pointer" data-target="#insertar"></i>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="miTabla" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Apellidos</th>
                                            <th class="d-none d-lg-table-cell">Correo</th>
                                            <th>DNI</th>
                                            <th>Sexo</th>
                                            <th>Domicilio</th>
                                            <th class="d-none d-lg-table-cell">Fecha Nacimiento</th>
                                            <th>Admin</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($usuarios as $usuario): ?>
                                        <tr>
                                            <td><?= $usuario['Nombre'] ?></td>
                                            <td><?= $usuario['Apellidos'] ?></td>
                                            <td class="d-none d-lg-table-cell"><?= $usuario['Correo'] ?></td>
                                            <td><?= $usuario['DNI'] ?></td>
                                            <td><?= $usuario['Sexo'] ?></td>
                                            <td><?= $usuario['Domicilio'] ?></td>
                                            <td class="d-none d-lg-table-cell"><?= date('d/m/Y', strtotime($usuario['FNacimiento'])) ?></td>
                                            <td class="col-1"><?= $usuario['Admin'] == 0 ? "No" : "Si"; ?></td>
                                            <td class="col-1 text-center align-middle">
                                                <i class="fas fa-trash fa-sm mr-2" data-toggle="modal" style="cursor: pointer" data-target="#eliminar<?= $usuario['IdUsuario'] ?>"></i>
                                                <i class="fas fa-edit fa-sm" data-toggle="modal" style="cursor: pointer" data-target="#actualizar<?= $usuario['IdUsuario'] ?>"></i>
                                                <div class="modal fade" id="eliminar<?= $usuario['IdUsuario'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Listo para eliminarlo?</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">Seleccionar "Eliminar" si quieres eliminar el usuario actual.</div>
                                                        <div id="error-message2" class="alert alert-danger" style="display: none;"></div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                                                <form id="deleteForm">
                                                                    <input type="hidden" id="idUser" value="<?= $usuario['IdUsuario'] ?>"/>
                                                                    <button class="btn btn-primary" type="submit">Eliminar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="actualizar<?= $usuario['IdUsuario'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    
                                                        <!-- Encabezado del modal -->
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Actualizar Usuario</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="$('#updateForm')[0].reset(); $('[id$=\'-error\']').hide();$('.is-invalid').removeClass('is-invalid');">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <form id="updateForm">
                                                            <div class="modal-body">
                                                                <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                                                                <input type="hidden" class="form-control" value="<?= $usuario['IdUsuario'] ?>" name="id1" id="id1">
                                                                <div class="form-group">
                                                                    <label for="nombre">Nombre</label>
                                                                    <input type="text" class="form-control" value="<?= $usuario['Nombre'] ?>" name="nombre" id="nombre">
                                                                    <div class="invalid-feedback" style="display: none;" id="nombre-error">
                                                                        El nombre es inválido o demasiado largo (máx. 100 caracteres).
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="apellidos">Apellidos</label>
                                                                    <input type="text" class="form-control" name="apellidos" value="<?= $usuario['Apellidos'] ?>" id="apellidos">
                                                                    <div class="invalid-feedback" style="display: none;" id="apellidos-error">
                                                                        Los apellidos son inválidos o demasiado largos (máx. 100 caracteres).
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="correo">Correo</label>
                                                                    <input type="text" class="form-control" value="<?= $usuario['Correo'] ?>" name="correo" id="correo">
                                                                    <div class="invalid-feedback" style="display: none;" id="correo-error">
                                                                        El correo está mal introducido (ejemplo@gmail.com).
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="passwd">Contraseña</label>
                                                                    <input type="password" class="form-control" name="passwd" id="passwd">
                                                                    <div class="invalid-feedback" style="display: none;" id="passwd-error">
                                                                        La contraseña esta mal introducida.
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="dni">DNI</label>
                                                                    <input type="dni" class="form-control" value="<?= $usuario['DNI'] ?>" name="dni" id="dni">
                                                                    <div class="invalid-feedback" style="display: none;" id="dni-error">
                                                                        El DNI está mal introducido (99999999J)
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="sexo">Sexo</label>
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
                                                                <div class="form-group">
                                                                    <label for="domicilio">Domicilio</label>
                                                                    <input type="domicilio" class="form-control" value="<?= $usuario['Domicilio'] ?>" name="domicilio" id="domicilio">
                                                                    <div class="invalid-feedback" style="display: none;" id="domicilio-error">
                                                                        El domicilio está mal introducido (máx. 50 caracteres).
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="nacimiento">Fecha Nacimiento</label>
                                                                    <input type="date" class="form-control" name="nacimiento" value="<?= $usuario['FNacimiento'] ?>" id="nacimiento">
                                                                    <div class="invalid-feedback" style="display: none;" id="nacimiento-error">
                                                                        Introduce la fecha de nacimiento.
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="admin">Admin</label>
                                                                    <input type="checkbox" class="form-control" name="admin" id="admin" <?= $usuario['Admin'] ? 'checked' : '' ?>>
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
                <h5 class="modal-title" id="exampleModalLabel">Insertar Usuario</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="$('#insertForm')[0].reset(); $('[id$=\'-error1\']').hide();$('.is-invalid').removeClass('is-invalid');">
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
                        <label for="apellidos">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos" id="apellidos1">
                        <div class="invalid-feedback" style="display: none;" id="apellidos-error1">
                            Los apellidos son inválidos o demasiado largos (máx. 100 caracteres).
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="text" class="form-control" name="correo" id="correo1">
                        <div class="invalid-feedback" style="display: none;" id="correo-error1">
                            El correo está mal introducido (ejemplo@gmail.com).
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="passwd">Contraseña</label>
                        <input type="password" class="form-control" name="passwd" id="passwd1">
                        <div class="invalid-feedback" style="display: none;" id="passwd-error1">
                            La contraseña esta mal introducida.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dni">DNI</label>
                        <input type="dni" class="form-control" name="dni" id="dni1">
                        <div class="invalid-feedback" style="display: none;" id="dni-error1">
                            El DNI está mal introducido (99999999J)
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sexo">Sexo</label>
                        <select class="form-control" id="sexo1" name="sexo">
                            <option value="hombre">Hombre</option>
                            <option value="mujer">Mujer</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="domicilio">Domicilio</label>
                        <input type="text" class="form-control" name="domicilio" id="domicilio1">
                        <div class="invalid-feedback" style="display: none;" id="domicilio-error1">
                            El domicilio está mal introducido.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nacimiento">Fecha Nacimiento</label>
                        <input type="date" class="form-control" name="nacimiento" id="nacimiento1">
                        <div class="invalid-feedback" style="display: none;" id="nacimiento-error1">
                            Introduce la fecha de nacimiento.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="admin">Admin</label>
                        <input type="checkbox" class="form-control" name="admin" id="admin1">
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
        $(document).ready(function() {
            $(document).on("submit", "#insertForm", function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente
            let error = 0;

            const nombre = $(this).find("#nombre1").val().trim();
            const apellidos = $(this).find("#apellidos1").val().trim();
            const correo = $(this).find("#correo1").val().trim();
            const contraseña = $(this).find("#passwd1").val().trim();
            const dni = $(this).find("#dni1").val().trim();
            const sexo = $(this).find("#sexo1").val().trim();
            const domicilio = $(this).find("#domicilio1").val().trim();
            const fnac = $(this).find("#nacimiento1").val().trim();
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

            if(admin){
                admin = 1;
            }else{
                admin = 0;
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
                        nacimiento : fnac,
                        insertar : 1
                    },
                    success: function(response) {
                        if (response == true) {
                            window.location.href = "/Proyecto/admin/usuarios";
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

            const id = $(this).find("#idUser").val();

            $.ajax({
                url: '/Proyecto/userController',
                type: 'POST',
                data: {
                    id : id,
                    eliminar : 1
                },
                success: function(response) {
                    window.location.href = "/Proyecto/admin/usuarios";
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
            const nombre = $(this).find("#nombre").val().trim();
            const apellidos = $(this).find("#apellidos").val().trim();
            const correo = $(this).find("#correo").val().trim();
            const contraseña = $(this).find("#passwd").val().trim();
            const dni = $(this).find("#dni").val().trim();
            const sexo = $(this).find("#sexo").val().trim();
            const domicilio = $(this).find("#domicilio").val().trim();
            const fnac = $(this).find("#nacimiento").val().trim();
            let admin = $(this).find("#admin").is(":checked");

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

            if(admin){
                admin = 1;
            }else{
                admin = 0;
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
                            window.location.href = "/Proyecto/admin/usuarios";
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