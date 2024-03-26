<!-- Pricing -->
@php

use App\Models\Section\Pricing;
$txt = $textContent->where('id',3)->first();
$fr = $frontend->where('file_section','_pricing')->first();
$pricings = Pricing::orderBy('order','asc')->get();
@endphp
<div id="pricing" class="cards-2" style="{{ ($fr->order % 2 != 0) ? 'background: url(front/evolo/images/contact-background.jpg) center center no-repeat;
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
                @foreach ($pricings as $pricing)
                <div class="card">
                    @if ($pricing->badge_text)
                    <div class="label">
                        <p class="best-value">{{$pricing->badge_text}}</p>
                    </div>
                    @endif
                    <div class="card-body">
                        <div class="card-title">{{$pricing->nama}}</div>
                        <div class="card-subtitle">{{$pricing->deskripsi}}</div>
                        <hr class="cell-divide-hr">
                        <div class="price">

                            <span class="currency">Rp</span><span class="value">{{ $pricing->harga}}</span>
                            <div class="frequency">{{$pricing->durasi}}</div>
                        </div>
                        <hr class="cell-divide-hr">
                        <ul class="list-unstyled li-space-lg">
                            @foreach ($pricing->pricing_lists as $pricing_list)
                            <li class="media">
                                <i class="fas {{ $pricing_list->check == 1 ? 'fa-check':'fa-times'}} "></i>
                                <div class="media-body">{{$pricing_list->nama}}</div>
                            </li>
                            @endforeach

                        </ul>
                        <div class="button-wrapper">
                            <a class="btn-solid-reg page-scroll"
                                href="{{$pricing->link_button}}">{{$pricing->text_button}}</a>
                        </div>
                    </div>
                </div>
                @endforeach


            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of cards-2 -->
<!-- end of pricing -->
