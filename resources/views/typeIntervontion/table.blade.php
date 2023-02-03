<tbody id="tbody">
    @foreach ($typeIntervontions as $typeIntervontion)
        <tr>
            <td>{{ $typeIntervontion->id }}</td>
            <td class="text-start">
                @can('resource-create')
                    <button title="Modifier" class="btn  btn-sm d-inline"
                        onclick="openModalTypeInterModifier('{{ $typeIntervontion->id }}')">
                        <span style="color: rgb(25, 197, 45);"> <i class=" fa-solid fa-pen-to-square "></i></span></button>
                @endcan
                @can('resource-delete')
                    <button title="Supprimer" onclick="deleteTypeInter('{{ $typeIntervontion->id }}',this)"
                        class="btn  btn-sm"><span style="color: rgb(213, 9, 23);"><i class="fa fa-trash"
                                aria-hidden="true"></i></span></button>
                @endcan

            </td>
            <td>{{ $typeIntervontion->name }}</td>

        </tr>
    @endforeach
</tbody>
