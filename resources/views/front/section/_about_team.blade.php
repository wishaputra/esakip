@if ($teams->count() > 0)
<!-- About -->
@php
$txt = $textContent->where('id',5)->first();
$fr = $frontend->where('file_section','_about_team')->first();
@endphp
<div id="about" class="basic-4" style="{{ ($fr->order % 2 != 0) ? 'background: url(front/evolo/images/contact-background.jpg) center center no-repeat;
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
                @foreach ($teams->take(4) as $team)
                <div class="team-member">
                    <div class="image-wrapper">
                        <img class="img-fluid" src="{{ asset($team->poto)}}" alt="alternative">
                    </div> <!-- end of image-wrapper -->
                    <p class="p-large"><strong>{{ $team->nama}}</strong></p>
                    <p class="job-title">{{ $team->jabatan}}</p>
                    <span class="social-icons">
                        @if ($team->facebook_link)
                        <span class="fa-stack">
                            <a href="{{$team->facebook_link}}">
                                <i class="fas fa-circle fa-stack-2x facebook"></i>
                                <i class="fab fa-facebook-f fa-stack-1x"></i>
                            </a>
                        </span>
                        @endif
                        @if ($team->twitter_link)
                        <span class="fa-stack">
                            <a href="{{$team->twitter_link}}">
                                <i class="fas fa-circle fa-stack-2x twitter"></i>
                                <i class="fab fa-twitter fa-stack-1x"></i>
                            </a>
                        </span>
                        @endif


                    </span> <!-- end of social-icons -->
                </div>
                @endforeach




            </div> <!-- end of col -->
        </div>
        @if ($teams->count() > 4)
        <div class="row">
            <a id="btnTeam" href="{{ route('main.team')}}" class="btn btn-secondary">
                Lihat Selengkapnya
            </a>
        </div><!-- end of row -->
        @endif

    </div> <!-- end of container -->
</div> <!-- end of basic-4 -->

@endif
