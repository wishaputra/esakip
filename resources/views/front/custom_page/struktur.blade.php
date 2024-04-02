@extends('front.custom_page.layout')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
@endpush

@section('content')
    <header id="header" class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{$title}}</h1>
                </div>
            </div>
        </div>
    </header>

    <div id="allSampleContent" class="p-4 w-full">
        <!-- Organization Chart container -->
        <div id="myDiagramDiv" style="background-color: white; border: 1px solid black; height: 550px; position: relative; -webkit-tap-highlight-color: rgba(255, 255, 255, 0); cursor: auto;"></div>

        <!-- Buttons -->
        <div style="display: flex; justify-content: flex-end; margin-top: 10px;">
        </div>

        <!-- Properties Panel -->
        <div id="propertiesPanel" style="display: none; background-color: aliceblue; border: solid 1px black">
            <!-- Properties content here -->
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/gojs@2.3.14/release/go.js"></script>
    <script src="{{ asset('js/orgchart2.js') }}"></script>
@end