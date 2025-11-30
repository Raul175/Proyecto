<?php
    require_once('controllers/db_controller.php');
    require_once('controllers/users_controller.php');
    require_once('controllers/hotel_controller.php');
    require_once('controllers/localidad_controller.php');

    if(isset($_GET['createDB'])){
        createDB();
    }elseif (isset($_GET['deleteDB'])) {
        deleteDB();
    }elseif (isset($_GET['cerrarSesion'])) {
        logout();
    }

    unset($_GET);

    $hoteles = selectAllHotelsLocalGerente($_SESSION['id']);
    $localidades = selectAllLocalidades();

    $datos = [];
    if (!empty($localidades)) {
        foreach ($localidades as $localidad) {
            $datos[$localidad['IdLocalidad']] = [
                'idLocalidad' => $localidad['IdLocalidad'],
                'localidad' => $localidad['Nombre'],
                'color' => '#4e6270',
                'hoteles' => []
            ];
            foreach ($hoteles as $hotel) {
                if ($hotel['idLocalidad'] == $localidad['IdLocalidad']) {
                    $datos[$localidad['IdLocalidad']]['hoteles'][] = [
                        'id' => $hotel['id'],
                        'nombre' => $hotel['nombre'],
                        'ubicacion' => $hotel['ubicacion'],
                    ];
                    $datos[$localidad['IdLocalidad']]['color'] = "#2CAFFE";
                }
            }
        }
    }
    $jsonHoteles = json_encode($datos);
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
    <link href="/Proyecto/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/Proyecto/admin/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include("layout/cabeceraGerente.php"); ?>
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

                    <!-- Topbar Search -->


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline small mostaza"><?php echo $_SESSION['usuario']; ?></span>
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
                    <div id="mapa" style="height: 800px; width: 100%"></div>
                </div>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; RolvaHotels 2025</span>
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

    <!-- Ver Hoteles Modal -->
     <div class="modal fade" tabindex="-1"  id="hotelesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Encabezado del modal -->
                <div class="modal-header">
                    <h5 class="modal-title" id="textoModalHotel"></h5>
                    <span id="idLocalidad" class="d-none"></span>
                    <a href="#" class="ml-2">
                        <i class="fas fa-plus-circle fa-2x text-success" id="ajustarHotel" data-toggle="modal" style="cursor: pointer" data-target="#insertarHotel"></i>
                    </a>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                <table class="table table-bordered p-0 m-0" id="hoteles" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Ubicación</th>
                            <th class="col-1"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Insertar Hotel Modal-->
     <div class="modal fade" id="insertarHotel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Encabezado del modal -->
                <div class="modal-header">
                    <h5 class="modal-title" id="textoInsertarHotel">Insertar Hotel</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="insertHotelForm">
                    <input type="hidden" class="form-control" name="localidad" id="localidad">
                    <div class="modal-body">
                        <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre">
                            <div class="invalid-feedback" style="display: none;" id="nombre-error">
                                El nombre es inválido o demasiado largo (máx. 100 caracteres).
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ubicacion">Ubicación</label>
                            <input type="text" class="form-control" name="ubicacion" id="ubicacion">
                            <div class="invalid-feedback" style="display: none;" id="ubicacion-error">
                                La ubicación es inválida o demasiado larga (máx. 100 caracteres).
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" onclick="$('#insertHotelForm')[0].reset(); $('[id$=\'-error1\']').hide();$('.is-invalid').removeClass('is-invalid');" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Insertar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Insertar Habitacion Modal-->
     <div class="modal fade" id="insertar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            
                <!-- Encabezado del modal -->
                <div class="modal-header">
                    <h5 class="modal-title" id="textoInsertarHabitacion">Insertar Habitación</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="insertRoomForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div id="error-message1" class="alert alert-danger" style="display: none;"></div>
                        <input type="hidden" name="idHotel" id="Hotel">
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
                        <div class="form-group" id="vipInput" style="display:none;">
                            <label for="vip">Código VIP</label>
                            <input type="text" class="form-control" id="vip" name="vip">
                            <div class="invalid-feedback" style="display: none;" id="codvip-error1">
                                El código es inválido o demasiado largo (máx. 100 caracteres).
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="img">Imagen</label>
                            <input type="file" name="img" id="img" accept="image/jpeg,image/png,image/webm">
                            <div class="invalid-feedback" style="display: none;" id="img-error1"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="$('#insertRoomForm')[0].reset(); $('[id$=\'-error1\']').hide();$('.is-invalid').removeClass('is-invalid');" type="button" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Insertar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script src="/Proyecto/js/highmaps.js"></script>
    <script src="https://code.highcharts.com/mapdata/countries/es/es-all.js"></script>

</body>
<script>
    if (window.location.search) {
        const cleanUrl = window.location.origin + window.location.pathname;
        window.history.replaceState({}, document.title, cleanUrl);
    }
    $('#tipo1').on('change', function() {
        if ($(this).val() === 'vip') {
            $('#vipInput').show();
        } else {
            $('#vipInput').hide();
        }
    });
