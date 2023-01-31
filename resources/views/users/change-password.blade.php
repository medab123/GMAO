@extends('layouts.app')


@section('content')



    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif


    <div class="card">
        <div class="card-header ">
            <a class="btn btn-primary d-inline btn-sm" href="{{ route('users.index') }}"> <i
                    class="fa-solid fa-arrow-left"></i></a>
            <h5 class="d-inline">Create New User</h5>
        </div>
        <div class="card-body">
            {!! Form::open(['route' => 'change-password.change', 'method' => 'POST']) !!}
            <div class="row">
                
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Mot de passe:</strong>
                        {!! Form::password('password', ['placeholder' => 'Mot de passe', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nouveau mot de passe:</strong>
                        {!! Form::password('new_password', ['placeholder' => 'Nouveau mot de passe', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Confirmer le mot de passe:</strong>
                        {!! Form::password('password_confirmation', ['placeholder' => 'Confirmer le mot de passe', 'class' => 'form-control']) !!}
                    </div>
                </div>
                
                
                
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection
