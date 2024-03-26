@include('front.partials._head_tag')

<body data-spy="scroll" data-target=".fixed-top">

    <!-- Preloader -->
	<div class="spinner-wrapper">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
    <!-- end of preloader -->


  @include('front.partials._navigation')


    <!-- Header -->
    <header id="header" class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{$post->title}}</h1>
                    @if ($post->type == 'blog')
                    <ul id="ket_post">
                        <li> <i class="fas fa-user "></i> {{$post->created_by }}</li>
                        <li> <i class="fas fa-clock "></i> {{$post->created_at }}</li>
                        <li> <i class="fas fa-folder "></i> {{$post->category->nama }}</li>
                    </ul>

                    @endif
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <!-- end of header -->


    <!-- Breadcrumbs -->
    <div class="ex-basic-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumbs">
                        <a href="{{URL::to('/')}}">Home</a>
                        <i class="fa fa-angle-double-right"></i>
                        <span>{{ ucfirst(Request::segment(1)) }}</span>
                        <i class="fa fa-angle-double-right"></i>
                        <span>{{$post->title}}</span>
                    </div> <!-- end of breadcrumbs -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of ex-basic-1 -->
    <!-- end of breadcrumbs -->


    <!-- Privacy Content -->
    <div class="ex-basic-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <center>
                        <img src="{{ $post->getImage()}}" alt="">
                    </center>
                    <br>
                    Tes
                    <object data="{{ url('storage/files/triwulan/Bapelitbangda.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>
                    {!! $post->content !!}

                </div> <!-- end of col-->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of ex-basic-2 -->
    <!-- end of privacy content -->





    @include('front.partials._footer')


