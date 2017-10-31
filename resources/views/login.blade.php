@extends('layouts.master')

@section('title', 'Login')

@section('content')

  <form class="form-horizontal" action="{{ action('LoginController@attemptLogin') }}" method="post">
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-6">
        <input type="email" class="form-control" id="email" value="{{ $email or '' }}" placeholder="Email" name="email">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Password:</label>
      <div class="col-sm-6">          
        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
      </div>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Ingresar</button>
      </div>
    </div>
  </form>

  @if(isset($error))
    <div class="alert alert-danger col-md-4">
      <strong>Error:</strong> {{ $error }}
    </div>
  @endif

@stop