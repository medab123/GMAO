@extends('layouts.app')

@section('content')
    <!-- Modal -->
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <div class="card card-default collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title" id="cardAjouterTitle">Ajouter une Machine</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" id="cardAddMachine">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body" style="display: none;">
                            <form method="POST" action="{{ route('machines.store') }}">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Nom</label>
                                            <input id="inputName" name="name" type="text" class="form-control"
                                                placeholder="Enter le nom de la machine..." required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input id="inputDescription" name="description" type="text"
                                                class="form-control" placeholder="....">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-sm btn-success col-2 text-center">Enrgistre</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">List des machines</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0 table-sm" style="max-height: 400px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nom</th>
                                        <th>Description</th>

                                        <th class="text-center me-2" style="width: 60px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($machines as $machine)
                                        <tr>
                                            @method('PATCH')
                                            <td>{{ $machine->id }}</td>
                                            <td id="name">{{ $machine->name }}</td>
                                            <td id="description">{{ $machine->description }}</td>

                                            <td class="text-right me-2 col-auto">
                                                <div class="divBtnAction">
                                                    <form class="formdelete" method="POST"
                                                        action="{{ route('machines.destroy', ['machine' => $machine->id]) }}">
                                                        @method('DELETE')
                                                    </form>
                                                    <button type="button" class="btn btn-sm"
                                                        onclick="if(confirm('are you sur you want to delete this machine')){
                                                            $(this).parent().children('.formdelete').submit()}"><i
                                                            class="fas fa-trash-alt text-danger"></i></button>
                                                    <button type="button" class="btn btn-sm"
                                                        onclick="edit('{{ $machine->id }}',this)"><i
                                                            class="far fa-edit text-success"></i></button>

                                                </div>
                                                <div class="d-none divBtnModifier">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-success" onclick="addMachine({{ $machine->id }},this)">Enregistre</button>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="togleBtns(this)">Annuler</button>
                                                </div>

                                            </td>


                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <script>
        const togleBtns = (btn) => {
            $(btn).parent().parent().children(".divBtnAction").toggleClass("d-none")
            $(btn).parent().parent().children(".divBtnModifier").toggleClass("d-none")
            if ($(btn).parent().parent().children(".divBtnAction").hasClass("d-none")) {
                nameInput = $(btn).parent().parent().parent().children("#name")
                descriptionInput = $(btn).parent().parent().parent().children("#description")
                nameInput.html("<input name='name' class='form-control form-control-sm' value='" + nameInput.html() +
                    "'>")
                descriptionInput.html("<input name='description' class='form-control form-control-sm' value='" +
                    descriptionInput.html() + "'>")
            } else {
                nameInput = $(btn).parent().parent().parent().children("#name")
                descriptionInput = $(btn).parent().parent().parent().children("#description")
                nameInput.html(nameInput.children("input").val())
                descriptionInput.html(descriptionInput.children("input").val())
            }

        }
        const edit = (id, btn) => {
            togleBtns(btn)
        }
        const DeleteConferm = (event) => {
            event.preventDefa
        }
        const addMachine = (id,btn)=>{
            const form = $(btn).parent().parent().parent();
            console.log(new FormData(form))
        }
    </script>
    <!-- /.content -->
@endsection
