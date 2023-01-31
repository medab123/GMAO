@extends('layouts.app')
@section('content')
    <div class="modal fade" id="modalDemande" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formDemande">
                        <div class="row ">
                            <div class="col-md-5 col-sm-6 col-xm-12  ">
                                <div class="form-group">
                                    <select type="text" class="sous_affectation form-control form-control-sm"
                                        placeholder="Nom de machine" name="machine_id">
                                        <option value="">Choisire une machine .. </option>
                                        @foreach ($machines as $machine)
                                            <option value="{{$machine->id}}">{{$machine->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-6 col-xm-12  ">
                                <div class="form-group">
                                    <select type="text" class="sous_affectation form-control form-control-sm"
                                        placeholder="niveau intervontion " name="niveau_intervontion_id">
                                        <option value="">Choisire le niveau d'intervontion .. </option>
                                        @foreach ($niveaus as $niveau)
                                            <option value="{{$niveau->id}}">{{$niveau->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-6 col-xm-12  ">
                                <div class="form-group">
                                    <select type="text" class="sous_affectation form-control form-control-sm"
                                        placeholder="Nom de type" name="type_intervontion_id">
                                        <option value="">Choisire une type .. </option>
                                        @foreach ($typeIntervontions as $typeIntervontion)
                                            <option value="{{$typeIntervontion->id}}">{{$typeIntervontion->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-6 col-xm-12  ">
                                <div class="form-group">
                                    <textarea type="text" rows="1" class="form-control form-control-sm"
                                        placeholder="Description du probleme" name="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button id="modalButtonSupmit" type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end affectation Modal -->


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header ">
                    <h5 class="py-2"> Demandes</h5>
                    <button onclick="openModalDemandeAjouter()" class="btn btn-success btn-sm float-end">Ajouter un nouveau
                        Demandes</button>
                </div>
                <div class="card-body custom-scrollbar">
                    <div class="table-responsive-sm" style="overflow-x: scroll; max-height: 60vh;">
                        <table class="table table-striped table-hover table-sm  ">
                            <thead class="sbg-light">
                                <tr style="background-color: #FDFFFF">
                                    <th>#</th>
                                    <th>Actions</th>
                                    <th>Machine</th>
                                    <th>Type </th>
                                    <th>Niveau</th>
                                    <th>Demandeur</th>
                                    <th>Description</th>
                                    
                                </tr>
                            </thead>
                            @include('demandes.table')
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        var modalDemande = $("#modalDemande");
        var Demande_id = null;
        var modalDemandeAction = "Ajouter"

        async function openModalDemandeModifier(id) {
            $('html').preloader({
                text: 'Loading ..',
            });
            Demande_id = id;
            modalDemandeAction = "Modifier"
            $("#modalButtonSupmit").html(modalDemandeAction)
            var data = await getInvInfo(id);
            $('select[name="machine_id"]').val(data.machine_id)
            $('select[name="niveau_intervontion_id"]').val(data.niveau_intervontion_id)
            $('select[name="type_intervontion_id"]').val(data.type_intervontion_id)
            $('textarea[name="description"]').val(data.description)
            $('html').preloader('remove');
            modalDemande.modal("show");
        }
        const openModalDemandeAjouter = () => {
            modalDemandeAction = "Ajouter"
            $("#formDemande").trigger("reset");
            modalDemande.modal("show");
        }
        async function getInvInfo(id) {
            var res = await $.get("/demandes/" + id + "/edit");
            return res.data;
        }
        $("#formDemande").submit(function(e) {
            e.preventDefault()
            if (modalDemandeAction == "Ajouter") {
                ajouterDemande()
            } else {
                modifierDemande()
            }
        })
        const ajouterDemande = () => {
            $('html').preloader({
                text: 'Loading ..',
                zIndex: '1056',
            });
            var data = new FormData(document.getElementById("formDemande"))
            $.ajax({
                url: "{{ route('demandes.store') }}",
                method: "POST",
                processData: false,
                contentType: false,
                data: data,
                statusCode: {
                    422: function() {
                        $.alert('[422] error | Verifier les champs');
                        $('html').preloader('remove');
                    },
                },
                success: function(data) {
                    console.log(data)
                    $('html').preloader('remove');
                    modalDemande.modal("hide")
                    reloadTable()
                },
                error: function(e) {

                }
            })
        }
        const modifierDemande = () => {
            $('html').preloader({
                text: 'Loading ..',
                zIndex: '1056',
            });
            var data = new FormData(document.getElementById("formDemande"))
            $.ajax({
                url: "{{ url('/demandes') }}/" + Demande_id,
                method: "POST",
                processData: false,
                contentType: false,
                data: data,
                statusCode: {
                    422: function() {
                        $.alert('[422] error | Verifier les champs');
                        $('html').preloader('remove');
                    },
                },
                success: function(data) {
                    console.log(data)
                    $('html').preloader('remove');
                    modalDemande.modal("hide")
                    reloadTable()
                },
                error: function(e) {

                }
            })
        }
        const deleteDemande = (id) => {
            $.confirm({
                title: 'Confirmer la suppression!',
                content: 'Confirmer la suppression d\'un role !',
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
                            url: "{{ url('/demandes') }}/" + id,
                            method: "DELETE",
                            success: function(data) {
                                $('html').preloader('remove');
                                modalDemande.modal("hide")
                                reloadTable()
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

        const reloadTable = () => {
            $('html').preloader({
                text: 'Loading ..',
            });
            $.get("{{ route('demandes.refreshTable') }}", (data) => {
                $("tbody").remove()
                $("table").append(data)
                $('html').preloader('remove');
            })
        }
    </script>
@endsection
