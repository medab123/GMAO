<tbody id="tbody">
    @foreach ($demandes as $demande)
        <tr class=" {{ $demande->status == 0 ? 'primary' : ($demande->status == 1 ? 'warning' : 'success') }}">
            <td>{{ $demande->id }}</td>
            <td class="text-start">
                <a href="{{ url("/demandes/$demande->id/edit") }}" class="btn btn-sm p-0"><i
                        class="fas fa-folder-open text-primary"></i></a>
                @can('demande-edit')
                    <button title="Modifier" class="btn  btn-sm d-inline p-0"
                        onclick="openModalDemandeModifier('{{ $demande->id }}')">
                        <span style="color: rgb(25, 197, 45);"> <i class=" fa-solid fa-pen-to-square "></i></span></button>
                @endcan
                @can('demande-delete')
                    <button title="Supprimer" onclick="deleteDemande('{{ $demande->id }}',this)"
                        class="btn  btn-sm p-0"><span style="color: rgb(213, 9, 23);"><i class="fa fa-trash"
                                aria-hidden="true"></i></span></button>
                @endcan

            </td>
            <td>{{ $demande->created_at }}</td>
            <td>{{ $demande->updated_at }}</td>
            <td>{{ $demande->machine }}</td>
            <td>{{ $demande->type_intervontion }}</td>
            <td>{{ $demande->niveau_intervontion }}</td>
            <td>{{ $demande->demondeur_name }}</td>
            <td>{{ $demande->description }}</td>
            <td>
                @foreach ($demande->techniciens as $tech)
                    <span class="badge badge-info ">{{ $tech->name }}</span>
                @endforeach
            </td>
            <td><span
                    class="badge badge-{{ $demande->status == 0 ? 'primary' : ($demande->status == 1 ? 'warning' : 'success') }}">
                    {{ $demande->status == 0 ? 'Ouvert' : ($demande->status == 1 ? 'Encoure' : 'resolu') }}</span></td>


        </tr>
    @endforeach
</tbody>
