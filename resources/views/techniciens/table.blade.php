<tbody id="tbody">
    @foreach ($techniciens as $technicien)
        <tr>
            <td>{{ $technicien->id }}</td>
            <td class="text-start">
               
                    <button title="Modifier" class="btn  btn-sm d-inline"
                        onclick="openModalTechnicienModifier('{{ $technicien->id }}')">
                        <span style="color: rgb(25, 197, 45);"> <i class=" fa-solid fa-pen-to-square "></i></span></button>
               
                    <button title="Supprimer" onclick="deleteTechnicien('{{ $technicien->id }}',this)"
                        class="btn  btn-sm"><span style="color: rgb(213, 9, 23);"><i class="fa fa-trash"
                                aria-hidden="true"></i></span></button>
                
            </td>
            <td>{{ $technicien->username }}</td>
            <td>{{ $technicien->niveau}}</td>
        </tr>
    @endforeach
</tbody>
