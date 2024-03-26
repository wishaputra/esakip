<!-- Testimonials -->

@php
use App\Models\Section\Testimoni;
 $testimonies = Testimoni::orderBy('order','asc')->get();
$txt = $textContent->where('id',4)->first();
@endphp
<div class="slider-2" id="testimonials">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="image-container">
                    <img class="img-fluid" src="{{ asset('front/evolo/images/testimonials-2-men-talking.svg')}}"
                        alt="alternative">
                </div> <!-- end of image-container -->
            </div> <!-- end of col -->
            <div class="col-lg-6">
                <h2>{{ $txt->title }}</h2>

                <!-- Card Slider -->
                <div class="slider-container">
                    <div class="swiper-container card-slider">
                        <div class="swiper-wrapper">
                            @foreach ($testimonies as $testimoni)

                            <!-- Slide -->
                            <div class="swiper-slide">
                                <div class="card">
                                    <img class="card-image" src="{{ asset($testimoni->poto)}}" alt="alternative">
                                    <div class="card-body">
                                        <p class="testimonial-text">{{ $testimoni->testimoni}}</p>
                                        <p class="testimonial-author">{{ $testimoni->nama}} -
                                            {{ $testimoni->profesi}}</p>
                                    </div>
                                </div>
                            </div> <!-- end of swiper-slide -->
                            <!-- end of slide -->

                            @endforeach




                        </div> <!-- end of swiper-wrapper -->

                        <!-- Add Arrows -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <!-- end of add arrows -->

                    </div> <!-- end of swiper-container -->
                </div> <!-- end of slider-container -->
                <!-- end of card slider -->

            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of slider-2 -->
<!-- end of testimonials -->
