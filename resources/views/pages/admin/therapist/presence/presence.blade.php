<div class="d-flex">
    <div class="dropdown-custom" id="status-option">
        @foreach (App\Enums\Presence::values() as $cat => $val)
            @if($cat == $status )
                <div class="select-custom">
                    <span class="selected-custom">{{$val}}</span>
                    <div class="caret-custom"></div>
                </div>
            @endif
        @endforeach
{{--        <input type="hidden" name="presenceId" value="{{ $presence->id }}">--}}
        <ul class="menu-custom" id="status">
            @foreach (App\Enums\Presence::values() as $cat => $val)
                <li class="option-custom" data-value="{{$cat}}" data-id="{{$presence->id}}">{{$val}}</li>
            @endforeach
        </ul>
    </div>
</div>
