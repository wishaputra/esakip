 @php
 use App\Models\TextContent;
 $link = DB::table('footer_link')
 ->select('content')
 ->orderBy('order')
 ->get();
 $social = DB::table('footer_link_social')
 ->select('icon','name','link')
 ->orderBy('order')
 ->get();
 @endphp

 @php
 $txt1 = $textContent->where('id',9)->first();
 $txt2 = $textContent->where('id',10)->first();
 $txt3 = $textContent->where('id',11)->first();
 @endphp

 <!-- Footer -->
 <div class="footer">
     <div class="container">
         <div class="row">
             <div class="col-md-4">
                 <div class="footer-col">
                     <h4>{{ $txt1->title }}</h4>
                     {!! $txt1->content !!}
                 </div>
             </div> <!-- end of col -->
             <div class="col-md-4">
                 <div class="footer-col middle footer-middle">
                     <h4>{{ $txt2->title }}</h4>
                     <ul class="list-unstyled li-space-lg">
                         @foreach ($link as $l)
                         <li class="media">
                             <i class="fas fa-square"></i>
                             <div class="media-body">
                                 {!! $l->content !!}
                             </div>
                         </li>
                         @endforeach


                     </ul>
                 </div>
             </div> <!-- end of col -->
             <div class="col-md-4">
                 <div class="footer-col last">
                     <h4>{{ $txt3->title }}</h4>
                     @foreach ($social as $s)
                     @if ($s->link != "#")


                     <span class="fa-stack">
                         <a href="{{ $s->link}}">
                             <i class="fas fa-circle fa-stack-2x"></i>
                             <i class="{{ $s->icon}} fa-stack-1x"></i>
                         </a>
                     </span>
                     @endif
                     @endforeach


                 </div>
             </div> <!-- end of col -->
         </div> <!-- end of row -->
     </div> <!-- end of container -->
 </div> <!-- end of footer -->
 <!-- end of footer -->


 <!-- Copyright -->
 <div class="copyright">
     <div class="container">
         <div class="row">
             <div class="col-lg-12">
                 <p class="p-small">E-ORG - Kota Tangerang Selatan &copy; <?php echo date("Y "); ?>. All rights reserved</p>
             </div> <!-- end of col -->
         </div> <!-- enf of row -->
     </div> <!-- end of container -->
 </div> <!-- end of copyright -->
 <!-- end of copyright -->

 <!-- Scripts -->
 <script src="{{ asset('front/evolo/js/jquery.min.js')}}"></script>
 <!-- jQuery for Bootstrap's JavaScript plugins -->
 <script src="{{ asset('front/evolo/js/popper.min.js')}}"></script> <!-- Popper tooltip library for Bootstrap -->
 <script src="{{ asset('front/evolo/js/bootstrap.min.js')}}"></script> <!-- Bootstrap framework -->
 <script src="{{ asset('front/evolo/js/jquery.easing.min.js')}}"></script>
 <!-- jQuery Easing for smooth scrolling between anchors -->
 <script src="{{ asset('front/evolo/js/swiper.min.js')}}"></script> <!-- Swiper for image and text sliders -->
 <script src="{{ asset('front/evolo/js/jquery.magnific-popup.js')}}"></script> <!-- Magnific Popup for lightboxes -->
 <script src="{{ asset('front/evolo/js/validator.min.js')}}"></script>
 <!-- Validator.js - Bootstrap plugin that validates forms -->
 <script src="{{ asset('front/evolo/js/scripts.js')}}"></script>
 <script src="{{ asset('js/jquery-confirm.min.js') }}"></script> <!-- Custom scripts -->
 <script src="{{ asset('plugins/owl/owl.carousel.min.js') }}"></script> <!-- Custom scripts -->




 @stack('script')

 </body>

 </html>