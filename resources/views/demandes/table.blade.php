<tbody id="tbody">
    @foreach ($demandes as $demande)
        <tr>
            <td>{{ $demande->id }}</td>
            <td class="text-start">
               
                    <button title="Modifier" class="btn  btn-sm d-inline"
                        onclick="openModalDemandeModifier('{{ $demande->id }}')">
                        <span style="color: rgb(25, 197, 45);"> <i class=" fa-solid fa-pen-to-square "></i></span></button>
               
                    <button title="Supprimer" onclick="deleteDemande('{{ $demande->id }}',this)"
                        class="btn  btn-sm"><span style="color: rgb(213, 9, 23);"><i class="fa fa-trash"
                                aria-hidden="true"></i></span></button>
                
            </td>
            <td>{{ $demande->machine }}</td>
            <td>{{ $demande->type_intervontion }}</td>
            <td>{{ $demande->niveau_intervontion }}</td>
            <td>{{ $demande->demondeur_name }}</td>
            <td>{{ $demande->description }}</td>
            
        </tr>
    @endforeach
</tbody>
