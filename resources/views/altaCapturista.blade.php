@extends('dashboard')

@section('title', 'Alta Capturista')

@section('content')

	<script type="text/javascript">
		$('#item-alta-capturista').addClass('active');
		$('#item-alta-capturista').click(function(e) {
			e.preventDefault();
		});
	</script>

    <div class="jumbotron text-center">
        <h1>Alta capturista</h1>
        <p>Sistema de administración del departamento de extensión y apoyos educativos</p> 
    </div>

	{{--<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">                    
                <div class="panel panel-success">
                    <div class="panel-heading">
                            Info
                    </div>
                    <div class="panel-body">
                        Content
                    </div>
                </div>
            </div>
        </div>
    </div>--}}

@stop
