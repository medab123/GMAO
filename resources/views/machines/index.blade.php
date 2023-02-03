@extends('layouts.app')
@section('content')
    <div class="modal fade" id="modalMachine" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formMachine">
                        <div class="row ">

                            <div class="col-md-5 col-sm-6 col-xm-12  ">
                                <div class="form-group">
                                    <input type="text" class="sous_affectation form-control form-control-sm"
                                        placeholder="Nom de la machine" name="name">
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
                    <h5 class="py-2"> Machine</h5>
                    @can('resource-create')
                        <button onclick="openModalMachineAjouter()" class="btn btn-success btn-sm float-end">Ajouter un nouveau
                            Machine</button>
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
                            @include('Machines.table')
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        var modalMachine = $("#modalMachine");
        var Machine_id = null;
        var modalMachineAction = "Ajouter"

        async function openModalMachineModifier(id) {
            $('html').preloader({
                text: 'Loading ..',
            });
            Machine_id = id;
            modalMachineAction = "Modifier"
            $("#modalButtonSupmit").html(modalMachineAction)
            var data = await getInvInfo(id);
            $('input[name="name"]').val(data.name)
            $('input[name="description"]').val(data.description)
            $('html').preloader('remove');
            modalMachine.modal("show");
        }
        const openModalMachineAjouter = () => {
            modalMachineAction = "Ajouter"
            $("#formMachine").trigger("reset");
            modalMachine.modal("show");
        }
        async function getInvInfo(id) {
            var res = await $.get("/machines/" + id + "/edit");
            return res.data;
        }
        $("#formMachine").submit(function(e) {
            e.preventDefault()
            if (modalMachineAction == "Ajouter") {
                ajouterMachine()
            } else {
                modifierMachine()
            }
        })
        const ajouterMachine = () => {
            $('html').preloader({
                text: 'Loading ..',
                zIndex: '1056',
            });
            var data = new FormData(document.getElementById("formMachine"))
            $.ajax({
                url: "{{ route('machines.store') }}",
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
                    modalMachine.modal("hide")
                    reloadTable()
                },
                error: function(e) {

                }
            })
        }
        const modifierMachine = () => {
            $('html').preloader({
                text: 'Loading ..',
                zIndex: '1056',
            });
            var data = new FormData(document.getElementById("formMachine"))
            $.ajax({
                url: "{{ url('/machines') }}/" + Machine_id,
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
                    modalMachine.modal("hide")
                    reloadTable()
                },
                error: function(e) {

                }
            })
        }
        const deleteMachine = (id) => {
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
                            url: "{{ url('/machines') }}/" + id,
                            method: "DELETE",
                            success: function(data) {
                                $('html').preloader('remove');
                                modalMachine.modal("hide")
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
            $.get("{{ route('machines.refreshTable') }}", (data) => {
                $("tbody").remove()
                $("table").append(data)
                $('html').preloader('remove');
            })
        }
    </script>
@endsection
