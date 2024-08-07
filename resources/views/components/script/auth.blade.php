@push('script')
    <script>
        url = '{{ route('signOut') }}';
        role = ({{ \Illuminate\Support\Facades\Auth::user()->hasrole('therapist') ? 'true' : 'false' }});
        if( role){
            url = '{{ route('therapist.signOut') }}'
        }
        function signOut() {
            $.ajax({
                url: url,
                method: 'GET',
                success(res) {
                    Swal.fire({
                        icon: 'success',
                        text: res.message,
                        timer: 1500,
                    });
                    window.location.href = '{{ route('login') }}';
                },
                error(err) {
                    Swal.fire({
                        icon: 'error',
                        text: 'Terdapat masalah saat melakukan aksi',
                        timer: 1500,
                    });
                },
            });
        }

        $('.sign-out').on('click', function (e){
            e.preventDefault();
            Swal.fire({
                icon: 'question',
                text: 'Apakah anda ingin keluar?',
                showCancelButton: true,
                cancelButtonText: 'Batal',
            }).then((res) => {
                if(res.isConfirmed)
                    signOut();
            });
        })

    </script>
@endpush
