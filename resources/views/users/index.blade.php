@extends('layouts.app')


@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h5 class=" py-2"> Users Management</h5>
            <button onclick="openModalUserAjouter()" class="btn btn-success btn-sm float-end" data-bs-toggle="modal"
                data-bs-target="#modalUser">Ajouter un nouvel utilisateur</button>
        </div>

        <div class="card-body">
            <div class="table-responsive-sm">
                <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Action</th>
                            <th>Name</th>
                            <th>Email</th>
                            <!---<th>Ville</th>--->
                            <th>Type inventaire</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    @include('users.table')
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formUser">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Email:</strong>
                                    {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Password:</strong>
                                    {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Confirm Password:</strong>
                                    {!! Form::password('confirm-password', ['placeholder' => 'Confirm Password', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Role:</strong>
                                    {!! Form::select('roles[]', $roles, [], ['class' => 'form-control', 'multiple']) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Type Inventaire:</strong>
                                    {!! Form::select('type_inv_ids[]', $type_invs, [], ['class' => 'form-control', 'multiple']) !!}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button id="modalButtonSupmit" type="submit" class="btn btn-primary">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var user_id;
        var modalUserAction = "ajouter";
        $(document).ready(function() {
            userModal = $('#modalUser')
        });
        const openModalUserAjouter = () => {
            $("#formUser").trigger("reset");
            modalUserAction = "ajouter"
            $("#modalButtonSupmit").html("Ajouter")

        }
        $("#formUser").submit(function(event) {
            if (modalUserAction == "ajouter") {
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
            var data = new FormData(document.getElementById("formUser"))
            $.ajax({
                url: "{{ route('users.store') }}",
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
                    userModal.modal("hide")
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
            var data = new FormData(document.getElementById("formUser"))
            //data = data.append("_method","PATCH")
            $.ajax({
                url: "/users/" + inv_id,
                method: "POST",
                processData: false,
                contentType: false,
                data: data,
                success: function(data) {
                    $('html').preloader('remove');
                    userModal.modal("hide")
                    reloadTable()
                },
                error: function(e) {
                    console.log(e)
                }
            })
        }
        const deleteInv = (event, id, btn) => {
            event.preventDefault();
            var row = $(btn).parent("td").parent("tr")
            $.confirm({
                title: 'Confirmer la suppression !',
                content: 'Confirmer la suppression d\'un utilisateur!',
                buttons: {
                    confirm: function() {
                        $('html').preloader({
                            text: 'Loading ..',
                        });
                        $.ajax({
                            url: '{{ url('users') }}/' + id,
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
        var data = null;
        async function openModalUserModifier(id) {

            inv_id = id;
            data = await getUserInfo(id);
            $('html').preloader({
                text: 'Loading ..',
            });
            $('#formUser *').filter(':input').each(function() {
                if ($(this).attr('type') != "file") {
                    filedName = $(this).attr("name")
                    if (filedName) filedName = filedName.replace("[]", "")
                    $(this).val(data[filedName])
                    if (filedName == "roles") {
                        $(this).val(data["roles"].map((item) => {
                            return item.name
                        }))
                        console.log(this, data["roles"].map((item) => {
                            return item.name
                        }))
                    }

                    console.log(filedName)
                }
            });
            $('html').preloader('remove');
            $("#modalButtonSupmit").html("Modifier")
            modalUserAction = "modifier"
            userModal.modal("show");
        }
        async function getUserInfo(id) {
            var res = await $.get("/users/" + id + "/edit");
            return res.data;
        }
        const reloadTable = () => {
            $('html').preloader({
                text: 'Loading ..',
            });
            $.get("{{ route('users.refreshTable') }}", (data) => {
                $("tbody").remove()
                $("table").append(data)
                $('html').preloader('remove');
            })
        }
    </script>
@endsection
