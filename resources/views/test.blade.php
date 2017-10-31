@extends('layouts.master')

@section('title', 'Page Title')


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