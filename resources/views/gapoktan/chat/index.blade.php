@extends('gapoktan.template')
@section('title', 'Chat')

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- MULAI STYLE CSS -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel='stylesheet'
        href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
        integrity="sha256-pODNVtK3uOhL8FUNWWvFQK0QoQoV3YA9wGGng6mbZ0E=" crossorigin="anonymous" />
    <!-- AKHIR STYLE CSS -->
    <style>
    .chat-online {
        color: #34ce57
    }

    .chat-offline {
        color: #e4606d
    }

    .chat-messages {
        display: flex;
        flex-direction: column;
        height: 500px;
        overflow-y: scroll
    }

    .chat-message-left,
    .chat-message-right {
        display: flex;
        flex-shrink: 0
    }

    .chat-message-left {
        margin-right: auto
    }

    .chat-message-right {
        flex-direction: row-reverse;
        margin-left: auto
    }
    .py-3 {
        padding-top: 1rem!important;
        padding-bottom: 1rem!important;
    }
    .px-4 {
        padding-right: 1.5rem!important;
        padding-left: 1.5rem!important;
    }
    .flex-grow-0 {
        flex-grow: 0!important;
    }
    .border-top {
        border-top: 1px solid #dee2e6!important;
    }

    input[type='file'] {
        opacity:0
    }

    /* 4.3 Page */
    .page-error {
        height: 100%;
        width: 100%;
        padding-top: 11.5rem;
        text-align: center;
        display: table;
    }

    .page-error .page-inner {
        display: table-cell;
        width: 100%;
        vertical-align: middle;
    }

    .page-error .page-description {
        padding-top: 30px;
        font-size: 18px;
        font-weight: 400;
        color: color: var(--primary);;
    }

    @media (max-width: 575.98px) {
        .page-error {
            padding-top: 0px;
        }
    }

    .costum-color {
        background-image: linear-gradient(195deg, #EC407A 0%, #D81B60 100%);
    }
    </style>
@endsection

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Components</a></div>
                    <div class="breadcrumb-item">@yield('title')</div>
                </div>
            </div>

            <main class="content rounded bg-white">
                <div class="container p-0">
                    <div class="card-body">
                        <div class="row m-md-4 g-0 bg-white">
                            <div class="col-12 p-0 col-lg-5 col-xl-3 shadow rounded border">
                                <div class="px-4 d-none border-bottom d-md-block">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <input type="text" class="border ps-3 form-control my-3"
                                                placeholder="Pencarian...">
                                        </div>
                                    </div>
                                </div>
                                @foreach ($chats as $chat)
                                <a href="#" class="mt-3 list-group-item list-group-item-action border-0">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('assets/img/avatar/avatar-1.png') }}"
                                            class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">
                                        <div class="flex-grow-1 ml-3">
                                            {{ $chat->userSender->name }} <span class="badge bg-success mr-3">5</span>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                            <div class="p-0 col-12 col-lg-7 col-xl-9 rounded border">
                                <div class="py-2 px-4 border-bottom d-none d-lg-block">
                                    <div class="d-flex align-items-center py-3">
                                        <div class="position-relative">
                                            <img src="{{ asset('assets/img/avatar/avatar-1.png') }}"
                                                class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                        </div>
                                        <div class="flex-grow-1 pl-3">
                                            <strong>Pembeli</strong>
                                        </div>
                                        <div>
                                            <button class="btn btn-none px-3"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-more-horizontal feather-lg">
                                                    <circle cx="12" cy="12" r="1"></circle>
                                                    <circle cx="19" cy="12" r="1"></circle>
                                                    <circle cx="5" cy="12" r="1"></circle>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <form action="#" method="POST" id="add_employee_form">
                                <div class="position-relative">
                                    <div class="chat-messages p-4">
                                        @if ($roomChats->count() > 0)
                                        {{-- <div class="border rounded d-flex flex-row align-items-center mb-3">
                                            <div>
                                                @if ($roomChat->chat->product->photo_product->count() > 0)
                                                @foreach ($roomChat->chat->product->photo_product->take(1) as
                                                $photos)
                                                @if ($photos->name)
                                                <img src="{{ asset('../storage/produk/'.$photos->name) }}"
                                                    alt="{{ $roomChat->chat->product->name }}" style="width: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position:
                                                    center; object-position: center;">
                                                @else
                                                <img src="{{ asset('img/no-image.png') }}"
                                                    alt="{{ $roomChat->chat->product->name }}"
                                                    style="width: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                                                @endif
                                                @endforeach
                                                @else
                                                <img src="{{ asset('img/no-image.png') }}"
                                                    alt="{{ $roomChat->chat->product->name }}"
                                                    style="width: 5rem; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">
                                                @endif
                                            </div>
                                            <div class="ms-3">
                                                <p class="fw-bold m-0">{{ $roomChat->chat->product->name }}</p>
                                                <p class="m-0" style="font-size: 12px">Rp.
                                                    {{ number_format($roomChat->chat->product->price, 0) }}</p>
                                            </div>
                                        </div> --}}
                                        @foreach ($roomChats as $roomChat)
                                        <input type="hidden" name="chat_id" value="{{ $roomChat->chat_id }}">
                                        <input type="hidden" name="receiver_id" value="{{ $roomChat->sender_id }}">
                                        @if ($roomChat->sender_id === auth()->user()->id)
                                        <div class="chat-message-right pb-4">
                                            <div>
                                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                                    class="rounded-circle me-1" alt="Chris Wood" width="40" height="40">
                                                <div class="text-muted small text-nowrap mt-2">{{ date('H:i', strtotime($roomChat->created_at)) }}</div>
                                            </div>
                                            <div class="text-capitalize flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                                <div class="font-weight-bold mb-1">Anda</div>
                                                {{ $roomChat->message }}
                                            </div>
                                        </div>
                                        @else
                                        <div class="chat-message-left pb-4">
                                            <div>
                                                <img src="{{ asset('assets/img/avatar/avatar-1.png') }}"
                                                    class="rounded-circle ms-1" alt="Pembeli" width="40" height="40">
                                                <div class="text-muted small text-nowrap mt-2">{{ date('H:i', strtotime($roomChat->created_at)) }}</div>
                                            </div>
                                            <div class="text-capitalize flex-shrink-1 border border-light rounded py-2 px-3 ml-3">
                                                <div class="font-weight-bold mb-1">{{ $roomChat->userSender->name }}</div>
                                                {{ $roomChat->message }}
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                        @else
                                        <div id="app">
                                            <section class="section">
                                                <div class="container">
                                                    <div class="page-error">
                                                        <div class="page-inner">
                                                            <div class="page-description">
                                                                Belum ada pesan!
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-grow-0 py-3 px-4 border-top">
                                    <div class="input-group d-flex flex-row align-items-center">
                                        <input type="text" name="message" class="ps-3 border form-control"
                                            placeholder="Tulis Pesan...">
                                        <button type="submit" id="chatBtnDisabled" class="btn btn-primary">Kirim</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </section>
    </div>