</script>
<script>
    $(document).ready(function() {
        const hoteles = <?php echo $jsonHoteles; ?>;
        Highcharts.mapChart('mapa', {
        chart: {
            map: 'countries/es/es-all',
            backgroundColor: '#daa880',
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
            keys: ['color','hoteles','localidad','Localidad'],
            colorKey: 'color',
            events: {
                click: function (e) {
                    const localidad = e.point.idLocalidad;
                    const hoteles = e.point.hoteles;
                    if (hoteles.length > 0) {
                        $('#textoModalHotel').text(`Hoteles en ${e.point.localidad}`);
                        $('#idLocalidad').text(`${localidad}`);
                        $('#hoteles tbody').empty();
                        hoteles.forEach(hotel => {
                            $('#hoteles tbody').append(`
                                <tr>
                                    <td>${hotel.nombre}</td>
                                    <td>${hotel.ubicacion}</td>
                                    <td class="d-none">${hotel.id}</td>
                                    <td class="text-center">
                                        <a href="#">
                                            <i class="fas fa-plus-circle fa-2x text-success" data-toggle="modal" style="cursor: pointer" id="ajustarRoom" data-target="#insertarHabitacion"></i>
                                        </a>
                                    </td>
                                </tr>
                            `);
                        });
                        $('#hotelesModal').modal('show');
                    }else{
                        $('#insertHotelForm')[0].reset();
                        $('#localidad').val(localidad);
                        $('#textoInsertarHotel').text(`Insertar Hotel en ${e.point.localidad}`);
                        $('#insertarHotel').modal('show');
                    }
                    console.log(e.point.hoteles);
                }
            }
        }],
    });
});
$(document).on("click", "#ajustarHotel", function() {
    $('#insertHotelForm')[0].reset();
    const nombre = $('#textoModalHotel').text().split(' ')[2];
    const localidad = $('#idLocalidad').text();
    $('#textoInsertarHotel').text(`Insertar Hotel en ${nombre}`);
    $('#localidad').val(localidad);
});
$(document).on("click", "#ajustarRoom", function() {
    $('#insertRoomForm')[0].reset();
    const hotel = $(this).closest('tr').find('td:nth-child(3)').text();
    $('#Hotel').val(hotel);
    $('#textoInsertarHabitacion').text(`Insertar Habitación en ${hotel}`);
    $('#insertar').modal('show');
});
$(document).on("submit", "#insertHotelForm", function(event) {
    event.preventDefault(); // Evita que se envíe el form automáticamente
    let error = 0;

    const nombre =  $("#nombre").val();
    const ubicacion = $("#ubicacion").val();
    const localidad =  $("#localidad").val();

    const nombrePattern = /^[a-zA-Z0-9\s]{1,100}$/;
    if (!nombrePattern.test(nombre)) {
        $("#nombre-error").show();
        $('#nombre').addClass('is-invalid');
        error = 1;
    }else{
        $("#nombre-error").hide();
    }

    if (!nombrePattern.test(ubicacion)) {
        $(this).find("#ubicacion-error").show();
        $('#ubicacion').addClass('is-invalid');
        error = 1;
    }else{
        $(this).find("#ubicacion-error").hide();
    }

    if (error == 0) {
        $.ajax({
            url: '/Proyecto/hotelController',
            type: 'POST',
            data: {
                nombre : nombre,
                ubicacion : ubicacion,
                localidad : localidad,
                insertar : 1
            },
            success: function(response) {
                if (response) {
                    window.location.href = "/Proyecto/gerente";
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
$(document).on("submit", "#insertRoomForm", function(event) {
            event.preventDefault(); // Evita que se envíe el form automáticamente
            let error = 0;

            const nombre = $(this).find("#nombre1").val();
            const tipo = $(this).find("#tipo1").val();
            const nPersonas = $(this).find("#npersonas1").val();
            const precioUnitario = $(this).find("#precio1").val();
            const m2 = $(this).find("#m21").val();
            const hotel = $(this).find("#Hotel").val();
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

            if (!img) {
                $('#img').addClass('is-invalid');
                $(this).find("#img-error1").html("Selecciona una imagen");
                $(this).find("#img-error1").show();
                error = 1;
            }else{
                const tiposPermitidos = ['image/jpg', 'image/png', 'image/webm'];
                if (!tiposPermitidos.includes(img.type)) {
                    $('#img').addClass('is-invalid');
                    $(this).find("#img-error1").html('Tipo de archivo no permitido. Solo JPG, PNG o WEBM');
                    $(this).find("#img-error1").show();
                    error = 1;
                }else{
                    $(this).find("#img-error1").hide();
                }
                const maxSize = 5 * 1024 * 1024; // 5MB
                if (img.size > maxSize) {ç
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
                                if (response) {
                                    window.location.href = "/Proyecto/gerente";
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
</script>
</html>