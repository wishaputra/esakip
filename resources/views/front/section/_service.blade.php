<!-- Services -->
@php
   use App\Models\Section\Service;
$txt = $textContent->where('id',2)->first();
$fr = $frontend->where('file_section','_service')->first();
$services = Service::orderBy('order','asc')->get();
@endphp


<div id="services" class="cards-1" style="{{ ($fr->order % 2 != 0) ? 'background: url(front/evolo/images/contact-background.jpg) center center no-repeat;
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
                @foreach ($services as $service)
                <div class="card">
                    <i class="{{ $service->icon }} fa-7x service-icon"></i>
                    <div class="card-body">
                        <h4 class="card-title">{{ $service->nama }}</h4>
                        <p>{{ $service->deskripsi }}</p>
                    </div>
                </div>
                @endforeach
                <!-- Card -->


            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of cards-1 -->
<!-- end of services -->
