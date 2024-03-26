<!-- Org Chart -->

@php
use App\Models\Section\Chart;
$txt = $textContent->where('id',14)->first();
$fr = $frontend->where('file_section','_chart')->first();
@endphp

<div id="orgchart" class="cards-1" style="{{ ($fr->order % 2 != 0) ? 'background-size: cover;' : '' }}">
    <div class="container">
        <div class="row">
            <!-- Placeholder for potential future content -->
        </div> <!-- end of row -->
        <div class="row">
            <div class="col-lg-12">
                <div id="chart-container">
                    @include('front.organization-chart') <!-- Include your organization chart Blade file here -->
                </div>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of cards-1 -->
<!-- end of org chart -->
