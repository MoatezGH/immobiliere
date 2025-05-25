<style>
    @media only screen and (max-width: 600px) {
        /* .hero-background {
            background-size: contain !important;
            margin-top: -200px !important;
        }

        .owl-nav {
            display: none;
        }

        .search-area {
            margin-top: -330px;
        } */
        .hero-background {
            background-size: contain !important;
            margin-top: -320px !important;

        }

        .owl-nav {
            display: none;
        }

        /* .search-area {
            margin-top: -420px;
        } */
.owl-nav {
            display: none;
        }

        .hero-section {
            height: 50vh;
        }
        .owl-stage-outer{
            height: 50vh;
        }
        .hero-slider {
            height: 50vh;
        }
        .owl-stage{
            height: 50vh;
        }
        .owl-item{
            height: 50vh;
        }
        .hero-single::before{
            height: 50vh;

        }

    }

    .hero-background {
        height: 1000px;
    }
</style>
<div class="hero-section ">
    <div class="hero-slider owl-carousel owl-theme">

        @foreach ($sliders as $item)
            <div class="hero-single hero-background slider-item"
                style="background:url({{ asset('uploads/sliders/' . $item->alt) }});"
                data-id="{{ $item->id }}" data-url="{{ $item->url ? $item->url : '#' }}">

            </div>
        @endforeach


    </div>
</div>