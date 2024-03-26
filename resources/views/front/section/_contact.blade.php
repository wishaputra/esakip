<!-- Contact -->
<?php
$fr = $frontend->where('file_section','_contact')->first();
?>
<div id="contact" class="form-2" style="{{ ($fr->order % 2 != 0) ? 'background: url(front/evolo/images/contact-background.jpg) center center no-repeat;
    background-size: cover;'  : '' }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                @php
                $contact = $textContent->where('id',6)->first();
                @endphp
                <h2>{{ $contact->title }}</h2>
                <ul class="list-unstyled li-space-lg">
                    <li class="address">{{ $contact->description }}</li>
                    <li><i class="fas fa-map-marker-alt"></i>{{ $contact->alamat }}</li>
                    <li><i class="fas fa-phone"></i><a class="turquoise"
                            href="tel:003024630820">{{ $contact->telp }}</a>
                    </li>
                    <li><i class="fas fa-envelope"></i><a class="turquoise" href="#"> {{ $contact->email }}</a></li>
                </ul>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
        <div class="row">
            <div class="col-lg-6">
                <div class="map-responsive">
                    <iframe src="{{ $contact->link_maps }}" allowfullscreen></iframe>
                </div>
            </div> <!-- end of col -->
            <div class="col-lg-6">

                <!-- Contact Form -->
                <form id="contactFrm" data-toggle="validator" data-focus="false" autocomplete="off">
                    @csrf
                    @method('POST')
                    <div id="alert">

                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control-input" name="name" id="name" required>
                        <label class="label-control" for="cname">Nama</label>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control-input" name="phone" id="phone" required>
                        <label class="label-control" for="cname">No. Handphone</label>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control-input" name="email" id="email" required>
                        <label class="label-control" for="cemail">Email</label>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label class="" for="">Isi Pesan</label>
                        <textarea class="form-control-textarea" id="message" name="message"  required></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                    {{-- <div class="form-group checkbox">
                        <input type="checkbox" id="cterms" value="Agreed-to-Terms" required>I have read and agree
                        with Evolo's stated <a href="privacy-policy.html">Privacy Policy</a> and <a
                            href="terms-conditions.html">Terms Conditions</a>
                        <div class="help-block with-errors"></div>
                    </div> --}}
                    <div class="form-group">
                        <button type="submit" id="action"
                            class="form-control-submit-button">{{ $contact->text_button}}</button>
                    </div>
                    <div class="form-message">
                        <div id="cmsgSubmit" class="h3 text-center hidden"></div>
                    </div>
                </form>
                <!-- end of contact form -->

            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of form-2 -->
<!-- end of contact -->

@push('script')
<script>
    $('#contactFrm').on('submit', function (a) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }else{
            $('#alert').html('');
            $('#action').attr('disabled', true);

            url = "{{ route('front.contact_store') }}" ;
            $.ajax({
                url : url,
                type : 'POST',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                success : function(data) {
                    $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");

                    $.alert({
                            title: 'Success!',
                            type: 'green',
                            content: data.message,
                        });
                        $('#contactFrm').trigger('reset');
                },
                error : function(data){
                    err = ''; respon = data.responseJSON;
                    $.each(respon.errors, function(index, value){
                        err += "<li>" + value +"</li>";
                    });
                    $('#alert').html("<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " + respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                },
                complete : function(data){
                    $('#action').removeAttr('disabled');
                }
            });

            return false;
        }
        $(this).addClass('was-validated');
    });
</script>
@endpush
