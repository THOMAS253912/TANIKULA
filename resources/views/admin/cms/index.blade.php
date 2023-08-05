@extends('admin.template')
@section('title', 'CMS')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- MULAI STYLE CSS -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
        integrity="sha256-pODNVtK3uOhL8FUNWWvFQK0QoQoV3YA9wGGng6mbZ0E=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- AKHIR STYLE CSS -->

    <style>
        .dropify-message p {
            font-size: 14px !important;
        }
    </style>
@endsection

@section('content')

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form action="#" id="formCms">
                        @csrf
                        <div class="card">
                            <div class="card-header border-0"></div>
                            <div class="card-body">
                                @foreach ($cms as $item)
                                    @if (!$item->is_image)
                                        @if (!$item->is_html)
                                            <div class="form-group row">
                                                <label for="inputEmail3"
                                                    class="col-sm-2 col-form-label">{{ $item->cms_name }}</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="{{ $item->alias }}"
                                                        value="{{ $item->content }}" onchange="validate()">
                                                </div>
                                            </div>
                                        @else
                                            <div class="form-group row">
                                                <label for="inputEmail3"
                                                    class="col-sm-2 col-form-label">{{ $item->cms_name }}</label>
                                                <div class="col-sm-10">
                                                    <textarea type="text" class="form-control editor" name="{{ $item->alias }}" onchange="validate()">{{ $item->content }}</textarea>
                                                </div>
                                            </div>
                                        @endif
                                        {{-- @else
                                    @if (!$item->is_multiple)
                                        <div class="form-group row">
                                            <label for="inputEmail3"
                                                class="col-sm-2 col-form-label">{{ $item->cms_name }}</label>
                                            <div class="col-sm-5">
                                                <div class="">
                                                    <img src="{{ asset('assets/company/') . '/' . str_replace('app_', '', $item->alias) . '/' . $item->content }}"
                                                        alt="{{$item->cms_name}}" width="200">
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif --}}
                                    @endif
                                @endforeach
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary" type="submit" disabled id="update">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="#" id="formCmsImage">
                        {{-- @csrf --}}
                        <div class="card">
                            <div class="card-header border-0"></div>
                            <div class="card-body">
                                @foreach ($cms as $item)
                                    @if ($item->is_image)
                                        @if (!$item->is_multiple)
                                            <div class="form-group row">
                                                <label for="inputEmail3"
                                                    class="col-sm-2 col-form-label">{{ $item->cms_name }}</label>
                                                <div class="col-sm-10">
                                                    <input type="file" class="dropify" name="{{ $item->alias }}"
                                                        data-default-file="{{ asset('assets/company') . '/' . str_replace('app_', '', $item->alias) . '/' . $item->content }}"
                                                        data-allowed-file-extensions="jpg png svg">
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary" type="submit" disabled id="updateImage">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="#" id="formCmsSlider">
                        {{-- @csrf --}}
                        <div class="card">
                            <div class="card-header border-0"></div>
                            <div class="card-body">
                                @foreach ($cms as $item)
                                    @if ($item->is_image)
                                        @if ($item->is_multiple)
                                            <div class="form-group row">
                                                <label for="inputEmail3"
                                                    class="col-sm-2 col-form-label">{{ $item->cms_name }}</label>
                                                <div class="col-sm-10">
                                                    <div class="row" id="slider-container">
                                                        @foreach (json_decode($item->content) as $value)
                                                            <div class="col-sm-12 col-md-6 col-lg-4 mb-2">
                                                                <input type="file" class="dropify-multi mb-3"
                                                                    name="{{ $item->alias }}[]"
                                                                    data-default-file="{{ asset('assets/company') . '/' . str_replace('app_', '', $item->alias) . '/' . $value }}"
                                                                    data-allowed-file-extensions="jpg png svg">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary" type="submit" disabled
                                    id="updateImageMulti">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


@endsection

