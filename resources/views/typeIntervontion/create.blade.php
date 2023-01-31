@extends('layouts.app')
@section('content')
<form method="post"  id="form" action="{{route('sous_affectations.store')}}">
    @csrf
    <div class="d-flex justify-content-center " style="margin-top: 10%">
        <div class="card d-flex justify-content-center" style="width: 45%; padding:2%;" >
        <div class="row d-flex justify-content-center">
          <div class="col-6">
            <label for="inputState">Affectations</label>
            <select id="inputState" class="form-control"  name="aff_id" required>
              <option value="">Choose...</option>
              @foreach($affectations as $affectation)
              <option value="{{ $affectation->id }}" >{{ $affectation->name }}</option>
              @endforeach
            </select>
          </div>
            <div class="col-6">
                <span> Sous Affectation :</span>
              <input type="text" class="form-control"  name="sous_affectation" required>
              @if ($errors->has('sous_affectations'))
                    <span class="text-danger">{{ $errors->first('sous_affectations') }}</span>
              @endif
              <div class="d-flex justify-content-center m-2">
                <button type="submit" class="btn btn-block btn-success " name="submit">Ajouter</button>
              </div>
            </div>
          </div>
      </div>
    </div>
      
</form>

@endsection