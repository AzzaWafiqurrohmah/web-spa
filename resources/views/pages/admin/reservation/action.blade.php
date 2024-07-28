<div class="d-flex">
    @role(['admin', 'owner'])
        <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-sm btn-warning me-1">Detail</a>
    @endrole

    @role('therapist')
    <a href="/therapist/reservations/{{ $reservation->id }}" class="btn btn-sm btn-warning me-1">Detail</a>
    @endrole

    @role('admin')
        <button class="btn btn-sm btn-info btn-edit me-1" data-id="{{ $reservation->id }}">Edit</button>
        @if($reservation->status == 'processed')
            <button class="btn btn-sm btn-danger btn-cancel" data-id="{{ $reservation->id }}">Batal</button>
        @else
            <button class="btn btn-sm btn-danger btn-cancel" data-id="{{ $reservation->id }}" disabled>Batal</button>
        @endif

    @endrole
</div>
