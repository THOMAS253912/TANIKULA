@extends('support.template')
@section('title', 'Detail Bukti Gapoktan')

@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- MULAI STYLE CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link rel='stylesheet'
    href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
    integrity="sha256-pODNVtK3uOhL8FUNWWvFQK0QoQoV3YA9wGGng6mbZ0E=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css"
    integrity="sha512-Velp0ebMKjcd9RiCoaHhLXkR1sFoCCWXNp6w4zj1hfMifYB5441C+sKeBl/T/Ka6NjBiRfBBQRaQq65ekYz3UQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- AKHIR STYLE CSS -->
@endsection

@section('content')
<!-- Main Content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <p class="m-0 py-2 h5 font-weight-bold">Detail Bukti Gapoktan</p>
                    </div>
                    <div class="card-body">
                        <form action="#" id="verifiedGapoktanForm" method="post">
                            @csrf
                            <input type="hidden" name="gapoktan_id" value="{{ $gapoktans->id }}">
                            <input type="hidden" name="user_id" value="{{ $gapoktans->user->id }}">
                            <div class=" table-responsive">
                                <table class="table table-success table-striped">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Nama Gapoktan</th>
                                            <td class="font-weight-bold">{{ $gapoktans->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Bukti Gapoktan</th>
                                            <td>
                                                @if ($gapoktans->certificateGapoktan->count() > 0)
                                                <div class="tab-content editFile my-2 d-flex align-items-center"
                                                    id="myTabContent2">
                                                    @foreach ($gapoktans->certificateGapoktan as $bukti)
                                                    <div class="px-2" id="home2"><a
                                                            href="{{ asset('../storage/sertifikat/'.$bukti->evidence) }}"
                                                            data-toggle="lightbox" data-gallery="example-gallery"
                                                            data-type="image" data-max-width="2000"><img id="preview"
                                                                class="img-fluid img-thumbnail image"
                                                                src="{{ asset('../storage/sertifikat/'.$bukti->evidence) }}"
                                                                alt="bukti"
                                                                style="width: 8rem; height: 8rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;"></a>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @else
                                                    <p class="text-danger font-weight-bold">Tidak ada bukti</p>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Status Gapoktan</th>
                                            <td>
                                                @if ($gapoktans->is_verified == 1)
                                                <h6 class="badge badge-success">Terverifikasi</h6>
                                                @else
                                                <h6 class="badge badge-danger">Belum diverifikasi</h6>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right">
                                @if ($gapoktans->is_verified == 0)
                                    <button type="submit" id="verifikasiGapoktanBtn" class="btn btn-success">Verifikasi
                                        Gapoktan</button>
                                @else
                                    <a href="#" onclick="support_verifikasi_gapoktan('{{ url('support/verifikasi-gapoktan') }}')" class="btn btn-secondary">Kembali</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<!-- LIBARARY JS -->
{{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script> --}}
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"
    integrity="sha256-sPB0F50YUDK0otDnsfNHawYmA5M0pjjUf4TvRJkGFrI=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.js"
    integrity="sha256-siqh9650JHbYFKyZeTEAhq+3jvkFCG8Iz+MHdr9eKrw=" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"
    integrity="sha512-Y2IiVZeaBwXG1wSV7f13plqlmFOx8MdjuHyYFVoYzhyRr3nH/NMDjTBSswijzADdNzMyWNetbLMfOpIPl6Cv9g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"
    integrity="sha512-YibiFIKqwi6sZFfPm5HNHQYemJwFbyyYHjrr3UT+VobMt/YBo1kBxgui5RWc4C3B4RJMYCdCAJkbXHt+irKfSA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- AKHIR LIBARARY JS -->

<!-- JAVASCRIPT -->
<script>
    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

    $(function () {

        // add new employee ajax request
        $("#verifiedGapoktanForm").submit(function (e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#verifikasiGapoktanBtn").text('Tunggu..');
            $("#verifikasiGapoktanBtn").prop('disabled', true);
            $.ajax({
                url: '{{ route('support-verifikasi-gapoktan-update') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    if (response.status == 400) {
                        // showError('title', response.messages.title);
                        // showError('category_activity_id', response.messages.category_activity_id);
                        // showError('desc', response.messages.desc);
                        // showError('date', response.messages.date);
                        $("#verifikasiGapoktanBtn").text('Simpan');
                        $("#verifikasiGapoktanBtn").prop('disabled', false);
                    } else if (response.status == 200) {
                        Swal.fire(
                            'Berhasil!',
                            'Verifikasi Gapoktan!',
                            'success'
                        )
                        $("#verifiedGapoktanForm")[0].reset();
                        $("#verifikasiGapoktanBtn").text('Simpan');
                        $("#verifikasiGapoktanBtn").prop('disabled', false);
                        window.location = '{{ route('support-verifikasi-gapoktan') }}';
                    }
                }
            });
        });
    });
</script>
@endsection
