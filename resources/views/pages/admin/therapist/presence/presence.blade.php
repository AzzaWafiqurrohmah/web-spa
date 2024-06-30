{{-- <select name="status" id="" class="form-control">
    @foreach (App\Enums\Presence::values() as $cat => $val)
        <option value="">{{ $val }}</option>
    @endforeach
</select> --}}

<div class="dropdown">
    @foreach (App\Enums\Presence::values() as $cat => $pres)
        @if ($cat == $status)
            <x-presence.status :status="$pres" />
        @endif
    @endforeach

    <ul class="dropdown-menu">
        @foreach (App\Enums\Presence::values() as $cat => $val)
            <li class="dropdown-item presence-item" data-value="{{ $cat }}" data-id="{{ $presence->id }}">{{ $val }}</li>
        @endforeach
    </ul>
</div>

{{-- <div class="d-flex">
    <div class="dropdown-custom" id="status-option">
        @foreach (App\Enums\Presence::values() as $cat => $val)
            @if($cat == $status )
                <div class="select-custom">
                    <span class="selected-custom">{{$val}}</span>
                    <div class="caret-custom"></div>
                </div>
            @endif
        @endforeach

        <ul class="menu-custom" id="status">
            @foreach (App\Enums\Presence::values() as $cat => $val)
                <li class="option-custom" data-value="{{$cat}}" data-id="{{$presence->id}}">{{$val}}</li>
            @endforeach
        </ul>
    </div>
</div> --}}
