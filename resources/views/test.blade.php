@extends('layouts.master')

@section('title', 'Page Title')

@section('sidebar')

	<nav id="spy">
	    <ul class="sidebar-nav nav">
	        <li class="sidebar-brand">
	            <a href="#logo"><img style="max-width: 50%;" src="{{ URL::to('/') }}/images/upiicsa_logo.png"></a>
	        </li>
	        <li class="sidebar-element-toggle">
	            <a href="#anch1">
	                <span class="fa fa-anchor solo">Anchor 1</span>
	            </a>
	        </li>
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
	    </ul>
	</nav>

@stop

@section('content')

	<div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                            Panel 1
                    </div>
                    <div class="panel-body">
                        content body
                    </div>
                </div>
            </div>
            <div class="col-md-6">                    
                <div class="panel panel-success">
                    <div class="panel-heading">
                            Panel 1
                    </div>
                    <div class="panel-body">
                        content body LOL
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop