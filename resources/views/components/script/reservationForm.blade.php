@push('script')
    <script>

        function selectPayment(id) {
            document.getElementById(id).checked = true;
        }

        function parseVal(val)
        {
            return parseInt(val.replace(/[^0-9]/g,''));
        }

        let ekstra_malam = {{ $setting['biaya_ekstra_malam'] }};
        let date = new Date();
        // let treatments = [];
        let customer;
        let discAdd = 0;
        let durationTP = 0;
        let therapistID = 0;

        $('#discountAdd').on('change', function (){
            discAdd = $(this).val();
            updateTotal();
        })

        function updateTotal()
        {
            customer = $('#customer_id').val();
            let treatments = [];
            $('[name^="treatments\\["]').each(function() {
                treatments.push($(this).val());
            });

            $.ajax({
                url: `/reservations/treatmentTotal`,
                dataType: 'JSON',
                method: 'POST',
                data: {

                    cust: customer,
                    treatment: treatments
                    // treatment: treatments
                },
                success(res) {
                    date = setTime($('#time').val(), $('#date').val());
                    durationTP = res.data.duration;

                    if(therapistID != 0){
                        checkTherapist();
                    }

                    var totalEkstra = setEkstraMalam(res.data.duration);
                    var totalDisc = res.data.disc + parseInt(discAdd);
                    total = (parseVal($('#transport_cost_string').text()) + res.data.totalTreatment + totalEkstra ) - totalDisc;

                    $('#extra_cost_string').text(`Rp ${totalEkstra}`);
                    $('#extra_cost').val(totalEkstra);
                    $('#discString').text(`Rp ${ totalDisc }`);
                    $('#discount').val(totalDisc);
                    $('#totalTreatmentString').text(`Rp ${ res.data.totalTreatment }`)
                    $('#totalTreatment').val(res.data.totalTreatment);
                    $('#totalString').text(`Rp ${total}`);
                    $('#totals').val(total);
                }
            });
        }

        function checkTherapist()
        {
            $.ajax({
                url: `/therapists/available`,
                method: 'GET',
                dataType: 'JSON',
                data: {
                    id: therapistID,
                    date: $('#date').val() == '' ? '0' : $('#date').val(),
                    time: $('#time').val() == '' ? '0' : $('#time').val(),
                    duration: durationTP
                },
                success(res) {
                    if(res.meta.message != 'success')
                    {
                        Swal.fire({
                            icon: 'error',
                            text: res.meta.message,
                            timer: 4000,
                        });
                        $('.therapist-option').val(null).trigger('change');
                    }
                }
            });
        }


        function setEkstraMalam($totalDuration)
        {
            let deadline = new Date($('#date').val());
            let hour, minute;
            deadline.setHours('18');
            deadline.setMinutes('00');

            if(date.getHours() < deadline.getHours())
            {
                // console.log('1');
                date.setMinutes(date.getMinutes() + $totalDuration);

                let difference = date - deadline;
                hour = Math.floor(difference / (1000 * 60 * 60));
                minute = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));

                if (hour <= 0) {
                    hour = 0;
                } else {
                    if (hour < 1 && minute > 0) {
                        hour = 1;
                    }

                    if (hour >= 1 && minute > 30) {
                        hour += 1;
                    }
                }

            } else {
                hour = Math.floor($totalDuration / 60);
                if(hour == 0)
                {
                    hour = 1;
                }
                if ($totalDuration == 0)
                {
                    hour = 0;
                }
            }
            return hour * ekstra_malam;
        }

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

        var defaultOptions = [
            { id: '1', text: 'Customer 1', phone: '123456789' },
            { id: '2', text: 'Customer 2', phone: '987654321' },
            { id: '3', text: 'Customer 3', phone: '456789123' }
        ];


        //select2 customer
        $(".customer-option").select2({
            data: defaultOptions,
            ajax: {
                url: "/reservations/customers",
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
                                text: item.fullname,
                                phone: item.phone,
                                id:item.id
                            }
                        })
                    };
                },
                cache: true
            },
            placeholder: '--- Pilih Customer ---',
            minimumInputLength: 0,
            templateResult: formatRepo
        });

        function formatRepo (repo) {
            if (repo.loading) {
                return repo.text;
            }
            return $(
                '<div class="d-flex gap-4 align-items-center">' +
                '<i class="bi bi-person-circle ms-1" style="font-size: 1.5rem"></i>' +
                '<div>' +
                '<h4 class="m-0" style="font-size: 16px">' + repo.text + '</h4>' +
                '<p class="m-0" style="font-size: 12px">' + repo.phone + '</p>' +
                '</div>' +
                '</div>'
            );
        }

        $('.customer-option').on('select2:select', function(repo) {
            const id = $(this).val();
            $.ajax({
                url: `/customers/${id}`,
                dataType: 'JSON',
                success(res) {
                    customer = res.data.id;
                    $('#transport_cost_string').text(`Rp ${res.data.transport_cost}`);
                    $('#transport_cost').val(res.data.transport_cost);
                    updateTotal();
                }
            });
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

        document.getElementById('treatment-container').addEventListener('change', function (){
            const hidden = document.getElementById('treatments');
        });

        $('#time').on('change', function() {
            date = setTime($(this).val(), $('#date').val());
            document.getElementById('timeString').textContent = $(this).val();
            updateTotal();
        });

        $('#date').on('change', function (){
            // date = new Date($(this).val());
            let dateString = new Date($(this).val());
            let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            let formattedDate = dateString.toLocaleDateString('id-ID', options);
            $('#dateHidden').val(formattedDate);
            document.getElementById('dateString').textContent = formattedDate;
        });

        function setTime(time, dateString)
        {
            let dateVal = new Date(dateString);
            dateVal.setHours(time.substring(0, 2));
            dateVal.setMinutes(time.substring(3,5));
            return dateVal;
        }

        //select2 therapist
        $(".therapist-option").select2({
            ajax: {
                url: "/therapists/search",
                method: 'GET',
                dataType: 'json',
                delay: 0,
                data: function (params) {
                    return {
                        q: params.term,
                        date: $('#date').val() == '' ? '0' : $('#date').val(),
                        time: $('#time').val() == '' ? '0' : $('#time').val(),
                        duration: durationTP
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.fullname,
                                phone: item.phone,
                                id:item.id
                            }
                        })
                    };
                },
                cache: true
            },
            placeholder: '--- Pilih Terapis ---',
            minimumInputLength: 0,
            templateResult: formatRepo3
        });

        function formatRepo3 (repo) {
            if (repo.loading) {
                return repo.text;
            }
            return $(
                '<div class="d-flex gap-4 align-items-center">' +
                '<i class="bi bi-person-circle ms-1" style="font-size: 1.5rem"></i>' +
                '<div>' +
                '<h4 class="m-0" style="font-size: 16px">' + repo.text + '</h4>' +
                '<p class="m-0" style="font-size: 12px">' + repo.phone + '</p>' +
                '</div>' +
                '</div>'
            );
        }

        $('.therapist-option').on('select2:select', function(repo) {
            therapistID = $(this).val();
            updateTotal();
        });



    </script>
@endpush
