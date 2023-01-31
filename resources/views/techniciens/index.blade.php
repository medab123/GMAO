@extends('layouts.app')
@section('content')
    <div class="modal fade" id="modalTechnicien" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTechnicien">
                        <div class="row ">

                            <div class="col-md-5 col-sm-6 col-xm-12  ">
                                <div class="form-group">
                                    <select type="text" class="sous_affectation form-control form-control-sm"
                                        placeholder="Nom de la machine" name="user_id" required>
                                        <option value="">Choisir un utilisateur</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id}}">{{ $user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-6 col-xm-12  ">
                                <div class="form-group">
                                    <select type="text" class="sous_affectation form-control form-control-sm"
                                        placeholder="Nom de la machine" name="niveau_intervontion_id" required>
                                        <option value="">Choisir le role de technicien</option>
                                        @foreach($niveaus as $niveau)
                                        <option value="{{ $niveau->id}}">{{ $niveau->name}}</option>
                                        @endforeach
                                    </select>
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
                    <h5 class="py-2"> Techniciens</h5>
                    <button onclick="openModalTechnicienAjouter()" class="btn btn-success btn-sm float-end">Ajouter un nouveau
                        Techniciens</button>
                </div>
                <div class="card-body custom-scrollbar">
                    <div class="table-responsive-sm" style="overflow-x: scroll; max-height: 60vh;">
                        <table class="table table-striped table-hover table-sm  ">
                            <thead class="sbg-light">
                                <tr style="background-color: #FDFFFF">
                                    <th>#</th>
                                    <th></th>
                                    <th>Nom</th>
                                    <th>Niveau</th>
                                </tr>
                            </thead>
                            @include('techniciens.table')
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        var modalTechnicien = $("#modalTechnicien");
        var Technicien_id = null;
        var modalTechnicienAction = "Ajouter"

        async function openModalTechnicienModifier(id) {
            $('html').preloader({
                text: 'Loading ..',
            });
            Technicien_id = id;
            modalTechnicienAction = "Modifier"
            $("#modalButtonSupmit").html(modalTechnicienAction)
            var data = await getInvInfo(id);
            $('select[name="niveau_intervontion_id"]').val(data.niveau_intervontion_id)
            $('select[name="user_id"]').val(data.user_id)
            $('html').preloader('remove');
            modalTechnicien.modal("show");
        }
        const openModalTechnicienAjouter = () => {
            modalTechnicienAction = "Ajouter"
            $("#formTechnicien").trigger("reset");
            modalTechnicien.modal("show");
        }
        async function getInvInfo(id) {
            var res = await $.get("/technciens/" + id + "/edit");
            return res.data;
        }
        $("#formTechnicien").submit(function(e) {
            e.preventDefault()
            if (modalTechnicienAction == "Ajouter") {
                ajouterTechnicien()
            } else {
                modifierTechnicien()
            }
        })
        const ajouterTechnicien = () => {
            $('html').preloader({
                text: 'Loading ..',
                zIndex: '1056',
            });
            var data = new FormData(document.getElementById("formTechnicien"))
            $.ajax({
                url: "{{ route('technciens.store') }}",
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
                    modalTechnicien.modal("hide")
                    reloadTable()
                },
                error: function(e) {

                }
            })
        }
        const modifierTechnicien = () => {
            $('html').preloader({
                text: 'Loading ..',
                zIndex: '1056',
            });
            var data = new FormData(document.getElementById("formTechnicien"))
            $.ajax({
                url: "{{ url('/technciens') }}/" + Technicien_id,
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
                    modalTechnicien.modal("hide")
                    reloadTable()
                },
                error: function(e) {

                }
            })
        }
        const deleteTechnicien = (id) => {
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
                            url: "{{ url('/technciens') }}/" + id,
                            method: "DELETE",
                            success: function(data) {
                                $('html').preloader('remove');
                                modalTechnicien.modal("hide")
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
            $.get("{{ route('technciens.refreshTable') }}", (data) => {
                $("tbody").remove()
                $("table").append(data)
                $('html').preloader('remove');
            })
        }
    </script>
@endsection
