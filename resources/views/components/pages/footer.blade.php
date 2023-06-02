<footer class="footer shadow">
    <!-- Start Footer Top -->
    <div class="footer-top" style="border-bottom: 1px solid #16A085;">
        <div class="container">
            <div class="inner-content">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="footer-logo">
                            <a onclick="home('{{ url('home') }}')" href="#">
                                <h3 style="color: #16A085">TaniKula</h3>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Top -->
    <!-- Start Footer Middle -->
    <div class="footer-middle">
        <div class="container">
            <div class="bottom-inner">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Single Widget -->
                        <div class="single-footer f-contact">
                            <h3>Hubungi Kami</h3>
                            <p class="phone">Telp: (+62) 33 169 7720</p>
                            <ul>
                                <li><span>Senin-Sabtu: </span> 9.00 am - 8.00 pm</li>
                                <li><span>Minggu: </span> 10.00 am - 6.00 pm</li>
                            </ul>
                            <p class="mail">
                                <a href="mailto:tanikula.app@gmail.com">tanikula.app@gmail.com</a>
                            </p>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Single Widget -->
                        <div class="single-footer f-link">
                            <h3>Informasi</h3>
                            <ul>
                                <li><a href="javascript:void(0)">Tentang Kami</a></li>
                                <li><a onclick="hubungi_kami('{{ url('hubungi-kami') }}')" href="#" class="{{ Request::is('hubungi-kami') ? 'active' : '' }}">Hubungi Kami</a></li>
                            </ul>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Single Widget -->
                        <div class="single-footer f-link">
                            <h3>Kategori Produk</h3>
                            @php
                                $category_product = App\Models\ProductCategory::where('is_active', '=', 1)->take(5)->get();
                            @endphp
                            <ul>
                                @foreach ($category_product as $item)
                                    <li><a href="{{ url('product-category/'.$item->slug) }}">{{ $item->name }} </a></li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Single Widget -->
                        <div class="single-footer our-app">
                            <h3>Aplikasi Seluler Kami</h3>
                            <ul class="app-btn">
                                <li>
                                    <a href="javascript:void(0)" style="background: #16A085; color: white">
                                        <i class="lni lni-play-store"></i>
                                        <span class="small-title fw-bold" style="color: white">Download on the</span>
                                        <span class="big-title fw-bold" style="color: white">Google Play</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Middle -->
    <!-- Start Footer Bottom -->
</footer>
