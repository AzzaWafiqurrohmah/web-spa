@php
    use App\Enums\Presence;

    $pStatus = Presence::tryFrom($status);
    $class = match($pStatus) {
        Presence::absent => 'info',
        Presence::half => 'warning',
        Presence::full => 'success',
        Presence::empty => 'primary',
    };
@endphp

<button class="btn btn-sm btn-{{ $class}} dropdown-toggle text-start" data-bs-toggle="dropdown" aria-expanded="false" style="min-width: 130px; position: relative;">
    {{ $status }} <i class="bx bxs-down-arrow" style="position: absolute; right: 5px; top: 10px; font-size: .6rem;"></i>
</button>
