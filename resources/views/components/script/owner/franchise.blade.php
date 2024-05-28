@push('script')
    <script>
        const franchiseTable = $('#franchise-table').DataTable({
            serverSide: true,
            rendering: true,
            ajax: '{{ route('franchises.datatables') }}',
            columns: [
                {data: 'raw_id', name: 'raw_id'},
                {data: 'name', name: 'name'},
                {data: 'action', orderable: false, searchable: false},
            ],
        });


    </script>
@endpush
