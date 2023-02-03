@extends('layouts.app')
@section('content')
    <div class="modal fade" id="modalTypeInter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTypeInter">
                        <div class="row ">

                            <div class="col-md-5 col-sm-6 col-xm-12  ">
                                <div class="form-group">
                                    <input type="text" class="sous_affectation form-control form-control-sm"
                                        placeholder="Nom de type" name="name">
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
                    <h5 class="py-2"> Type Intervontion</h5>
                    @can('resource-create')
                    <button onclick="openModalTypeInterAjouter()" class="btn btn-success btn-sm float-end">Ajouter un nouveau
                        Type Intervontion</button>
                        @endcan
                </div>
                <div class="card-body custom-scrollbar">
                    <div class="table-responsive-sm" style="overflow-x: scroll; max-height: 60vh;">
                        <table class="table table-striped table-hover table-sm  ">
                            <thead class="sbg-light">
                                <tr style="background-color: #FDFFFF">
                                    <th>#</th>
                                    <th>Actions</th>
                                    <th>Nom</th>
                                </tr>
                            </thead>
                            @include('typeIntervontion.table')
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        var modalTypeInter = $("#modalTypeInter");
        var TypeInter_id = null;
        var modalTypeInterAction = "Ajouter"

        async function openModalTypeInterModifier(id) {
            $('html').preloader({
                text: 'Loading ..',
            });
            TypeInter_id = id;
            modalTypeInterAction = "Modifier"
            $("#modalButtonSupmit").html(modalTypeInterAction)
            var data = await getInvInfo(id);
            $('input[name="name"]').val(data.name)
            $('input[name="description"]').val(data.description)
            $('html').preloader('remove');
            modalTypeInter.modal("show");
        }
        const openModalTypeInterAjouter = () => {
            modalTypeInterAction = "Ajouter"
            $("#formTypeInter").trigger("reset");
            modalTypeInter.modal("show");
        }
        async function getInvInfo(id) {
            var res = await $.get("/typeIntervontions/" + id + "/edit");
            return res.data;
        }
        $("#formTypeInter").submit(function(e) {
            e.preventDefault()
            if (modalTypeInterAction == "Ajouter") {
                ajouterTypeInter()
            } else {
                modifierTypeInter()
            }
        })
        const ajouterTypeInter = () => {
            $('html').preloader({
                text: 'Loading ..',
                zIndex: '1056',
            });
            var data = new FormData(document.getElementById("formTypeInter"))
            $.ajax({
                url: "{{ route('typeIntervontions.store') }}",
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
                    modalTypeInter.modal("hide")
                    reloadTable()
                },
                error: function(e) {

                }
            })
        }
        const modifierTypeInter = () => {
            $('html').preloader({
                text: 'Loading ..',
                zIndex: '1056',
            });
            var data = new FormData(document.getElementById("formTypeInter"))
            $.ajax({
                url: "{{ url('/typeIntervontions') }}/" + TypeInter_id,
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
                    modalTypeInter.modal("hide")
                    reloadTable()
                },
                error: function(e) {

                }
            })
        }
        const deleteTypeInter = (id) => {
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
                            url: "{{ url('/typeIntervontions') }}/" + id,
                            method: "DELETE",
                            success: function(data) {
                                $('html').preloader('remove');
                                modalTypeInter.modal("hide")
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
            $.get("{{ route('typeIntervontions.refreshTable') }}", (data) => {
                $("tbody").remove()
                $("table").append(data)
                $('html').preloader('remove');
            })
        }
    </script>
@endsection
