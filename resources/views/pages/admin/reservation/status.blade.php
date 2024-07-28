<div class="d-flex">

    @if($reservation->status == 'succes')
        <button class="btn btn-sm btn-outline-success me-1 " style="border-radius: 50px; font-size: 13px" >Selesai</button>
    @elseif($reservation->status == 'processed')
        <button class="btn btn-sm btn-outline-info me-1" style="border-radius: 50px; font-size: 13px">Diproses</button>
    @else
        <button class="btn btn-sm btn-outline-danger me-1" style="border-radius: 50px; font-size: 13px">Dibatalkan</button>
    @endif

</div>
