<div class="d-flex">
    <button class="btn btn-sm btn-warning btn-detail me-1" data-id="{{ $customer->id }}">Detail</button>
    @if(auth()->user()->can('crud customers'))
        <button class="btn btn-sm btn-info btn-edit me-1" data-id="{{ $customer->id }}">Edit</button>
        <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $customer->id }}">Hapus</button>
    @endif
</div>
