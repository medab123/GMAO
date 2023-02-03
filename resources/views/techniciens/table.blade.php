<tbody id="tbody">
    @foreach ($techniciens as $technicien)
        <tr>
            <td>{{ $technicien->id }}</td>
            <td class="text-start">
                @can('resource-edit')
                    <button title="Modifier" class="btn  btn-sm d-inline"
                        onclick="openModalTechnicienModifier('{{ $technicien->id }}')">
                        <span style="color: rgb(25, 197, 45);"> <i class=" fa-solid fa-pen-to-square "></i></span></button>
                        @endcan
                        @can('resource-delete')
                    <button title="Supprimer" onclick="deleteTechnicien('{{ $technicien->id }}',this)"
                        class="btn  btn-sm"><span style="color: rgb(213, 9, 23);"><i class="fa fa-trash"
                                aria-hidden="true"></i></span></button>
                                @endcan
                
            </td>
            <td>{{ $technicien->user->name }}</td>
            <td>
                @foreach($technicien->niveau as $niveaus)
                    <span class="badge badge-success">{{ $niveaus->name }}</span>
                @endforeach
            </td>
        </tr>
    @endforeach
</tbody>
