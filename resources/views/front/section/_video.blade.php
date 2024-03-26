<!-- Video -->
@php
   use App\Models\Section\Video;
$txt = $textContent->where('id',14)->first();
$fr = $frontend->where('file_section','_video')->first();
$videos = Video::orderBy('order','asc')->get();
@endphp


<div id="videos" class="cards-1" style="{{ ($fr->order % 2 != 0) ? 'background: url(front/evolo/images/contact-background.jpg) center center no-repeat;
    background-size: cover;'  : '' }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>{{ $txt->title }}</h2>
                <p class="p-heading p-large">{{ $txt->description }}</p>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
        <div class="row">
            <div class="col-lg-12">
                @foreach ($videos as $video)
                {{-- <div class="card">
                    <i class="{{ $video->icon }} fa-7x service-icon"></i>
                    <div class="card-body">
                        <h4 class="card-title">{{ $video->nama }}</h4>
                        <p>{{ $video->deskripsi }}</p>
                    </div>
                </div> --}}
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="{{ $video->link }}" allowfullscreen></iframe>
                </div><br>
                @endforeach
                <!-- Card -->


            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of cards-1 -->
<!-- end of videos -->
