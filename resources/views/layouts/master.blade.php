<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	 <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="{{ URL::to('/') }}/css/bootstrap.css">
	<link rel="stylesheet" href="{{ URL::to('/') }}/css/customnav.css">
	<link rel="stylesheet" href="{{ URL::to('/') }}/css/datatables.css">

	<script src="{{ URL::to('/') }}/js/jquery.js"></script>
	<script src="{{ URL::to('/') }}/js/bootstrap.js"></script>
	<script src="{{ URL::to('/') }}/js/datatables.js"></script>
	<script src="{{ URL::to('/') }}/js/master.js"></script>

	@stack('scripts')
</head>
<body>

	<div id="wrapper">
	    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
	    			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	        			<span class="sr-only">Toggle navigation</span>
	        			<span class="icon-bar"></span>
	        			<span class="icon-bar"></span>
	        			<span class="icon-bar"></span>
	    			</button>
	                <div  class="navbar-brand">
	                    <a id="menu-toggle" href="#" class="glyphicon glyphicon-align-justify btn-menu toggle">
	                        <i class="fa fa-bars"></i>
	                    </a>
	    				<a id="nav-title" href="#">IPN - UPIICSA</a>
	                </div>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="{{ URL::to('/') }}">Inicio</a></li>
					</ul>
					@yield('dropdown')
				</div><!--/.nav-collapse -->
			</div>
		</nav>
	    <!-- Sidebar -->
	    <div id="sidebar-wrapper">
	    	<nav id="spy">
	    		<ul class="sidebar-nav nav">
			        <li class="sidebar-brand">
			            <a href="#logo"><img style="max-width: 50%;" src="{{ URL::to('/') }}/images/upiicsa_logo.png"></a>
			        </li>
	        		@yield('sidebar')
	        	</ul>
	        </nav>
	    </div>
	    <!-- Page content -->
	    <div id="page-content-wrapper">
	        <div class="page-content">
	            @yield('content')
	        </div>
	    </div>


	</div>

</body>
</html>