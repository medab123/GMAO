<tbody id="tbody">
    @foreach ($niveauintervontions as $niveauintervontion)
        <tr>
            <td>{{ $niveauintervontion->id }}</td>
            <td class="text-start">
                @can('resource-edit')
                    <button title="Modifier" class="btn  btn-sm d-inline"
                        onclick="openModalNiveauIntervontionModifier('{{ $niveauintervontion->id }}')">
                        <span style="color: rgb(25, 197, 45);"> <i class=" fa-solid fa-pen-to-square "></i></span></button>
                @endcan
                @can('resource-delete')
                    <button title="Supprimer" onclick="deleteNiveauIntervontion('{{ $niveauintervontion->id }}',this)"
                        class="btn  btn-sm"><span style="color: rgb(213, 9, 23);"><i class="fa fa-trash"
                                aria-hidden="true"></i></span></button>
                @endcan
            </td>
            <td>{{ $niveauintervontion->name }}</td>
            <td>{{ $niveauintervontion->description}}</td>
        </tr>
    @endforeach
</tbody>
