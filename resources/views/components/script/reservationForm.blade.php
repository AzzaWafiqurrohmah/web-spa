@push('script')
    <script>
        var allTreatment = [];
        var member ;
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
        let customer = $('.customer-option').val();
        let discAdd = $('#discountAdd').val();
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
                },
                success(res) {
                    date = setTime($('#time').val(), $('#date').val());
                    durationTP = res.data.duration;

                    if(therapistID != 0){
                        checkTherapist();
                    }

                    var totalEkstra = setEkstraMalam(res.data.duration);
                    var discString = parseInt(discAdd) + res.data.disc_treatment;
                    var totalDisc = res.data.discount + discString ;
                    total = (parseVal($('#transport_cost_string').text()) + res.data.totalTreatment + totalEkstra ) - discString;

                    // console.log($('#transport_cost_string').text());
                    $('#extra_cost_string').text(`Rp ${totalEkstra}`);
                    $('#extra_cost').val(totalEkstra);
                    $('#discString').text(`Rp ${ parseInt(discAdd) + res.data.disc_treatment }`);
                    $('#discTreatment').val(`Rp ${ discString}`);
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
                date.setMinutes(date.getMinutes() + $totalDuration);

                let difference = date - deadline;
                hour = Math.floor(difference / (1000 * 60 * 60));
                minute = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));

                if( hour < 0){
                    hour = 0;
                }

                if (hour == 0   && minute > 0) {
                    hour = 1;
                } else if (hour >= 1 && minute > 30) {
                    hour += 1;
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
            let price = treatment.price;
            if(member){
                price = treatment.member_price
            }

            $('#treatment-container').append(`
            <div class="col-md-6 mb-3" >
                 <input type="hidden" id="treatments" name="treatments[T${treatment.id}]" value="T${treatment.id}">
                 <div class="card" >
                       <div class="card-body d-flex gap-4 align-items-center">
                             <i class="bi bi-clipboard-check-fill" style="font-size: 2rem"></i>
                              <div>
                                <h6 class="m-0" style="font-size: 1.2rem">${treatment.name}</h6>
                                <p class="m-0">${price}</p>
                              </div>
                              <span class="position-absolute top-0 end-0 me-2 btn-delete" data-id="${treatment.id}" style="font-size: 1.4rem; cursor: pointer">
                                 <i class="bi bi-x"></i>
                              </span>
                       </div>
                 </div>
            </div>
            `);
        }

        function addPacket(packet) {
            let price = packet.packet_price;
            if(member){
                price = packet.member_price
            }

            $('#treatment-container').append(`
            <div class="col-md-6 mb-3" >
                 <input type="hidden" id="treatments" name="treatments[P${packet.id}]" value="P${packet.id}">
                 <div class="card" >
                       <div class="card-body d-flex gap-4 align-items-center">
                             <i class="bi bi-clipboard-check-fill" style="font-size: 2rem"></i>
                              <div>
                                <h6 class="m-0" style="font-size: 1.2rem">${packet.name}</h6>
                                <p class="m-0">${price}</p>
                              </div>
                              <span class="position-absolute top-0 end-0 me-2 btn-delete" data-id="${packet.id}" style="font-size: 1.4rem; cursor: pointer">
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
            // emptyTreatment();
        });


        //select2 customer
        $(".customer-option").select2({
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
                                member: item.is_member,
                                id:item.id
                            }
                        })
                    };
                },
                cache: true
            },
            placeholder: '--- Pilih Customer ---',
            minimumInputLength: 0,
            templateResult: formatRepo,
            templateSelection: formatSelection
        });

        function formatRepo (repo) {
            if (repo.loading) {
                return repo.text;
            }

            let color = 'grey';
            if(repo.member === 1){
                color = 'green';
            }
            return $(
                '<div class="d-flex gap-3 align-items-center">' +
                `<i class="bi bi-person-circle ms-1" style="font-size: 1.5rem; color: ${color}"></i>` +
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
                    $('#customer_member').val(member);
                    $('#treatment-container').empty();
                    updateTotal();
                }
            });
        });


        $('.customer-option').change(function() {
            ($(this).val().length > 0) ?
                $('#regency-select').removeAttr('disabled') :
                $('#regency-select').attr('disabled', true);

            if($(this).val().length > 0){
                $('.treatment-option').removeAttr('disabled');
                $('.packet-option').removeAttr('disabled');
            }
        });

        $('#transport_cost').on('change', function (){
            $('#transport_cost_string').text(`Rp ${$(this).val()}`);
            updateTotal();
        })

        function formatSelection(selection) {

            let color = 'grey';
            if (selection.id !== '') {
                member = selection.member ?? parseInt($('#customer_member').val());
                if (member == 1) {
                    color = 'green';
                }
                return $(
                    '<div class="d-flex gap-3">' +
                    `<i class="bi bi-person-circle" style="font-size: 1.4rem; color: ${color}; margin-top: -5px"></i>` +
                    '<div>' +
                    '<h4 class="m-0" style="font-size: 16px">' + selection.text + '</h4>' +
                    '</div>' +
                    '</div>'
                );
            } else {
                return $('<span style="color: grey;">' + selection.text + '</span>');
            }
        }

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
                                member_price: item.member_price,
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
            let price = repo.price;
            if(member == 1){
                price = repo.member_price
            }
            return $(
                '<div class="d-flex gap-4 align-items-center">' +
                '<i class="bi bi-clipboard ms-1" style="font-size: 1.5rem"></i>' +
                '<div>' +
                '<h4 class="m-0" style="font-size: 16px">' + repo.text + '</h4>' +
                '<p class="m-0" style="font-size: 12px">' + price + '</p>' +
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

        //packet treatment
        $(".packet-option").select2({
            ajax: {
                url: "/packets/search",
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
                                price: item.packet_price,
                                member_price: item.member_price,
                                id:item.id
                            }
                        })
                    };
                },
                cache: true
            },
            placeholder: '--- Pilih Paket Treatment ---',
            minimumInputLength: 0,
            templateResult: formatRepoPacket
        });

        function formatRepoPacket (repo) {
            if (repo.loading) {
                return repo.text;
            }
            let price = repo.price;
            if(member){
                price = repo.member_price
            }
            return $(
                '<div class="d-flex gap-4 align-items-center">' +
                '<i class="bi bi-clipboard ms-1" style="font-size: 1.5rem"></i>' +
                '<div>' +
                '<h4 class="m-0" style="font-size: 16px">' + repo.text + '</h4>' +
                '<p class="m-0" style="font-size: 12px">' + price + '</p>' +
                '</div>' +
                '</div>'
            );
        }

        $('.packet-option').on('select2:select', function(repo) {
            const id = $(this).val();
            $.ajax({
                url: `/packets/${id}`,
                dataType: 'JSON',
                success(res) {
                    addPacket(res.data);
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
