<div class="d-flex">
    @if($customer->is_member == 0)
        @if(auth()->user()->can('crud customers'))
            <button class="btn btn-sm btn-outline-danger btn-member" data-id="{{ $customer->id }}">non-member</button>
        @else
            <button class="btn btn-sm btn-outline-danger">non-member</button>
        @endif
    @else
        <button class="btn btn-sm btn-outline-success">member</button>
    @endif
</div>
