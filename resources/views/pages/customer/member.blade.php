<div class="d-flex">
    @if($customer->member_id == 0)
        <button class="btn btn-sm btn-outline-danger btn-member" data-id="{{ $customer->id }}">Belum Aktif</button>
    @else
        <button class="btn btn-sm btn-outline-success">Aktif</button>
    @endif
</div>
