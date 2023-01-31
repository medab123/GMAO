<tbody>
    @foreach ($roles as $role)
        <tr>
            <td>{{ $role->id }}</td>
            <td>
                @can('role-edit')
                    <button title="Modifier" class="btn text-primary btn-sm" onclick="openModalRoleModifier({{ $role->id }})" ><i
                            class="fa-solid fa-pen-to-square"></i></button>
                @endcan
                @can('role-delete')
                    <button title="Supprimer" class='btn text-danger btn-sm' onclick="deleteRole(event,{{ $role->id }},this)"><i class="fa fa-trash"
                            aria-hidden="true"></i></button>
                @endcan
            </td>
            <td>{{ $role->name }}</td>
        </tr>
    @endforeach
</tbody>
