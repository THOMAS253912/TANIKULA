@extends('pages.template2')
@section('title', 'Home')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<style>
    /*===== BLOG STYLE ONE =====*/
    .blog-edukasi {
        margin-top: 50px;
        /* background-color: beige; */
        border-radius: 10px;
    }

    .blog-edukasi .blog-image-edukasi {
        overflow: hidden;
        position: relative;
        border-radius: 10px 10px 0 0;
    }

    .blog-edukasi .blog-image-edukasi .category-edukasi {
        background-color: #16A085;
        color: white;
        font-size: 13px;
        padding: 7px 20px;
        position: absolute;
        right: 20px;
        top: 20px;
        border-radius: 30px;
    }

    .blog-edukasi .blog-image-edukasi .video-content {
        position: relative;
        border-radius: 10px 10px 0 0;
        overflow: hidden;
    }

    .blog-edukasi .blog-image-edukasi .video-content video {
        border-radius: 10px 10px 0 0;
        width: 734px;
        height: 300px;
        -o-object-fit: cover;
        object-fit: cover;
        -o-object-position: center;
        object-position: center;
    }

    .blog-edukasi .blog-image-edukasi .video-content a {
        text-align: center;
        background-color: var(--primary);
        color: #16A085;
        font-size: 30px;
        -webkit-transition: all 0.3s ease-out 0s;
        -moz-transition: all 0.3s ease-out 0s;
        -ms-transition: all 0.3s ease-out 0s;
        -o-transition: all 0.3s ease-out 0s;
        transition: all 0.3s ease-out 0s;
    }

    .blog-edukasi .blog-image-edukasi .video-content a:hover {
        background-color: var(--white);
        color: var(--primary);
    }

    .blog-edukasi .blog-image-edukasi img {
        width: 734;
        height: 300px;
        -o-object-fit: cover;
        object-fit: cover;
        -o-object-position: center;
        object-position: center;
        -webkit-transition: all 0.2s ease-out 0s;
        -moz-transition: all 0.2s ease-out 0s;
        -ms-transition: all 0.2s ease-out 0s;
        -o-transition: all 0.2s ease-out 0s;
        transition: all 0.2s ease-out 0s;
    }

    .blog-edukasi .blog-image-edukasi:hover img {
        -webkit-transform: rotate(1deg) scale(1.1);
        -moz-transform: rotate(1deg) scale(1.1);
        -ms-transform: rotate(1deg) scale(1.1);
        -o-transform: rotate(1deg) scale(1.1);
        transform: rotate(1deg) scale(1.1);
    }

    .blog-edukasi .blog-content-edukasi {
        padding: 30px;
        border: 1px solid var(--light-1);
        border-radius: 0 0 8px 8px;
        border-top: none;
    }

    @media (max-width: 767px) {
        .blog-edukasi .blog-image-edukasi img {
            width: 424px;
            height: 300px;
        }

        .blog-edukasi .blog-image-edukasi .video-content video {
            width: 424px;
            height: 300px;
        }
    }

    @media only screen and (min-width: 768px) and (max-width: 991px) {
        .blog-edukasi .blog-content-edukasi {
            padding: 25px;
        }
    }

    @media (max-width: 767px) {
        .blog-edukasi .blog-content-edukasi {
            padding: 20px;
        }
    }

    .blog-edukasi .blog-content-edukasi .blog-title-edukasi {
        display: block;
        margin-bottom: 10px;
    }

    .blog-edukasi .blog-content-edukasi .blog-title-edukasi a {
        font-weight: 600;
        color: var(--black);
        -webkit-transition: all 0.3s ease-out 0s;
        -moz-transition: all 0.3s ease-out 0s;
        -ms-transition: all 0.3s ease-out 0s;
        -o-transition: all 0.3s ease-out 0s;
        transition: all 0.3s ease-out 0s;
        line-height: 30px;
    }

    @media (max-width: 767px) {
        .blog-edukasi .blog-content-edukasi .blog-title-edukasi a {
            line-height: 24px;
        }
    }

    .blog-edukasi .blog-content-edukasi .blog-title-edukasi a:hover {
        color: var(--primary);
    }

    .blog-edukasi .blog-content-edukasi span {
        font-size: 14px;
        line-height: 20px;
        color: var(--dark-3);
        margin-top: 8px;
        margin-right: 12px;
        display: inline-block;
    }

    .blog-edukasi .blog-content-edukasi .text-edukasi {
        color: var(--dark-3);
        margin-top: 16px;
    }

    .blog-edukasi .blog-content-edukasi .more-edukasi {
        text-transform: uppercase;
        font-weight: 600;
        color: var(--primary);
        margin-top: 30px;
        display: inline-block;
    }

    .blog-edukasi .blog-content-edukasi .more-edukasi:hover {
        color: var(--primary-dark);
    }

    /*# sourceMappingURL=blog-01.css.map */
