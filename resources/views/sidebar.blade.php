
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

<li class="sidebar-element-toggle">
  <a href="#anch2">
    <span class="fa fa-anchor solo">Anchor 2</span>
  </a>
</li>
<li class="sidebar-element-toggle">
  <a href="#anch3"> 
    <span class="fa fa-anchor solo">Anchor 3</span>
  </a>
</li>
<li class="sidebar-element-toggle">
  <a href="#anch4">
    <span class="fa fa-anchor solo">Anchor 4</span>
  </a>
</li>

