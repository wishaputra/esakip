@php
    use App\Models\Section\Intro;
    $intro = Intro::first();
@endphp

<!-- Header -->
<header id="header" class="header">
    <div class="header-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="text-container">
                        <h1><span class="turquoise">{{ $intro->title }}</span><br> {{ $intro->subtitle }}</h1>
                        <p class="p-large">{{ $intro->description }}</p>
                        <a class="btn-solid-lg page-scroll"
                            href="{{ $intro->href_button }}">{{ $intro->text_button }}</a>
                    </div> <!-- end of text-container -->
                </div> <!-- end of col -->
                <div class="col-lg-6">
                    <div class="image-container">
                        <img class="img-fluid" src="{{ asset($intro->image)}}" alt="alternative">
                    </div> <!-- end of image-container -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of header-content -->
</header> <!-- end of header -->
<!-- end of header -->
