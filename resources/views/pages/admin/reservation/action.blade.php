<div class="d-flex">
    @role(['admin', 'owner'])
        <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-sm btn-warning me-1">Detail</a>
    @endrole

    @role('therapist')
    <a href="/therapist/reservations/{{ $reservation->id }}" class="btn btn-sm btn-warning me-1">Detail</a>
    @endrole

    @role('admin')
        <button class="btn btn-sm btn-info btn-edit me-1" data-id="{{ $reservation->id }}">Edit</button>
        <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $reservation->id }}">Hapus</button>
    @endrole
</div>
