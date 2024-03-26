


@php
  use App\Models\Section\Slider;
$slider = Slider::orderBy('order','asc')->get();


@endphp

<div class="home-area" style="margin-top:45px;">
    <div class="home-slides owl-carousel owl-theme" >
        @forelse ($slider as $s)
        <div class="hero-banner" style="background-image: url({{$s->getImage()}});">
            @if($s->title != "")
                <div class="main-banner-content">
                    <a href="{{ $s->link }}"><h1>{{ $s->title }}</h1></a>
                    <p>{{ $s->description }}</p>
                </div>
            @endif
        </div>
        @empty
        <div class="hero-banner " style="background-image: url(https://via.placeholder.com/960x760.png)"></div>
        @endforelse
    </div>
</div>


  @push('script')
  <script>
      $(document).ready(function(){

  $('.owl-carousel').owlCarousel({
			loop: true,
			nav: true,
            dots: false,
            animateOut: 'fadeOut',
	
            autoplay: true,
            mouseDrag: false,
            items: 1,
            navText: [

                "<i class='fas fa-chevron-left'></i>",
                "<i class='fas fa-chevron-right'></i>"
            ],
        });

});
  </script>

  @endpush
