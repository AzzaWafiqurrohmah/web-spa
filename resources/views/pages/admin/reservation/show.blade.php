@extends('layouts.app')

@section('content')
<div class="card my-4 container">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6 d-flex align-items-center gap-4 mb-4">
                <img src="{{ asset('assets/img/logo-spa.jpg') }}" alt="Logo SPA" class="rounded-circle" width="70">
                <div>
                    <p class="m-0 text-muted"><b>{{ $reservation->date->format('d M Y') }}</b></p>
                    <h3 class="m-0"><b>RSV-{{ $reservation->date->format('dmY') . $reservation->id }}</b></h3>
                    <small class="m-0 text-muted">Waktu: {{ $reservation->time }}</small>
                </div>
            </div>
            <div class="col-md-6 d-flex gap-4">
                <div class="col-md-7 rounded bg-light px-3 py-2 d-flex align-items-center gap-3">
                    <div>
                        <h6 class="m-0 text-muted"><b>Total Pembayaran:</b></h6>
                        <p class="m-0" style="font-size: 1.5rem;"><b>Rp {{ number_format($reservation->totals, 0, ',', '.') }}</b></p>
                    </div>

                    @if ($reservation->payment_type == 'cash')
                        <div class="badge bg-success" style="font-size: 0.9rem;">Cash</div>
                    @elseif ($reservation->payment_type == 'transfer')
                        <div class="badge bg-info" style="font-size: 0.9rem;">Transfer</div>
                    @endif
                </div>
                <div class="col-md-4 rounded bg-light px-3 py-2 d-flex align-items-center gap-3">
                    <div>
                        <h6 class="m-0 text-muted mb-2"><b>Status Reservasi:</b></h6>
                        @if ($reservation->status == 'succes')
                            <div class="badge bg-success text-center" style="font-size: 0.9rem;">Selesai</div>
                        @elseif ($reservation->status == 'processed')
                            <div class="badge bg-warning" style="font-size: 0.9rem;">Diproses</div>
                        @elseif($reservation->status == 'cancelled')
                            <div class="badge bg-danger" style="font-size: 0.9rem;">Dibatalkan</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-2">
                <div class="rounded bg-light px-4 py-3">
                    <p class="m-0"><b class="text-muted">Dari</b><b class="ms-2">Aromatherapy Family SPA</b></p>

                    <div class="d-flex flex-column gap-2 text-muted mt-2" style="font-size: .85rem;">
                        <div>
                            <i class="fas fa-fw fa-building"></i>
                            {{ $reservation->franchise->name }}
                        </div>
                        <div>
                            <i class="fas fa-fw fa-user"></i>
                            {{ $reservation->therapist->fullname }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-2">
                <div class="rounded bg-light px-4 py-3">
                    <p class="m-0"><b class="text-muted">Cust:</b><b class="ms-2">{{ $reservation->customer->fullname }}</b></p>

                    <div class="d-flex flex-column gap-2 text-muted mt-2" style="font-size: .85rem;">
                        <div>
                            <i class="fas fa-fw fa-phone"></i>
                            {{ $reservation->customer->phone }}
                        </div>
                        <div>
                            <i class="fas fa-fw fa-location-dot"></i>
                            {{ $reservation->customer->address }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-8">
                <h6><b>Jumlah Treatment: {{ $reservation->reservationDetail->count() }}</b></h6>
                <div class="table-responsive my-4">
                    <table class="table bg-light rounded overflow-hidden">
                        <thead>
                            <tr>
                                <th>Treatment</th>
                                <th>Harga</th>
                                <th>Diskon</th>
                                <th>Diskon Member</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allReservation as $item)
                            <tr>
                                <td class="text-muted">{{ $item['name'] }}</td>
                                <td class="text-muted">Rp {{ number_format($item['price']) }}</td>
                                <td class="text-muted">Rp {{ number_format($item['disc_treatment']) }}</td>
                                <td class="text-muted">Rp {{ number_format($item['disc_member']) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded d-flex flex-column text-muted gap-2 px-4 py-3">
                    <div class="d-flex gap-2">
                        <div class="p-3 bg-light rounded">
                            <i class="fas fa-fw fa-car-side"></i>
                        </div>
                        <div>
                            <p class="m-0"><b>Biaya Transport</b></p>
                            <p class="m-0">Rp {{ number_format($reservation->transport_cost) }}</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="p-3 bg-light rounded">
                            <i class="fas fa-fw fa-money-bills"></i>
                        </div>
                        <div>
                            <p class="m-0"><b>Biaya Ekstra</b></p>
                            <p class="m-0">Rp {{ number_format($reservation->extra_cost) }}</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="p-3 bg-light rounded">
                            <i class="fas fa-fw fa-tags"></i>
                        </div>
                        <div>
                            <p class="m-0"><b>Diskon Reservasi</b></p>
                            <p class="m-0">Rp {{ number_format($disc_reservation) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex gap-2">
        <a href="{{ route('reservations.index') }}" class="btn btn-primary"><i class="fas fa-fw fa-chevron-left"></i> Kembali</a>
        @role('admin')
            @if($reservation->status == 'processed')
                <button class="btn btn-sm btn-danger btn-cancel" data-id="{{ $reservation->id }}">Batalkan Reservasi</button>
            @else
                <button class="btn btn-sm btn-danger btn-cancel" data-id="{{ $reservation->id }}" disabled>Batalkan Reservasi</button>
            @endif
        @endrole
    </div>
</div>
@endsection


@push('style')
<style>
    @media (min-width: 992px) {
        .invoice-body {
            padding: 2rem 3rem;
        }
    }
</style>
@endpush

@push('script')
    <script>
        function cancel(id) {
            $.ajax({
                url: `/reservations/cancel/${id}`,
                method: 'GET',
                success(res) {
                    Swal.fire({
                        icon: 'success',
                        text: res.meta.message,
                        timer: 1500,
                        willClose: () => {
                            window.location.reload();
                        }
                    });
                },
                error(err) {
                    Swal.fire({
                        icon: 'error',
                        text: err,
                        timer: 1500,
                    });
                },
            });
        }

        $('.btn-cancel').on('click', function (e) {
            Swal.fire({
                icon: 'question',
                text: 'Apakah anda yakin ingin membatalkan pesanan?',
                showCancelButton: true,
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Iya'
            }).then((res) => {
                if (res.isConfirmed)
                    cancel(this.dataset.id);
            });
        });
    </script>
@endpush