@section('script')
    <!-- LIBARARY JS -->
    {{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script> --}}
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"
        integrity="sha256-sPB0F50YUDK0otDnsfNHawYmA5M0pjjUf4TvRJkGFrI=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.js"
        integrity="sha256-siqh9650JHbYFKyZeTEAhq+3jvkFCG8Iz+MHdr9eKrw=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        let editor = ClassicEditor
            .create(document.querySelector('.editor'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    $('#update').prop('disabled', false)
                });
            })
            .catch(error => {
                // console.error(error);
            });



        $(function() {


            $('#formCms').on('submit', function(e) {
                e.preventDefault()
                data = $(this).serialize()
                update(data)
            })
            $('#formCmsImage').on('submit', function(e) {
                e.preventDefault()
                data = new FormData(this)
                updateImage(data)
            })
            $('#formCmsSlider').on('submit', function(e) {
                e.preventDefault()
                data = new FormData(this)
                updateImageMulti(data)
            })

            $('.dropify,.dropify-multi').dropify()

            $('.dropify').on('change', function() {


                let img = '';

                var file = this.files[0];

                var reader = new FileReader();
                reader.onloadend = function() {
                    img = reader.result
                }
                reader.readAsDataURL(file);

                if (file.type == 'image/svg+xml') {

                    $(this).siblings('.dropify-preview').find('.dropify-render').empty().append(
                        `<img src="${img}">`)
                }
                if (file) {
                    $('#updateImage').prop('disabled', false)
                }
            })
            $('.dropify-multi').on('change', function() {


                let img = '';

                var file = this.files[0];

                var reader = new FileReader();
                reader.onloadend = function() {
                    img = reader.result
                }
                reader.readAsDataURL(file);

                if (file.type == 'image/svg+xml') {

                    $(this).siblings('.dropify-preview').find('.dropify-render').empty().append(
                        `<img src="${img}">`)
                }
                if (file) {
                    $('#updateImageMulti').prop('disabled', false)
                }
            })

        })

        const update = (data) => {
            $.ajax({
                url: '/admin/cms/update',
                data,
                type: "POST",
                beforeSend: () => {

                }
            }).done((res) => {

                iziToast.success({
                    title: 'Berhasil',
                    message: 'Berhasil mengubah konten',
                    position: 'topRight',
                });

                $('#update').prop('disabled', true)

            }).fail((xhr) => {
                res = xhr.responseJSON
                iziToast.warning({
                    title: 'Gagal',
                    message: res.message,
                    position: 'topRight',
                });
            })
        }
        const updateImage = (data) => {
            $.ajax({
                url: '/admin/cms/update-img',
                data,
                type: "POST",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: () => {

                }
            }).done((res) => {
                console.log(res);
                iziToast.success({
                    title: 'Berhasil',
                    message: 'Berhasil mengubah konten',
                    position: 'topRight',
                });

                $('#update').prop('disabled', true)

            }).fail((xhr) => {
                res = xhr.responseJSON
                iziToast.warning({
                    title: 'Gagal',
                    message: res.message,
                    position: 'topRight',
                });
            })
        }
        const updateImageMulti = (data) => {
            $.ajax({
                url: '/admin/cms/update-img-multiple',
                data,
                type: "POST",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: () => {

                }
            }).done((res) => {
                console.log(res);
                iziToast.success({
                    title: 'Berhasil',
                    message: 'Berhasil mengubah konten',
                    position: 'topRight',
                });

                $('#update').prop('disabled', true)

            }).fail((xhr) => {
                res = xhr.responseJSON
                iziToast.warning({
                    title: 'Gagal',
                    message: res.message,
                    position: 'topRight',
                });
            })
        }

        const validate = () => {
            isValid = true

            $('#formCms input').not('.ck-hidden').each((i, v) => {
                if (!$(v).val()) {
                    return isValid = false
                }
            })

            if (!isValid) {
                iziToast.warning({
                    title: 'Peringatan',
                    message: `harus diisi`,
                    position: 'topRight',
                });
            } else {
                $('#update').prop('disabled', !isValid)
            }
        }
    </script>

    <!-- AKHIR LIBARARY JS -->

@endsection
