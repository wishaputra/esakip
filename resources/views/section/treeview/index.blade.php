{{-- Layout --}}
@extends('layouts.app')

{{-- Page Title --}}
@section('title', $title)

{{-- Custom Styles --}}
@push('style')
<!-- Styles can be added here -->
@endpush

{{-- Main Content --}}
@section('content')
<div id="myDiagramDiv" style="width: 100%; height: 600px; border: 1px solid lightgray;"></div>

<!-- Modal for Form -->
<div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="form-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="form-modalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert"></div>
                <form class="needs-validation" id="form" method="POST" autocomplete="off" novalidate>
                    @method('POST')
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <!-- Your form fields go here -->
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Custom Scripts --}}
@push('scripts')
<script src="https://unpkg.com/gojs/release/go.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> {{-- Ensure you have jQuery available --}}
<script>
    function init() {
        var $ = go.GraphObject.make; // for conciseness in defining templates
        var myDiagram = $(go.Diagram, "myDiagramDiv", {
            layout: $(go.TreeLayout, { angle: 90, layerSpacing: 35 })
        });

        // Define the Node template
        myDiagram.nodeTemplate =
            $(go.Node, "Horizontal",
                $(go.TextBlock, new go.Binding("text", "nama")),
                // Add more bindings as necessary
            );

        // Define the Link template
        myDiagram.linkTemplate =
            $(go.Link, $(go.Shape)); // simple link template

        // Load the tree data from the server
        fetchTreeData();
    }

    function fetchTreeData() {
        $.ajax({
            url: "{{ route('setup.section.tree.api') }}", // Use the route name you've defined in web.php
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if(data) {
                    // Assuming 'data' is the array of tree nodes
                    myDiagram.model = new go.TreeModel(data.data); // Adjust based on your actual JSON structure
                }
            },
            error: function(error) {
                console.error("Error fetching tree data:", error);
            }
        });
    }

    window.addEventListener('DOMContentLoaded', init);
</script>
@endpush
