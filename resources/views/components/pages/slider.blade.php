<div class="slider-head mt-5">
    <!-- Start Hero Slider -->
    <div class="hero-slider">
        @php
            $heroes = App\Models\Hero::latest()->get();
        @endphp
        @if ($heroes->count() > 0)
            @foreach ($heroes as $hero)
            <!-- Start Single Slider -->
            <div class="single-slider"
                style="background-image: url('{{ asset('../storage/hero/' . $hero->image) }}');">
                {{-- <div class="content">
                    <h2 class="fw-bold text-secondary">
                        {{ $hero->name }}
                    </h2>
                </div> --}}
            </div>
            <!-- End Single Slider -->
            @endforeach
        @else
            <div class="single-slider"
                style="background-image: url('https://images.unsplash.com/photo-1515276427842-f85802d514a2?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=876&q=80');">
            </div>
            <div class="single-slider"
                style="background-image: url('https://images.unsplash.com/photo-1624806992928-9c7a04a8383d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80');">
            </div>
        @endif
    </div>
    <!-- End Hero Slider -->
</div>
