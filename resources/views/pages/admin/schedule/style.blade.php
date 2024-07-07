@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<link rel="stylesheet" href="https://unpkg.com/smooth-scrollbar@latest/dist/smooth-scrollbar.css">

<style>
    #time-container {
        height: 25rem;
    }

    .month-item.selected {
        font-weight: bold;
    }

    .date-item .date-number {
        color: white;
        border-radius: 100%;
        padding: 10px;
        height: 30px;
        width: 30px;
        margin: 0;
    }

    .time-item {

    }

    .time-item-border {
        width: 100%;
        position: relative;
        border-bottom: 2px dashed #e4e6eb;

        .card {
            top: -20px;
            width: 100%;
            position: absolute;
        }

        .time-item-duration p {
            font-size: .8rem;
        }

        .profile-img {
            background-color: #667bc6;
            width: 30px;
            aspect-ratio: 1 / 1;
            border-radius: 100%;
            margin-left: -12.5px;
            border: 1px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: .8rem;
        }
    }

    .schedule-item {
        cursor: pointer;
    }

    .next-schedule-icons {
        margin-top: 15px;
        font-size: .9rem;
        color: #1f2937;
    }
</style>
@endpush
