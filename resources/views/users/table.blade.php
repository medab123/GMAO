<tbody>
    @php $i = 0; @endphp
    @foreach ($data as $key => $user)
        <tr>
            <td>{{ ++$i }}</td>
            <td>
                <button title="Modifier" onclick="openModalUserModifier({{ $user->id }})"
                    class="btn  btn-sm d-inline"><span style="color: rgb(9, 213, 40);"><i
                            class="fa-solid fa-pen-to-square"></i></span></button>


                <button title="Supprimer" onclick="deleteInv(event,{{ $user->id }},this)" class='btn text-danger btn-sm'><i class="fa fa-trash"
                        aria-hidden="true"></i></button>

            </td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            
            <td>
                @if (!empty($user->getRoleNames()))
                    @foreach ($user->getRoleNames() as $v)
                        <label class="badge bg-success">{{ $v }}</label>
                    @endforeach
                @endif
            </td>
        </tr>
    @endforeach
</tbody>
