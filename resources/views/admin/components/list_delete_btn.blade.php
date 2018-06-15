@if($type == 'user')
    @if ($item->id == Auth::user()->id || Auth::user()->role_id <= $item->role_id)
        <span data-toggle="tooltip" title="You do not have permission to delete this user.">
    @endif
            <button @if ($item->id == Auth::user()->id || Auth::user()->role_id <= $item->role_id) disabled
                    @endif class="list__delete" data-toggle="modal" data-target="#deleteModal">Delete</button>
            @if ($item->id == Auth::user()->id || Auth::user()->role_id <= $item->role_id)
     </span>
    @endif
@else

    @if (Auth::user()->role_id < $min_role)
        <span data-toggle="tooltip" title="You do not have permission to delete this {{ $type }}.">
    @endif
            <button @if (Auth::user()->role_id < $min_role) disabled
                    @endif class="list__delete" data-toggle="modal" data-target="#deleteModal">Delete</button>
            @if (Auth::user()->role_id < $min_role)
     </span>
    @endif

@endif