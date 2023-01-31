@extends('layouts.app')


@section('content')


    <div class="card">
        <div class="card-header ">
            <a class="btn btn-primary btn-sm d-inline" href="{{ route('roles.index') }}"> <i
                    class="fa-solid fa-arrow-left"></i></a>
            <h5 class="d-inline">Show Role</h5>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        {{ $role->name }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Permissions:</strong>
                        @if (!empty($rolePermissions))
                            @foreach ($rolePermissions as $v)
                                <label class="label label-success">{{ $v->name }},</label>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div @endsection
