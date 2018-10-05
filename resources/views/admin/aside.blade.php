<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user"><div>
        <p class="app-sidebar__user-name">{{ Auth::guard('profesor')->user()->nombre }}</p>
        <p class="app-sidebar__user-designation">{{ Auth::guard('profesor')->user()->tipo }}</p>
    </div>
    </div>
    <ul class="app-menu">
        <li>
        <a class="app-menu__item active" href="{{url('inicio')}}">
                <i class="app-menu__icon fa fa-home"></i>
                <span class="app-menu__label">Inicio</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item active" href=" {{ url('comision') }} ">
                <i class="app-menu__icon fa fa-edit"></i>
                <span class="app-menu__label">Crear comision</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item active" href="">
                <i class="app-menu__icon fa fa-key"></i>
                <span class="app-menu__label">Cambiar contraseña</span>
            </a>
        </li>
        <li>
        <a class="app-menu__item active" href="{{ url('logout')}}">
                <i class="app-menu__icon fa fa-sign-out"></i>
                <span class="app-menu__label">Salir</span>
            </a>
        </li>
        
    </ul>
</aside>