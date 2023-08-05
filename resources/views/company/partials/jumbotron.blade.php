  <section id="intro">

      <div class="intro-content"></div>

      <div id="intro-carousel" class="owl-carousel">
      @forelse ($cms['app_slider'] as $item)
          <div class="item" style="background-image: url('/assets/company/slider/{{$item}}')"></div>
      @empty

          <div class="item" style="background-image: url('/assets/company/img/portfolio/7.jpg')"></div>
          <div class="item" style="background-image: url('/assets/company/img/portfolio/2.jpg')"></div>
          <div class="item" style="background-image: url('/assets/company/img/portfolio/3.jpg')"></div>
          <div class="item" style="background-image: url('/assets/company/img/portfolio/4.jpg')"></div>
          <div class="item" style="background-image: url('/assets/company/img/portfolio/5.jpg')"></div>

          @endforelse
        </div>
  </section>
