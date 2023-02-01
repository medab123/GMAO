@extends('layouts.app')

@section('content')
    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('demandes.addTechnicien', $demande->id) }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter un technicien</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <select class="form-select" aria-label="Default select example" name="technicien_id">
                            <option selected>choisire un Technicien</option>
                            @foreach ($techniciens as $technicien)
                                <option value="{{ $technicien->user->id }}">{{ $technicien->user->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="suiviModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Suivi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('suivis.newStore', ['id' => $demande->id]) }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="" class="form-label" >Etat</label>
                            <select type="text" class="form-control" name="status">
                                <option value="1" selected>Suivi</option>
                                <option value="2" {{ $demande->status == 2 ? 'selected' : '' }}>Resolu</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Message</label>
                            <textarea class="form-control" id="" rows="3" name="message" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="card col-md-12 col-sm-12">
                <div class="card-header p-1">
                    <H4>- Demandeur <H4>
                </div>
                <div class="card-body custom-scrollbar p-0">
                    <div class="table-responsive-sm p-0 m-0" style=" max-height: 60vh;">
                        <table class="table table-striped table-hover table-sm  ">
                            <thead class="sbg-light">
                                <tr style="background-color: #FDFFFF">
                                    <th>#</th>
                                    <th>name</th>
                                    <th>email </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $demandeur->id }}</td>
                                    <td>{{ $demandeur->name }}</td>
                                    <td>{{ $demandeur->email }}</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="card col-md-12 col-sm-12">
                <div class="card-header p-0">
                    <H4>- Demande info<H4>
                </div>
                <div class="card-body custom-scrollbar p-0">
                    <div class="table-responsive-sm " style=" max-height: 60vh;">
                        <table class="table table-striped table-hover table-sm  ">
                            <thead class="sbg-light">
                                <tr style="background-color: #FDFFFF">
                                    <th>#</th>
                                    <th>Machine</th>
                                    <th>Intervontion Niveau</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $demande->id }}</td>
                                    <td>{{ $demande->machine->name }}</td>
                                    <td>{{ $demande->niveau->name }}</td>
                                    <td>{{ $demande->description }}</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="card col-md-12 col-sm-12">
                <div class="card-header p-0">
                    <H4>- Technicien info<H4>
                </div>
                <div class="card-body custom-scrollbar p-0">
                    <div class="table-responsive-sm " style=" max-height: 60vh;">
                        <table class="table table-striped table-hover table-sm  ">
                            <thead class="sbg-light">
                                <tr style="background-color: #FDFFFF">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Technicien Niveau</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($demande->techniciens as $technicien)
                                    <tr>
                                        <td>{{ $technicien->id }}</td>
                                        <td>{{ $technicien->name }}</td>
                                        <td>{{ $modelTechnicien::where('user_id', $technicien->id)->with('niveau')->first()->niveau->name }}
                                        </td>
                                        <td><button title="Supprimer"
                                                onclick="deleteDemande('{{ $demande->id }}','{{ $technicien->id }}',this)"
                                                class="btn  btn-sm p-0"><span style="color: rgb(213, 9, 23);"><i
                                                        class="fa fa-trash" aria-hidden="true"></i></span></button> </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <button class="btn btn-sm float-right text-success" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"><span class="fa-stack fa-1x" style="flex-shrink: 0;"><i
                                    class="fas fa-square fa-stack-2x"></i> <i
                                    class="far fa-plus fa-stack-1x fa-inverse"></i></span></button>
                    </div>
                </div>
            </div>

        </div>
        <div class=" col-8">
            <div class="card">
                <div class="card-header px-0">
                    <h4 class="float-left">Suivi</h4>
                    @if ($demande->status < 2)
                        <button class="btn btn-sm btn-success float-right" data-bs-toggle="modal"
                            data-bs-target="#suiviModal">Ajouter</button>
                    @else 
                    <button class="btn btn-sm btn-danger float-right disabled" disabled>Closed</button>
                    @endif

                </div>
                <div class="card-body bg-white " style="min-height:60vh;">
                    @foreach ($suivis as $suivi)
                        @if ($suivi->sender_id == $demande->demandeur_id)
                            <div class="row text-right bg-light p-2  rounded">
                                <strong>{{ $suivi->message }}</strong><br><small>{{ $suivi->created_at }}</small>
                            </div>
                            <br>
                        @else
                            <div class=" row text-left bg-primary p-2  rounded">
                                <strong class="text-light">{{ $suivi->message }}</strong><br><small class="text-light">{{ $suivi->created_at }}</small>
                            </div><br>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        const deleteDemande = (id, tech_id) => {
            $.confirm({
                title: 'Confirmer la suppression!',
                content: 'Confirmer la suppression d\'un technicien !',
                buttons: {
                    confirm: function() {
                        $('html').preloader({
                            text: 'Loading ..',
                        });
                        $('html').preloader({
                            text: 'Loading ..',
                            zIndex: '1056',
                        });
                        $.ajax({
                            url: "{{ url('/demandes/techniciens') }}/" + id,
                            data: {
                                "technicien_id": tech_id
                            },
                            method: "DELETE",
                            success: function(data) {
                                $('html').preloader('remove');
                                location.reload();
                            },
                            error: function(e) {

                            }
                        })
                    },
                    cancel: function() {

                    },
                }
            });
        }
    </script>
@endsection
