 <section id="contact" class="wow fadeInUp">
     <div class="container">
         <div class="section-header">
             <h2>Kontak</h2>
             {{-- <p>Sed tamen tempor magna labore dolore dolor sint tempor duis magna elit veniam aliqua esse amet
                 veniam enim export quid quid veniam aliqua eram noster malis nulla duis fugiat culpa esse aute
                 nulla ipsum velit export irure minim illum fore</p> --}}
         </div>

         <div class="row contact-info">

             <div class="col-md-4">
                 <div class="contact-address">
                     <i class="ion-ios-location-outline"></i>
                     <h3>Address</h3>
                     <address>{{ $cms['app_address'] }}</address>
                 </div>
             </div>

             <div class="col-md-4">
                 <div class="contact-phone">
                     <i class="ion-ios-telephone-outline"></i>
                     <h3>Phone Number</h3>
                     <p><a href="tel:{{ $cms['app_phone'] }}">{{ $cms['app_phone'] }}</a></p>
                 </div>
             </div>

             <div class="col-md-4">
                 <div class="contact-email">
                     <i class="ion-ios-email-outline"></i>
                     <h3>Email</h3>
                     <p><a href="mailto:{{ $cms['app_email'] }}">{{ $cms['app_email'] }}</a></p>
                 </div>
             </div>

         </div>
     </div>

     <div class="container mb-4">
         <iframe src="{{ $cms['app_map'] }}" width="100%" height="380" style="border:0;" allowfullscreen=""
             loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
     </div>

 </section>
