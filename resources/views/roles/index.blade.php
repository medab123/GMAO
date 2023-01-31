@extends('layouts.app')
@section('content')
    <div class="modal fade" id="modalRoles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formRoles">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <div class="form-group">
                                    <strong>Nom:</strong>
                                    <input type="text" placeholder="Nom du Fonction" name="name" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="row">
                                    <strong>Permission:</strong>
                                    <br />
                                    @foreach ($permission as $value)
                                        <div class="col-3">
                                            <label>
                                                {{ Form::checkbox('permission[]', $value->id, false, ['class' => 'name', 'id' => $value->id]) }}
                                                {{ $value->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button id="modalButtonSupmit" type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header ">
            <h5 class="py-2"> Role Management</h5>
            <button onclick="openModalRoleAjouter()" class="btn btn-success btn-sm float-end"
                href="{{ route('roles.create') }}">Ajouter un nouveau rôle</button>
        </div>
        <div class="card-body custom-scrollbar">
            <div class="table-responsive-sm" style="overflow-x: scroll; max-height: 60vh;">
                <table class="table table-striped table-hover table-sm  ">
                    <thead class="sbg-light">
                        <tr>
                            <th>#</th>
                            <th>Action</th>
                            <th>Nom</th>
                        </tr>
                    </thead>
                    @include('roles.table')
                </table>
            </div>
        </div>
    </div>

    <script>
        var role_id;
        var modalRoleAction = "Ajouter";
        $(document).ready(function() {
            roleModal = $('#modalRoles')
        });
        const openModalRoleAjouter = () => {
            $("#formRoles").trigger("reset");
            modalRoleAction = "Ajouter"
            $("#modalButtonSupmit").html(modalRoleAction)
            roleModal.modal("show")
        }
        var data
        async function openModalRoleModifier(id) {
            $("#formRoles").trigger("reset");
            modalRoleAction = "Modifier"
            $("#modalButtonSupmit").html(modalRoleAction)
            role_id = id;
            data = await getRoleInfo(id);
            $('html').preloader({
                text: 'Loading ..',
            });
            console.log(data)
            $('input[name="name"]').val(data.role.name)
            var t = Object.keys(data.rolePermissions).map((key) => {
                return data.rolePermissions[key];
            });
            $('#formRoles *').filter(':input').each(function() {
                if ($(this).attr("name") == "permission[]") {
                    if ($.inArray(parseInt($(this).attr("id")), t) !== -1) {
                        $(this).prop('checked', true);
                        console.log($(this).attr("id") + "cheked")
                    }
                }
            });
            $('html').preloader('remove');


            roleModal.modal("show");
        }
        $("#formRoles").submit(function(event) {
            if (modalRoleAction == "Ajouter") {
                ajouter(event);
            } else {
                modifier(event);
            }
        })
        const ajouter = (event) => {
            $('html').preloader({
                text: 'Loading ..',
                zIndex: '1056',
            });
            event.preventDefault();
            var data = new FormData(document.getElementById("formRoles"))
            $.ajax({
                url: "{{ route('roles.store') }}",
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
                    roleModal.modal("hide")
                    reloadTable()
                },
                error: function(e) {

                }
            })
        }
        const modifier = (event) => {
            $('html').preloader({
                text: 'Loading ..',
                zIndex: '1056',
            });
            event.preventDefault();
            var data = new FormData(document.getElementById("formRoles"))
            //data = data.append("_method","PATCH")
            $.ajax({
                url: "/roles/" + role_id,
                method: "POST",
                processData: false,
                contentType: false,
                data: data,
                success: function(data) {
                    $('html').preloader('remove');
                    roleModal.modal("hide")
                    reloadTable()
                },
                error: function(e) {
                    console.log(e)
                }
            })
        }
        const deleteRole = (event, id, btn) => {
            event.preventDefault();
            var row = $(btn).parent("td").parent("tr")
            $.confirm({
                title: 'Confirmer la suppression!',
                content: 'Confirmer la suppression d\'un role !',
                buttons: {
                    confirm: function() {
                        $('html').preloader({
                            text: 'Loading ..',
                        });
                        $.ajax({
                            url: '{{ url('roles') }}/' + id,
                            type: 'DELETE',
                            success: function(response) {
                                row.remove();
                                $('html').preloader('remove');
                            }
                        });
                    },
                    cancel: function() {

                    },
                }
            });

        }
        async function getRoleInfo(id) {
            var res = await $.get("/roles/" + id + "/edit");
            return res;
        }
        const reloadTable = () => {
            $('html').preloader({
                text: 'Loading ..',
            });
            $.get("{{ route('roles.refreshTable') }}", (data) => {
                $("tbody").remove()
                $("table").append(data)
                $('html').preloader('remove');
            })
        }
    </script>
@endsection
