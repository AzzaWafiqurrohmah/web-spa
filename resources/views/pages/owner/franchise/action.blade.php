<div class="d-flex">
    <a href="{{ route('franchises.edit', $franchise) }}" class="btn btn-sm btn-info btn-edit me-1">Edit</a>

    <form action="{{ route('franchises.destroy', $franchise) }}" method="post">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger btn-delete" type="submit">Hapus</button>
    </form>
</div>
