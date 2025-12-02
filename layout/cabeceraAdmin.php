<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/Proyecto/admin">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Admin Rolva</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="/Proyecto/admin">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Inicio</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Operaciones
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Base de Datos</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Copias de Seguridad</h6>
                    <a class="collapse-item" onclick="backup()">Exportar</a>
                    <a class="collapse-item" onclick="backup_import()">Importar</a>
                    <!-- <a class="collapse-item" href="/Proyecto/admin?createDB">Crear BD</a>
                    <a class="collapse-item" href="/Proyecto/admin?deleteDB">Borrar BD</a> -->
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Datos
        </div>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Tablas</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Datos</h6>
                    <a class="collapse-item" style="color: black;" href="/Proyecto/admin/habitaciones">Habitaciones</a>
                    <a class="collapse-item" style="color: black;" href="/Proyecto/admin/hoteles">Hoteles</a>
                    <a class="collapse-item" style="color: black;" href="/Proyecto/admin/localidades">Localidades</a>
                    <a class="collapse-item" style="color: black;" href="/Proyecto/admin/usuarios">Usuarios</a>
                    <a class="collapse-item" style="color: black;" href="/Proyecto/admin/codigos">Códigos Promocionales</a>
                    <a class="collapse-item" style="color: black;" href="/Proyecto/admin/camas">Camas</a>
                    <a class="collapse-item" style="color: black;" href="/Proyecto/admin/complementos">Complementos</a>
                    <a class="collapse-item" style="color: black;" href="/Proyecto/admin/facturas">Facturas</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities1"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Conexiones</span>
            </a>
            <div id="collapseUtilities1" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Datos</h6>
                    <a class="collapse-item" style="color: black;" href="/Proyecto/admin/aplicarCodProm">Aplicar Cod Promocional</a>
                    <a class="collapse-item" style="color: black;" href="/Proyecto/admin/aplicarCama">Aplicar Cama</a>
                    <a class="collapse-item" style="color: black;" href="/Proyecto/admin/aplicarComplemento">Aplicar Complemento</a>
                </div>
            </div>
        </li>

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
<script>
    function backup(){
        $.ajax({
            url: '/Proyecto/backupController',
            type: 'POST',
            data: {
                backup: 1
            },
            success: function(response) {
                if (response == "SUCCESS") {
                    alert("Copia de seguridad realizada con exito");
                } else {
                    console.log(response);
                }
            },
            error: function() {
                alert(1);
            }
        });
    }
    function backup_import(){
        $.ajax({
            url: '/Proyecto/backupController',
            type: 'POST',
            data: {
                import:1
            },
            success: function(response) {
                if (response == "SUCCESS") {
                    alert("Importación realizada con exito");
                    window.location.href = "/Proyecto/admin";
                } else {
                    console.log(response);
                }
            },
            error: function() {
                alert(1);
            }
        });
    }
</script>