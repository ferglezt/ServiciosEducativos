<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	 <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="{{ URL::to('/') }}/css/bootstrap.css">
	<link rel="stylesheet" href="{{ URL::to('/') }}/css/customnav.css">
	<script src="{{ URL::to('/') }}/js/jquery.js"></script>
	<script src="{{ URL::to('/') }}/js/bootstrap.js"></script> 
</head>
<body>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#menu-toggle").click(function(e) {
		        e.preventDefault();
		        $("#wrapper").toggleClass("active");
	    	});

	    	$(".sidebar-element-toggle").click(function(e) {
	    		e.preventDefault();
	    		$(".sidebar-element-toggle").removeClass("active");
	    		$(this).addClass("active");
	    		//$("#wrapper").toggleClass("active");
	    	});

		});
	</script>

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
	    				<a href="#">IPN - UPIICSA</a>
	                </div>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="#">Home</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</nav>
	    <!-- Sidebar -->
	    <div id="sidebar-wrapper">
	        @yield('sidebar')
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