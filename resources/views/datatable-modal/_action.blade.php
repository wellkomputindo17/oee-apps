<button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
    <i class="fa fa-bars"></i></button>
<div class="dropdown-menu cuk" aria-labelledby="dropdownMenu">
    <a href="{{ $edit_url }}" data-toggle="tooltip" data-id="{{ $row_id }}" data-original-title="Edit"
        class="dropdown-item">
        <i class="fas fa-edit"></i> Edit</a>
    <form action="{{ $delete_url }}" method="post">
        @method('delete')
        @csrf
        <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure?')"><i
                class="fas fa-trash"></i> Delete
        </button>
    </form>

</div>
