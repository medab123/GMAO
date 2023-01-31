@extends('layouts.app')

@section('content')
<form method="post" action="{{route('sous_affectations.update', ['sous_affectation' => $sous_affectation->id])}}">
    @csrf
    @method('PUT')
    <div class="d-flex justify-content-center " style="margin-top: 10%">

        <div class="card d-flex justify-content-center" style="width: 45%; padding:2%;" >
        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <label for="inputState">AFFECTATION</label>
                <select id="inputState" class="form-control"  name="affectation_id">
                  <option selected>Choose...</option>
                  @foreach($affectations as $affectation)
                  <option value="{{ $affectation->id }}" {{$affectation->id == $sous_affectation->affectation_id ? 'selected' : ''}} >{{ $affectation->name }}</option>
                  @endforeach
                </select>
              </div>
            <div class="col-6">
                <label>SOUS AFFECTATION :</label>
              <input type="text" class="form-control"  name="name" value="{{$sous_affectation->name}}" >
              @if ($errors->has('name'))
              <span class="text-danger">{{ $errors->first('name') }}</span>
              @endif
              <div class=" m-3">
                <button type="submit" class="btn btn-block btn-success ">MODIFIER</button>
              </div>
            </div>
          </div>
      </div>
    </div>
      
</form>

@endsection