@extends('layouts.app')
@section('content')
    <div class="modal fade" id="modalNiveauIntervontion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formNiveauIntervontion">
                        <div class="row ">

                            <div class="col-md-5 col-sm-6 col-xm-12  ">
                                <div class="form-group">
                                    <input type="text" class="sous_affectation form-control form-control-sm"
                                        placeholder="Nom du Niveau" name="name">
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-6 col-xm-12  ">
                                <div class="form-group">
                                    <input type="text" class="sous_affectation form-control form-control-sm"
                                        placeholder="Description" name="description">
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
                    <h5 class="py-2"> Niveau d'Intervontions</h5>
                    @can('resource-create')
                        <button onclick="openModalNiveauIntervontionAjouter()" class="btn btn-success btn-sm float-end">Ajouter
                            un nouveau
                            Niveau d'ntervontions</button>
                    @endcan
                </div>
                <div class="card-body custom-scrollbar">
                    <div class="table-responsive-sm" style="overflow-x: scroll; max-height: 60vh;">
                        <table class="table table-striped table-hover table-sm  ">
                            <thead class="sbg-light">
                                <tr style="background-color: #FDFFFF">
                                    <th>#</th>
                                    <th></th>
                                    <th>Nom</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            @include('NiveauIntervontions.table')
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        var modalNiveauIntervontion = $("#modalNiveauIntervontion");
        var NiveauIntervontion_id = null;
        var modalNiveauIntervontionAction = "Ajouter"

        async function openModalNiveauIntervontionModifier(id) {
            $('html').preloader({
                text: 'Loading ..',
            });
            NiveauIntervontion_id = id;
            modalNiveauIntervontionAction = "Modifier"
            $("#modalButtonSupmit").html(modalNiveauIntervontionAction)
            var data = await getInvInfo(id);
            $('input[name="name"]').val(data.name)
            $('input[name="description"]').val(data.description)
            $('html').preloader('remove');
            modalNiveauIntervontion.modal("show");
        }
        const openModalNiveauIntervontionAjouter = () => {
            modalNiveauIntervontionAction = "Ajouter"
            $("#formNiveauIntervontion").trigger("reset");
            modalNiveauIntervontion.modal("show");
        }
        async function getInvInfo(id) {
            var res = await $.get("/niveauIntervontions/" + id + "/edit");
            return res.data;
        }
        $("#formNiveauIntervontion").submit(function(e) {
            e.preventDefault()
            if (modalNiveauIntervontionAction == "Ajouter") {
                ajouterNiveauIntervontion()
            } else {
                modifierNiveauIntervontion()
            }
        })
        const ajouterNiveauIntervontion = () => {
            $('html').preloader({
                text: 'Loading ..',
                zIndex: '1056',
            });
            var data = new FormData(document.getElementById("formNiveauIntervontion"))
            $.ajax({
                url: "{{ route('niveauIntervontions.store') }}",
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
                    modalNiveauIntervontion.modal("hide")
                    reloadTable()
                },
                error: function(e) {

                }
            })
        }
        const modifierNiveauIntervontion = () => {
            $('html').preloader({
                text: 'Loading ..',
                zIndex: '1056',
            });
            var data = new FormData(document.getElementById("formNiveauIntervontion"))
            $.ajax({
                url: "{{ url('/niveauIntervontions') }}/" + NiveauIntervontion_id,
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
                    modalNiveauIntervontion.modal("hide")
                    reloadTable()
                },
                error: function(e) {

                }
            })
        }
        const deleteNiveauIntervontion = (id) => {
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
                            url: "{{ url('/niveauIntervontions') }}/" + id,
                            method: "DELETE",
                            success: function(data) {
                                $('html').preloader('remove');
                                modalNiveauIntervontion.modal("hide")
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
            $.get("{{ route('niveauIntervontions.refreshTable') }}", (data) => {
                $("tbody").remove()
                $("table").append(data)
                $('html').preloader('remove');
            })
        }
    </script>
@endsection
