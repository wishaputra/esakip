@extends('layouts.app')
@section('title')

@endsection

@push('style')
<!-- Include Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@section('content')

<div class="page has-sidebar-left bg-light">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4>
                        <i class="icon-box"></i>
                    </h4>
                </div>
            </div>
            <div class="row">
                <ul class="nav responsive-tab nav-material nav-material-white" id="v-pills-tab">
                    <li>
                        <a class="nav-link active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1">
                            <i class="icon icon-list"></i>Semua Data</a>
                    </li>
                    <li>
                        <a class="nav-link" id="tambah-data-link" href="#">
                            <i class="icon icon-plus-circle"></i>Tambah Data</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container-fluid relative animatedParent animateOnce">
        <div class="tab-content pb-3" id="v-pills-tabContent">
            <div class="tab-pane animated fadeInUpShort show active" id="v-pills-1">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-3 mt-3 shadow r-0">
                            <div class="card-header white">
                            </div>
                            <div class="card-body">
                                <table class="table" id="menu-table">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td width="20%">Nama</td>
                                            <td>No Urut</td>
                                            <td>Route</td>
                                            <td>Submenu</td>
                                            <td width="10%">Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="form-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                    {{ method_field('POST') }}
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">No Urut</label>
                                <input type="number" name="no_urut" id="no_urut" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">Route</label>
                                <input type="text" name="route" id="route" placeholder="#div or routename" class="form-control">
                            </div>
                        </div>
                    </div>
                    <!-- Add Summernote textarea field for description -->
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description" class="col-form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="action" class="btn btn-primary tButton">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Include jQuery before including Summernote JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Summernote JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    // Initialize Summernote
    $(document).ready(function() {
        $('#description').summernote({
            height: 150 // Set the height of the editor
        });
        
        // Handle click event on "Tambah Data" link
        $('#tambah-data-link').click(function(event) {
            event.preventDefault(); // Prevent default link behavior
            $('#form-modal').modal('show'); // Show the modal
        });
    });
</script>
@endpush
