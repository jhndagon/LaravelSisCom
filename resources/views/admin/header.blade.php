<!-- Navbar-->
<header class="app-header"><a class="app-header__logo" href="{{ url('inicio') }}">{{ 'Comisiones' }}</a>
  <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
  <!-- Navbar Right Menu-->
  <ul class="app-nav">
    <li class="app-search">
      <div class="row">
        <div class="col text-center text-light">
          {{ config('app.name') }}
        </div>
      </div>
    </li>
  </ul>
</header>