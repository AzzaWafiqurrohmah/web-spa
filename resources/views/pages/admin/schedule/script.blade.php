@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://unpkg.com/smooth-scrollbar@latest/dist/smooth-scrollbar.js"></script>

<script>
    const monthCarousel = $('.month-carousel');
    const dateCarousel = $('.date-carousel');
    const carouselOptions = {
        loop: true,
        items: 5,
        center: true,
        onTranslated: callback,
        onInitialized: callback,
    }

    let renderLoop = 0;

    function padZero(num) {
        return num < 10 ? '0' + num : num;
    }

    function updateDateCarousel(year, month) {
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

        dateCarousel.owlCarousel('destroy');
        dateCarousel.empty();

        for (let date = firstDay; date <= lastDay; date.setDate(date.getDate() + 1)) {
            dateCarousel.append(`<div
                class="date-item text-center d-flex justify-content-center align-items-center flex-column"
                data-position="${date.getDate() - 1}"
            >
                <div class="d-flex justify-content-center align-items-center date-number bg-primary">${date.getDate()}</div>
                <p class="m-0 date-day">${days[date.getDay()]}</p>
            </div>`);
        }

        dateCarousel.owlCarousel(carouselOptions);
    }

    function generateSchedule(first, last, therapists) {
        let therapistImg = ``;

        therapists.map((therapist) => {
            therapistImg += `<div class="profile-img" style="background-image: url(${therapist.img})">${therapist.name[0]}</div>`;
        });

        return `<div class="card bg-light d-flex flex-row justify-content-between py-1 px-2 schedule-item">
            <div class="d-flex align-items-center gap-1 time-item-duration">
                <p class="m-0">${first.val}</p>
                <span> <i class="bx bx-chevron-right"></i> </span>
                <p class="m-0">${last.val}</p>
            </div>
            <div class="d-flex">
                ${therapistImg}
            </div>
        </div>`;
    }

    function generateTimeItem(time, schedules) {
        const therapists = schedules.map((schedule) => {
            return {
                img: schedule.therapist_img,
                name: schedule.therapist_name,
            }
        });

        let firstTime = schedules[0]?.time_start;
        let lastTime = schedules[0]?.time_end;

        schedules.map((schedule) => {
            if(schedule.time_start.timestamp < firstTime.timestamp)
                firstTime = schedule.time_start;

            if(schedule.time_end.timestamp > lastTime.timestamp)
                lastTime = schedule.time_end;
        });

        return `<div class="time-item d-flex align-items-center gap-2">
            <span>${time}</span>
            <div class="time-item-border">
                ${schedules.length > 0 ? generateSchedule(firstTime, lastTime, therapists) : ''}
            </div>
        <div>`;
    }

    function generateTimeSlots(schedules) {
        const container = $('#time-container');
        container.empty();

        for (let hour = 1; hour <= 23; hour++) {
            const time = padZero(hour) + ':00';
            actives = schedules.filter((sch) => parseInt(sch.hour) == hour);

            container.append(generateTimeItem(time, actives));
        }
    }

    function renderSchedule() {
        const activeEl = $('.owl-item.center');
        const year = (new Date()).getFullYear();

        const month = activeEl.eq(0).children().data('position');
        const date = activeEl.eq(1).children().data('position');

        $('#time-container').html(`<div
            class="d-flex w-full align-items-center justify-content-center"
            style="height: 100%;"
        >
            <i class='bx bx-loader-alt bx-spin' style="font-size: 2.5rem"></i>
        </div>`);

        $.ajax({
            url: '{{ route('schedules.json') }}',
            dataType: 'JSON',
            data: {
                date: `${year}-${padZero(month + 1)}-${padZero(date + 1)}`,
            },
            success(res) {
                generateTimeSlots(res.data);
            },
        });
    }

    function callback(event) {
        const target = $(event.target);
        const items = target.find('.owl-item.active');

        if(target.hasClass('month-carousel')) {
            items.find('.month-item').removeClass('selected');
            items.eq(2).find('.month-item').addClass('selected');
        } else {
            items.find('.date-item').removeClass('selected');
            items.eq(2).find('.date-item').addClass('selected');
        }

        items.first().css('opacity', '0.2');
        items.eq(1).css('opacity', '0.5');
        items.eq(2).css('opacity', '1');
        items.eq(3).css('opacity', '0.5');
        items.last().css('opacity', '0.2');

        if(renderLoop > 3) {
            renderSchedule();
        }

        renderLoop++;
    }

    monthCarousel.owlCarousel(carouselOptions);
    dateCarousel.owlCarousel(carouselOptions);

    monthCarousel.trigger('to.owl.carousel', [(new Date()).getMonth(), 200]);
    dateCarousel.trigger('to.owl.carousel', [(new Date()).getDate() - 1, 200]);

    $('.month-item').click(function() {
        const month = $(this).data('position');
        renderLoop = 3;

        monthCarousel.trigger('to.owl.carousel', [month, 200]);
        updateDateCarousel((new Date).getFullYear(), month);
    });

    $('.date-carousel').on('click', '.date-item', function() {
        dateCarousel.trigger('to.owl.carousel', [$(this).data('position'), 200]);
    });

    Scrollbar.initAll();
    renderSchedule();
</script>
@endpush
