<div class="d-flex">
    @if($customer->is_member == 0)
        <button class="btn btn-sm btn-outline-danger btn-member" data-id="{{ $customer->id }}">non-member</button>
    @else
        <button class="btn btn-sm btn-outline-success">member</button>
    @endif
</div>
