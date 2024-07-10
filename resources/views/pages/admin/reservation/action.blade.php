<div class="d-flex">
    <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-sm btn-warning me-1">Detail</a>
    <button class="btn btn-sm btn-info btn-edit me-1" data-id="{{ $reservation->id }}">Edit</button>
    <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $reservation->id }}">Hapus</button>
</div>
