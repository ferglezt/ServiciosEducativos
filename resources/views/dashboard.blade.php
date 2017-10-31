@extends('layouts.master')

@section('title', 'Home')

@section('dropdown')

    @include('dropdownMenu')

@stop

@section('sidebar')

    @if(Session::get('rol_id', 0) == 1) {{-- ADMIN --}}
        @include('adminSidebar')
    
    @endif

@stop

@section('content')

    <div class="jumbotron text-center">
        <h1>Bienvenido</h1>
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
