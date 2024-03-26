 <!-- Customers -->
 <div class="slider-1">
    @php

    use App\Models\Section\Client;
    $txt = $textContent->where('id',1)->first();
    $clients = Client::orderBy('order','asc')->get();
@endphp

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h5>{{ $txt->title }}</h5>

                <!-- Image Slider -->
                <div class="slider-container">
                    <div class="swiper-container image-slider">
                        <div class="swiper-wrapper">
                            @foreach ($clients as $client)
                            <div class="swiper-slide">
                                <div class="image-container">
                                    <img class="img-responsive" src="{{ asset($client->image)}}" alt="alternative">
                                </div>
                            </div>
                            @endforeach


                        </div> <!-- end of swiper-wrapper -->
                    </div> <!-- end of swiper container -->
                </div> <!-- end of slider-container -->
                <!-- end of image slider -->

            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of slider-1 -->
<!-- end of customers -->