@endsection

@section('script')
    <!-- LIBARARY JS -->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <!-- AKHIR LIBARARY JS -->

    <!-- JAVASCRIPT -->
    <script>
        // add new employee ajax request
        $("#add_employee_form").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $("#chatBtnDisabled").prop('disabled', true);
            $.ajax({
            url: '{{ route('gapoktan.createChat') }}',
            method: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 400) {
                    showError('message', response.messages.message);
                    $("#chatBtnDisabled").prop('disabled', false);

                } else if (response.status == 200){
                    window.location.reload();
                    $("#chatBtnDisabled").prop('disabled', false);
                }
            }
            });
        });

        const messaging = firebase.messaging();
        messaging.usePublicVapidKey("BOPzmY3tl0kiX3fUSsQBfurfNxn86-jBjjPCbJxObhqxEMu-RFxwwhHNQ-dGRF0SDQMIEuCTi3BOQz_pUYYBvxs");

        function sendTokenToServer(fcm_token)
        {
            const user_id = '{{auth()->user()->id}}';
            axios.post('/api/save-token', {
                fcm_token, user_id
            })
            .then(res => {
                console.log(res);
            })
        }

        function retrieveToken() {
            messaging.getToken()
            .then((currentToken) => {
                if (currentToken) {
                    console.log('Token Received : ' +  currentToken)
                    sendTokenToServer(currentToken);
                    // Track the token -> client mapping, by sending to backend server
                    // show on the UI that permission is secured
                } else {
                    alert('You should allow notification!');
                    // console.log('No registration token available. Request permission to generate one.');
                    // shows on the UI that permission is required
                }
            }).catch((err) => {
                console.log('An error occurred while retrieving token. ', err);
                // catch error while creating client token
            });
        }

        retrieveToken();

        messaging.onTokenRefresh(() => {
            retrieveToken();
        });

        messaging.onMessage((payload)=>{
            console.log('Message received');
            console.log(payload);

            location.reload();
        });
    </script>
@endsection
