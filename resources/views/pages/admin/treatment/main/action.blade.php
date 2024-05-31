<div class="d-flex">
    <button class="btn btn-sm btn-warning btn-detail me-1" data-id="{{ $treatment->id }}">Detail</button>
    @if(auth()->user()->can('crud treatments'))
        <button class="btn btn-sm btn-info btn-edit me-1" data-id="{{ $treatment->id }}">Edit</button>
        <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $treatment->id }}">Hapus</button>
    @endif
</div>

