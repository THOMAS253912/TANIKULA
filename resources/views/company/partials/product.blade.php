 <section id="portfolio" class="wow fadeInUp">
     <div class="container">
         <div class="section-header">
             <h2>Produk Kami</h2>
             {{-- <p>Sed tamen tempor magna labore dolore dolor sint tempor duis magna elit veniam aliqua esse amet
                        veniam enim export quid quid veniam aliqua eram noster malis nulla duis fugiat culpa esse aute
                        nulla ipsum velit export irure minim illum fore</p> --}}
         </div>
     </div>

     <div class="container-fluid">
         <div class="row no-gutters">

             @forelse ($product as $item)
                 <div class="col-lg-3 col-md-4">
                     <div class="portfolio-item wow fadeInUp">
                         <a href="/home/{{ $item->slug }}" target="blank">
                             <img src="{{ asset('/storage/produk') . '/' . $item->image }}" alt=""
                                 class="img-portofolio">
                             <div class="portfolio-overlay">
                                 <div class="portfolio-info">
                                     <h2 class="wow fadeInUp">{{ $item->name }}</h2>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>

             @empty

                 <div class="col-lg-3 col-md-4">
                     <div class="portfolio-item wow fadeInUp">
                         <a href="{{ asset('assets/company/img/portfolio/1.jpg') }}" class="portfolio-popup">
                             <img src="{{ asset('assets/company/img/portfolio/1.jpg') }}" alt="">
                             <div class="portfolio-overlay">
                                 <div class="portfolio-info">
                                     <h2 class="wow fadeInUp">Portfolio Item 1</h2>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>

                 <div class="col-lg-3 col-md-4">
                     <div class="portfolio-item wow fadeInUp">
                         <a href="{{ asset('assets/company/img/portfolio/2.jpg') }}" class="portfolio-popup">
                             <img src="{{ asset('assets/company/img/portfolio/2.jpg') }}" alt="">
                             <div class="portfolio-overlay">
                                 <div class="portfolio-info">
                                     <h2 class="wow fadeInUp">Portfolio Item 2</h2>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>

                 <div class="col-lg-3 col-md-4">
                     <div class="portfolio-item wow fadeInUp">
                         <a href="{{ asset('assets/company/img/portfolio/3.jpg') }}" class="portfolio-popup">
                             <img src="{{ asset('assets/company/img/portfolio/3.jpg') }}" alt="">
                             <div class="portfolio-overlay">
                                 <div class="portfolio-info">
                                     <h2 class="wow fadeInUp">Portfolio Item 3</h2>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>

                 <div class="col-lg-3 col-md-4">
                     <div class="portfolio-item wow fadeInUp">
                         <a href="{{ asset('assets/company/img/portfolio/4.jpg') }}" class="portfolio-popup">
                             <img src="{{ asset('assets/company/img/portfolio/4.jpg') }}" alt="">
                             <div class="portfolio-overlay">
                                 <div class="portfolio-info">
                                     <h2 class="wow fadeInUp">Portfolio Item 4</h2>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>

                 <div class="col-lg-3 col-md-4">
                     <div class="portfolio-item wow fadeInUp">
                         <a href="{{ asset('assets/company/img/portfolio/5.jpg') }}" class="portfolio-popup">
                             <img src="{{ asset('assets/company/img/portfolio/5.jpg') }}" alt="">
                             <div class="portfolio-overlay">
                                 <div class="portfolio-info">
                                     <h2 class="wow fadeInUp">Portfolio Item 5</h2>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>

                 <div class="col-lg-3 col-md-4">
                     <div class="portfolio-item wow fadeInUp">
                         <a href="{{ asset('assets/company/img/portfolio/6.jpg') }}" class="portfolio-popup">
                             <img src="{{ asset('assets/company/img/portfolio/6.jpg') }}" alt="">
                             <div class="portfolio-overlay">
                                 <div class="portfolio-info">
                                     <h2 class="wow fadeInUp">Portfolio Item 6</h2>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>

                 <div class="col-lg-3 col-md-4">
                     <div class="portfolio-item wow fadeInUp">
                         <a href="{{ asset('assets/company/img/portfolio/7.jpg') }}" class="portfolio-popup">
                             <img src="{{ asset('assets/company/img/portfolio/7.jpg') }}" alt="">
                             <div class="portfolio-overlay">
                                 <div class="portfolio-info">
                                     <h2 class="wow fadeInUp">Portfolio Item 7</h2>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>

                 <div class="col-lg-3 col-md-4">
                     <div class="portfolio-item wow fadeInUp">
                         <a href="{{ asset('assets/company/img/portfolio/8.jpg') }}" class="portfolio-popup">
                             <img src="{{ asset('assets/company/img/portfolio/8.jpg') }}" alt="">
                             <div class="portfolio-overlay">
                                 <div class="portfolio-info">
                                     <h2 class="wow fadeInUp">Portfolio Item 8</h2>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>
             @endforelse

         </div>

     </div>
 </section><!-- #portfolio -->