</style>

@section('content')
<!--====== BLOG PART START ======-->
<section class="blog-area pb-5">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        <div class="single-blog blog-edukasi border">
                            <div class="blog-image-edukasi">
                                <a href="{{ url('/edukasi'.'/'.$education->slug) }}">
                                    @php
                                        $ext = pathinfo($education->file, PATHINFO_EXTENSION)
                                    @endphp
                                    @if($ext == 'mp4' || $ext == 'mov' || $ext == 'vob' || $ext == 'mpeg' || $ext == '3gp' || $ext == 'avi' || $ext == 'wmv' || $ext == 'mov' || $ext == 'amv' || $ext == 'svi' || $ext == 'flv' || $ext == 'mkv' || $ext == 'webm' || $ext == 'gif' || $ext == 'asf')
                                    <div class="video-content text-center">
                                        <video src="{{ asset('../storage/edukasi/' . $education->file) }}" alt="Video"/>
                                        <a class="video-popup glightbox"
                                            href="{{ asset('../storage/edukasi/' . $education->file) }}">
                                            <i class="lni lni-play" style="position: absolute; top: 50%; left: 45%;"></i>
                                        </a>
                                    </div>
                                    @elseif ($ext == 'PNG' || $ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'gif' || $ext == 'tiff' || $ext == 'psd' || $ext == 'pdf' || $ext == 'eps' || $ext == 'ai' || $ext == 'indd' || $ext == 'raw')
                                        <img src="{{ asset('../storage/edukasi/' . $education->file) }}" class="img-responsive" alt="Edukasi" />
                                    @elseif (empty($education->file))
                                        <img src="{{ asset('img/no-image.png') }}" class="img-responsive" alt="Edukasi" />
                                    @endif
                                </a>
                                <a href="{{ url('/edukasi?kategori-edukasi='.$education->education_category->slug) }}" class="category-edukasi">
                                    @if (empty($education->education_category->name))
                                    Tidak ada kategori
                                    @else
                                    {{ $education->education_category->name }}
                                    @endif
                                </a>
                            </div>
                            <div class="blog-content-edukasi">
                                <h5 class="blog-title-edukasi text-capitalize d-flex flex-row align-items-center justify-content-between">
                                    {{$education->title}}
                                    @foreach ($education->historyEducation->take(1) as $history)
                                        @if ($history->education_id == $education->id)
                                            <i class="bi bi-star-fill h-4" style="color: orange"></i>
                                        @endif
                                    @endforeach
                                </h5>
                                <div class="d-flex flex-row justify-content-between align-items-center">
                                    <p><i class="fas fa-solid fa-calendar-day"></i> {{ date("d F Y", strtotime($education->date))}}</p>
                                    <p class="d-none d-sm-block">
                                        <a href="{{ url('/edukasi?diposting-oleh='.$education->user->name) }}"
                                            style="color: var(--primary);">
                                            <i class="fa-solid fa-user"></i>
                                            @if (empty($education->user->name))
                                            Tidak ada author
                                            @else
                                            {{$education->user->name}}
                                            @endif
                                        </a>
                                    </p>
                                    @if (empty($education->created_at))
                                    <p class="d-none d-sm-block">
                                        <i class="fas fa-solid fa-clock"></i>
                                        Tidak diketahui
                                    </p>
                                    @else
                                    <p class="d-none d-sm-block">
                                        <i class="fas fa-solid fa-clock"></i>
                                        {{$education->created_at->diffForHumans()}}
                                    </p>
                                    @endif
                                    <div class="d-block d-sm-none">
                                        <p>
                                            <a href="{{ url('/edukasi?diposting-oleh='.$education->user->name) }}" style="color: var(--primary);">
                                                <i class="fa-solid fa-user"></i>
                                                @if (empty($education->user->name))
                                                    Tidak ada author
                                                @else
                                                    {{$education->user->name}}
                                                @endif
                                            </a>
                                        </p>
                                        @if (empty($education->created_at))
                                            <p>
                                                <i class="fas fa-solid fa-clock"></i>
                                                Tidak diketahui
                                            </p>
                                        @else
                                            <p>
                                                <i class="fas fa-solid fa-clock"></i>
                                                {{$education->created_at->diffForHumans()}}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <p class="text-edukasi">
                                    {{$education->desc}}
                                </p>
                            </div>
                        </div>
                        <!-- single blog -->
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class="card" style="margin-top: 50px">
                    <div class="card-body my-3">
                        <p class="card-title fw-bold" style="font-size: 15px;">Pencarian</p>
                        <form action="{{ url('edukasi') }}">
                            <div class="pt-2 input-group justify-content-center">
                                <div class="form-outline">
                                    <input class="typeahead form-control" value="{{ request('pencarian') }}" name="pencarian" placeholder="Cari edukasi ..." style="font-size: 15px; border-color: #16A085;" type="search" autocomplete="off">
                                </div>
                                <button type="submit" class="btn" style="background-color: #16A085; color: white">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card" style="margin-top: 30px">
                    <div class="card-body my-3">
                        <p class="card-title fw-bold" style="font-size: 15px;">Edukasi Lainnya</p>
                        @if ($educationsMore->count() > 0)
                        @foreach ($educationsMore as $item)
                        <div class="pt-2 border-bottom mt-3 pb-4">
                            <div class="row justify-content-center">
                                <div class="col-4">
                                    <a href="{{ url('/edukasi'.'/'.$item->slug) }}">
                                        @php
                                            $extMore = pathinfo($item->file, PATHINFO_EXTENSION)
                                        @endphp
                                        @if($extMore == 'mp4' || $extMore == 'mov' || $extMore == 'vob' || $extMore == 'mpeg' || $extMore == '3gp' || $extMore == 'avi' || $extMore == 'wmv' || $extMore == 'mov' || $extMore == 'amv' || $extMore == 'svi' || $extMore == 'flv' || $extMore == 'mkv' || $extMore == 'webm' || $extMore == 'gif' || $extMore == 'asf')
                                        <div class="text-center">
                                            <video src="{{ asset('../storage/edukasi/' . $item->file) }}" alt="Video" style="width: 92px; height: 60px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"/>
                                            {{-- <a class="video-popup glightbox" style="color: #16A085;"
                                                href="{{ asset('../storage/edukasi/' . $item->file) }}">
                                                <i class="lni lni-play"
                                                    style="position: absolute; top: 32%; left: 16%;"></i>
                                            </a> --}}
                                        </div>
                                        @elseif ($extMore == 'PNG' || $extMore == 'png' || $extMore == 'jpg' || $extMore == 'jpeg' || $extMore == 'svg' || $extMore == 'gif' || $extMore == 'tiff' || $extMore == 'psd' || $extMore == 'pdf' || $extMore == 'eps' || $extMore == 'ai' || $extMore == 'indd' || $extMore == 'raw')
                                            <img src="{{ asset('../storage/edukasi/' . $item->file) }}" class="img-responsive" alt="Edukasi" style="width: 92px; height: 60px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"/>
                                        @elseif (empty($item->file))
                                            <img src="{{ asset('img/no-image.png') }}" class="img-responsive" alt="Edukasi" style="width: 92px; height: 60px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"/>
                                        @endif
                                    </a>
                                </div>
                                <div class="col-8">
                                    <a href="{{ url('/edukasi'.'/'.$item->slug) }}" class="d-flex mb-2" style="color: var(--primary);">
                                        <p class="card-text p-0 text-capitalize" style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden;">{{$item->title}}</p>
                                    </a>
                                    <small><i class="fas fa-solid fa-calendar-day"></i> {{ date("d-F-Y", strtotime($item->date))}}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="row justify-content-center">
                            <small class="text-center m-5">Tidak ada edukasi!</small>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card" style="margin-top: 30px">
                    <div class="card-body my-3">
                        <p class="card-title fw-bold" style="font-size: 15px;">Kategori Edukasi</p>
                        <div class="mt-2 row">
                            @if ($categories->count() > 0)
                            @foreach ($categories as $item)
                            <div class="col-6 mt-1">
                                <a href="{{ url('/edukasi?kategori-edukasi='.$item->slug) }}"
                                    style="color: var(--primary);">
                                    <p>{{$item->name}}</p>
                                </a>
                            </div>
                            @endforeach
                            @else
                            <div class="row justify-content-center">
                                <small class="text-center m-5">Tidak ada Kategori Edukasi!</small>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- row -->
    </div>
    <!-- container -->
</section>
<!--====== BLOG PART ENDS ======-->

<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script>
    //========= glightbox
    const videoTwo = GLightbox({
        selector: ".glightbox",
        type: "video",
        source: "youtube", //vimeo, youtube or local
        width: 900,
        autoplayVideos: true,
    });

    var path = "{{ route('autocomplete')  }}";
    $('input.typeahead').typeahead({
        source:  function (query, process) {
        return $.get(path, { term: query }, function (data) {
                return process(data);
            });
        }
    });
</script>
@endsection
