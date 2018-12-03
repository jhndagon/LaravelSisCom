<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">

    <ul class="app-menu">
        <li class="nav-item">
            <a class="app-menu__item active" href="{{url('inicio')}}">
                <i class="app-menu__icon fa fa-home"></i>
                <span class="app-menu__label">Inicio</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item active" href=" {{ url('comision') }} ">
                <i class="app-menu__icon fa fa-edit"></i>
                <span class="app-menu__label">Nueva Solicitud</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item active" href="{{ url('modificarcontrasena') }}">
                <i class="app-menu__icon fa fa-key"></i>
                <span class="app-menu__label">Modificar contraseña</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item active" href="{{ url('profesor', ['id'=> Auth::user()->cedula]) }}">
                <i class="app-menu__icon fas fa-user-edit"></i>
                <span class="app-menu__label">Información de usuario</span>
            </a>
        </li>
        @if (Session::get('jefe') == 2)
            <li>
                <a class="app-menu__item active" href="{{ url('profesores') }}">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span class="app-menu__label">Profesores y empleados</span>
                </a>
            </li>
            <li>
                <a class="app-menu__item active" href="{{ url('informes') }}">
                    <i class="far fa-chart-bar"></i>
                    <span class="app-menu__label">Informes</span>
                </a>
            </li>
        @endif

        <li>
            <a class="app-menu__item active" href="{{ url('logout')}}">
                <i class="app-menu__icon fa fa-sign-out"></i>
                <span class="app-menu__label">Salir</span>
            </a>
        </li>

    </ul>
</aside>