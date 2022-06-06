@extends(getTemplate().'.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">
@endpush

@section('content')

    @if(!empty($heroSectionData))

        @if(!empty($heroSectionData['has_lottie']) and $heroSectionData['has_lottie'] == "1")
            @push('scripts_bottom')
                <script src="/assets/default/vendors/lottie/lottie-player.js"></script>
            @endpush
        @endif

        <section class="slider-container  {{ ($heroSection == "2") ? 'slider-hero-section2' : '' }}">

            <div class="container user-select-none">
                    <div class="row slider-content align-items-center hero-section2 flex-column-reverse flex-md-row">
                        <div class="col-12 col-md-7 col-lg-6">
                            <h1 class="text-secondary font-weight-bold">One Portal for all</h1>
                            <p class="slide-hint text-gray mt-20">Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta quasi aut reprehenderit earum veritatis sunt totam praesentium vero magni dicta.</p>

                            <form action="/search" method="get" class="d-inline-flex mt-30 mt-lg-30 w-100">
                                <div class="form-group d-flex align-items-center m-0 slider-search p-10 bg-white w-100">
                                    <input type="text" name="search" class="form-control border-0 mr-lg-50" placeholder="Search for courses or teachers"/>
                                    <button type="submit" class="btn btn-primary rounded-pill">{{ trans('home.find') }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 col-md-5 col-lg-6">
                            <img src="./assets/default/img/young-people-row-with-thumbs-up_1098-2557.webp" alt="picture" class="img-cover">
                        </div>
                    </div>
            </div>
        </section> 
    @endif


    @if(!empty($latestWebinars) and !$latestWebinars->isEmpty())
        <section class="home-sections home-sections-swiper container">
            <div class="d-flex justify-content-between ">
                <div>
                    <h2 class="section-title">{{ trans('home.latest_classes') }}</h2>
                    <p class="section-hint">{{ trans('home.latest_webinars_hint') }}</p>
                </div>

                <a href="/classes?sort=newest" class="btn btn-border-white">{{ trans('home.view_all') }}</a>
            </div>

            <div class="mt-10 position-relative">
                <div class="swiper-container latest-webinars-swiper px-12">
                    <div class="swiper-wrapper py-20">
                        @foreach($latestWebinars as $latestWebinar)
                            <div class="swiper-slide">
                                @include('web.default.includes.webinar.grid-card',['webinar' => $latestWebinar])
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <div class="swiper-pagination latest-webinars-swiper-pagination"></div>
                </div>
            </div>
        </section>
    @endif

    @if(!empty($trendCategories) and !$trendCategories->isEmpty())
        <section class="home-sections home-sections-swiper container">
            <h2 class="section-title">{{ trans('home.trending_categories') }}</h2>
            <p class="section-hint">{{ trans('home.trending_categories_hint') }}</p>

            <div class="row mt-40">

                @foreach($trendCategories as $trend)
                    <div class="col-6 col-md-3 col-lg-2 mt-20 mt-md-0">
                        <a href="{{ $trend->category->getUrl() }}">
                            <div class="trending-card d-flex flex-column align-items-center w-100">
                                <div class="trending-image d-flex align-items-center justify-content-center w-100" style="background-color: {{ $trend->color }}">
                                    <div class="icon mb-3">
                                        <img src="{{ $trend->getIcon() }}" width="10" class="img-cover" alt="{{ $trend->category->title }}">
                                    </div>
                                </div>

                                <div class="item-count px-10 px-lg-20 py-5 py-lg-10">{{ $trend->category->webinars_count }} {{ trans('product.course') }}</div>

                                <h3>{{ $trend->category->title }}</h3>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
    
    @if(!empty($instructors) and !$instructors->isEmpty())
        <section class="home-sections container">
            <div class="d-flex justify-content-between">
                <div>
                    <h2 class="section-title">{{ trans('home.instructors') }}</h2>
                    <p class="section-hint">{{ trans('home.instructors_hint') }}</p>
                </div>

                <a href="/instructors" class="btn btn-border-white">{{ trans('home.all_instructors') }}</a>
            </div>

            <div class="position-relative mt-20 ltr">
                <div class="owl-carousel customers-testimonials instructors-swiper-container">

                    @foreach($instructors as $instructor)
                        <div class="item">
                            <div class="shadow-effect">
                                <div class="instructors-card d-flex flex-column align-items-center justify-content-center">
                                    <div class="instructors-card-avatar">
                                        <img src="{{ $instructor->getAvatar() }}" alt="{{ $instructor->full_name }}" class="rounded-circle img-cover">
                                    </div>
                                    <div class="instructors-card-info mt-10 text-center">
                                        <a href="{{ $instructor->getProfileUrl() }}" target="_blank">
                                            <h3 class="font-16 font-weight-bold text-dark-blue">{{ $instructor->full_name }}</h3>
                                        </a>

                                        <p class="font-14 text-gray mt-5">{{ $instructor->bio }}</p>
                                        <div class="stars-card d-flex align-items-center justify-content-center mt-10">
                                            @php
                                                $i = 5;
                                            @endphp
                                            @while(--$i >= 5 - $instructor->rates())
                                                <i data-feather="star" width="20" height="20" class="active"></i>
                                            @endwhile
                                            @while($i-- >= 0)
                                                <i data-feather="star" width="20" height="20" class=""></i>
                                            @endwhile
                                        </div>

                                        @if(!empty($instructor->hasMeeting()))
                                            <a href="{{ $instructor->getProfileUrl() }}?tab=appointments" class="btn btn-primary btn-sm rounded-pill mt-15">{{ trans('home.reserve_a_live_class') }}</a>
                                        @else
                                            <a href="{{ $instructor->getProfileUrl() }}" class="btn btn-primary btn-sm rounded-pill mt-15">{{ trans('public.profile') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
    @endif

@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="/assets/default/vendors/owl-carousel2/owl.carousel.min.js"></script>
    <script src="/assets/default/js/parts/home.min.js"></script>
    <script src="/assets/default/vendors/parallax/parallax.min.js"></script>
    <script>
        $(document).ready(function () {
            for (var i = 1; i <= 6; i++) {
                new Parallax(document.getElementById('parallax' + i), {
                    relativeInput: true
                });
            }
        })
    </script>
@endpush
