
@if(Session::get('rol_id', 0) == 1) {{-- ADMIN --}}
  <li id="menu-capturistas">
    <a href="#" data-toggle="collapse" data-target="#submenu-capturistas" aria-expanded="false">
      Capturistas
      <span class="caret"></span> 
    </a>
    <ul class="nav collapse" id="submenu-capturistas" role="menu">
      <li id="item-alta-capturista">
        <a href="{{ URL::to('/altaCapturista') }}">Nuevo Capturista</a>
      </li>
      <li id="item-ver-capturistas">
        <a href="{{ URL::to('/verCapturistas') }}">Ver Capturistas</a>
      </li>
    </ul>
  </li>
@endif

<li id="menu-estudiantes">
  <a href="#" data-toggle="collapse" data-target="#submenu-estudiantes" aria-expanded="false">
    Estudiantes
    <span class="caret"></span> 
  </a>
  <ul class="nav collapse" id="submenu-estudiantes" role="menu">
    <li id="item-alta-estudiante">
      <a href="{{ URL::to('/altaEstudiante') }}">Nuevo Estudiante</a>
    </li>
    <li id="item-ver-estudiantes">
      <a href="{{ URL::to('/verEstudiantes') }}">Ver estudiantes</a>
    </li>
  </ul>
</li>

<li id="menu-becas">
  <a href="#" data-toggle="collapse" data-target="#submenu-becas" aria-expanded="false">
    Becas
    <span class="caret"></span> 
  </a>
  <ul class="nav collapse" id="submenu-becas" role="menu">
    <li id="item-alta-solicitud">
      <a href="{{ URL::to('/altaSolicitud') }}">Nueva Solicitud</a>
    </li>
    <li id="item-ver-becas">
      <a href="{{ URL::to('/verSolicitudes') }}">Ver Solicitudes</a>
    </li>
    <li id="item-estadisticas-becas">
      <a href="#">Estadísticas</a>
    </li>
  </ul>
</li>

