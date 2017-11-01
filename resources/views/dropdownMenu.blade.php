<ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <span class="glyphicon glyphicon-user"></span> 
            {{ Session::get('nombre', 'USUARIO') }}
            <span class="caret"></span> 
        </a>

        <ul class="dropdown-menu">
            <li><a href="{{ URL::to('/cambioContrasena') }}">Cambiar Contraseña</a></li>
            <li><a href="{{ URL::to('/cerrarSesion') }}">Cerrar Sesión</a></li>   
        </ul>

    </li>
</ul>