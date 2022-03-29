<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="inicio" class="brand-link">
      <img src="vistas/img/plantilla/logo.jpg"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">CRUD Productos</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="inicio" class="nav-link">
                <i class="nav-icon fa fa-home"></i>
                <p>
                    Inicio
                </p>
                </a>
            </li>
          
            <li class="nav-item">
              <a href="productos" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  Productos
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="ventas" class="nav-link">
                <i class="nav-icon fas fa-calculator"></i>
                <p>
                  Ventas
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="reporte" class="nav-link">
                <i class="nav-icon fa fa-bars"></i>
                <p>
                  Reporte Ventas
                </p>
              </a>
            </li>
          
            <?php if($_SESSION['perfil'] == 'Administrador'): ?>
              <li class="nav-item">
                <a href="usuarios" class="nav-link">
                  <i class="fas fa-users mr-2"></i>
                  <p>
                    Usuarios
                  </p>
                </a>
              </li>
            <?php endif; ?>
            <hr>
            <li class="nav-item">
              <a href="salir" class="nav-link">
                <img src="vistas/img/plantilla/salir.png" width="30" height="30">
                <p>
                  Salir
                </p>
              </a>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>