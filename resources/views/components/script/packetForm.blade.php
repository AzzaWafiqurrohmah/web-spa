@push('script')
    <script>

        function addTreatment(treatment) {
            $('#treatment-container').append(`
            <div class="col-md-6 mb-3" >
                 <input type="hidden" id="treatments" name="treatments[${treatment.id}]" value="${treatment.id}">
                 <div class="card" >
                       <div class="card-body d-flex gap-4 align-items-center">
                             <i class="bi bi-clipboard-check-fill" style="font-size: 2rem"></i>
                              <div>
                                <h6 class="m-0" style="font-size: 1.2rem">${treatment.name}</h6>
                                <p class="m-0">${treatment.price}</p>
                              </div>
                              <span class="position-absolute top-0 end-0 me-2 btn-delete" data-id="${treatment.id}" style="font-size: 1.4rem; cursor: pointer">
                                 <i class="bi bi-x"></i>
                              </span>
                       </div>
                 </div>
            </div>
        `);
        }

        $('#treatment-container').on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            $(this).parent().parent().parent().remove();
            updateTotal();
        });

        $(".treatment-option").select2({
            ajax: {
                url: "/reservations/treatments",
                method: 'GET',
                dataType: 'json',
                delay: 0,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.name,
                                price: item.price,
                                id:item.id
                            }
                        })
                    };
                },
                cache: true
            },
            placeholder: '--- Pilih Treatment ---',
            minimumInputLength: 0,
            templateResult: formatRepo2
        });

        function formatRepo2 (repo) {
            if (repo.loading) {
                return repo.text;
            }
            return $(
                '<div class="d-flex gap-4 align-items-center">' +
                '<i class="bi bi-clipboard ms-1" style="font-size: 1.5rem"></i>' +
                '<div>' +
                '<h4 class="m-0" style="font-size: 16px">' + repo.text + '</h4>' +
                '<p class="m-0" style="font-size: 12px">' + repo.price + '</p>' +
                '</div>' +
                '</div>'
            );
        }

        $('.treatment-option').on('select2:select', function(repo) {
            const id = $(this).val();
            $.ajax({
                url: `/treatments/${id}`,
                dataType: 'JSON',
                success(res) {
                    addTreatment(res.data);
                    updateTotal();
                }
            });
        });

        var member_price = 0;
        function updateTotal()
        {
            let treatments = [];
            $('[name^="treatments\\["]').each(function() {
                treatments.push($(this).val());
            });

            $.ajax({
                url: `{{ route('packets.treatmentTotal') }}`,
                dataType: 'JSON',
                method: 'POST',
                data: {
                    treatment: treatments
                },
                success(res) {
                    $('#total').val(res.data.normalPrice);

                    if ($('#checkBox').is(':checked')) {
                        $('#member_price').val(res.data.member_price);
                    }
                }
            });
        }

        $('#checkBox').change(function() {
            if ($(this).is(':checked')) {
                updateTotal();
            } else {
                $('#member_price').val(0);
            }
        });


    </script>
@endpush
