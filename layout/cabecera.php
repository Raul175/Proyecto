<div class="container-fluid bg-dark px-0">
    <div class="row gx-0">
        <div class="col-lg-2 bg-dark d-none d-lg-block">
            <a href="/Proyecto/" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                <img style="height: 120px" src="images/logo.png" alt="">
            </a>
        </div>
        <div class="col-lg-10">
            <div class="row gx-0 bg-white d-none d-lg-flex">
                <div class="col-lg-7 px-5 text-start">
                    <div class="h-100 d-inline-flex align-items-center py-2 me-4">
                        <i id="persona" class="fa fa-envelope text-primary me-2"></i>
                        <p class="mb-0">rolva@rolvahotels.com</p>
                    </div>
                    <div class="h-100 d-inline-flex align-items-center py-2">
                        <i id="persona" class="fa fa-phone-alt text-primary me-2"></i>
                        <p class="mb-0">+34 654242424</p>
                    </div>
                </div>
                <div class="col-lg-5 px-5 text-end">
                    <div class="d-inline-flex align-items-center py-2">
                        <a class="me-3" href=""><i id="persona" class="fab fa-facebook-f text-primary"></i></a>
                        <a class="me-3" href=""><i id="persona" class="fab fa-twitter text-primary"></i></a>
                        <a class="me-3" href=""><i id="persona" class="fab fa-linkedin-in text-primary"></i></a>
                        <a class="me-3" href=""><i id="persona" class="fab fa-instagram text-primary"></i></a>
                        <a class="" href=""><i id="persona" class="fab fa-youtube text-primary"></i></a>
                    </div>
                </div>
            </div>
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0">
                <a href="/Proyecto/" class="navbar-brand d-block d-lg-none">
                    <img style="height: 100px" src="images/logo.png" alt="">
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav me-auto">
                        <a href="/Proyecto/" class="nav-item nav-link">Inicio</a>
                        <a href="/Proyecto/sobre" class="nav-item nav-link">Sobre Nosotros</a>
                        <a href="/Proyecto/servicio" class="nav-item nav-link">Servicios</a>
                        <a href="/Proyecto/habitaciones" class="nav-item nav-link">Habitaciones</a>
                        <a href="/Proyecto/contacto" class="nav-item nav-link">Contacto</a>
                    </div>

                    <?php if(isset($_SESSION['usuario'])) { ?>
                        <div class="dropdown d-lg-none pe-3">
                            <a class="nav-link dropdown-toggle" href="#" role="button" id="userDropdownMobile" data-bs-toggle="dropdown" aria-expanded="false">
                                <i id="nopersona" class="fas fa-user-circle fa-2x"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="userDropdownMobile">
                                <li><a class="dropdown-item" href="/Proyecto/user">Ver Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/Proyecto?cerrarSesion">Cerrar Sesión</a></li>
                            </ul>
                        </div>

                        <div class="dropdown d-none d-lg-block pe-3">
                            <a class="nav-link dropdown-toggle" href="#" role="button" id="userDropdownPC" data-bs-toggle="dropdown" aria-expanded="false">
                                <i id="nopersona" class="fas fa-user-circle fa-2x"></i>
                            </a>
                            <ul class="dropdown-menu" style="transform: translateX(-50%);" aria-labelledby="userDropdownPC">
                                <li><a class="dropdown-item" href="/Proyecto/user">Ver Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/Proyecto?cerrarSesion">Cerrar Sesión</a></li>
                            </ul>
                        </div>
                    <?php } else { ?>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#InicioSesionModal" id="IniciarSesion" style="margin-right: 20px;" class="btn btn-personalizado">
                        Iniciar Sesión <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    <?php } ?>
                </div>
            </nav>
        </div>
    </div>
</div>
<div class="modal fade" id="InicioSesionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Iniciar Sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                <form id="loginForm" action="../index.php" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Correo electrónico</label>
                        <input type="text" class="form-control" id="correo" aria-describedby="emailHelp">
                        <div class="invalid-feedback" style="display: none;" id="correo6-error">
                            Correo electrónico mal introducido
                        </div>
                        
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password">
                        <div class="invalid-feedback" style="display: none;" id="password-error">
                            Contraseña mal introducida
                        </div>
                    </div>
                    <button type="submit" class="btn btn-personalizado2">Iniciar Sesión</button>
                    <a href="#" onclick="$('#loginForm')[0].reset(); $('[id$=\'-error\']').hide();$('.is-invalid').removeClass('is-invalid');" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registroModal">No tienes una cuenta registrada?</a>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrarse</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="error-message1" class="alert alert-danger" style="display: none;"></div>
                <form id="registerForm" action="../index.php" method="post">
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
                        <input type="domicilio" class="form-control" name="domicilio" id="domicilio1">
                        <div class="invalid-feedback" style="display: none;" id="domicilio-error1">
                            El domicilio está mal introducido.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nacimiento">Fecha Nacimiento</label>
                        <input type="date" class="form-control" name="nacimiento" value="<?= $usuario['FNacimiento'] ?>" id="nacimiento1">
                        <div class="invalid-feedback" style="display: none;" id="nacimiento-error">
                            Introduce la fecha de nacimiento.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-personalizado2">Registrarse</button>
                    <a href="#" data-bs-dismiss="modal" onclick="$('#registerForm')[0].reset(); $('[id$=\'-error\']').hide();$('.is-invalid').removeClass('is-invalid');" data-bs-toggle="modal" data-bs-target="#InicioSesionModal">Ya tienes una cuenta registrada?</a>
                </form>
            </div>
        </div>
    </div>
</div>
