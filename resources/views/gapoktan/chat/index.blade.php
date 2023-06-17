@extends('gapoktan.template')
@section('title', 'Chat')

@section('style')
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <meta name="user" content="{{ auth()->user()->id }}">
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
            overflow-y: auto
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
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        .px-4 {
            padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
        }

        .flex-grow-0 {
            flex-grow: 0 !important;
        }

        .border-top {
            border-top: 1px solid #dee2e6 !important;
        }

        input[type='file'] {
            opacity: 0
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
            color: color: var(--primary);
            ;
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

            <main class="">

                <div class="row bg-white rounded">
                    <div class="col-12 col-lg-5 col-xl-3 shadow rounded border border-light">
                        <div class="px-4 d-none border-bottom d-md-block">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <input type="text" id="search" class="border pl-3 form-control my-3"
                                        placeholder="Pencarian...">
                                </div>
                            </div>
                        </div>
                        <div class="list">

                        </div>
                    </div>
                    <div class="col-12 col-lg-7 col-xl-9 shadow-sm rounded">
                        <div class="py-2 px-4 border-bottom d-none container-chat">
                            <div class="d-flex align-items-center py-3">
                                <div class="position-relative">
                                    <img src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1"
                                        alt="Sharon Lessman" width="40" height="40">
                                </div>
                                <div class="flex-grow-1 pl-3">
                                    <strong class="username">Gapoktan</strong>
                                </div>
                                <div>
                                    <button class="btn-white border border-white px-3"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
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
                                <div class="chat-messages p-4 ">

                                </div>
                            </div>
                            <div class="flex-grow-0 py-3 px-4 border-top send-chat d-none">
                                <div class="input-group d-flex flex-row align-items-center">
                                    <input type="text" name="message" id="message" class="pl-3 border form-control"
                                        placeholder="Tulis Pesan...">
                                    <input type="hidden" name="chat_id" id="chat_id">
                                    <input type="hidden" name="product" id="product">
                                    <button type="submit" id="chatBtn" class=" ml-2 btn btn-primary">Kirim</button>
                                </div>
                            </div>
                        </form>
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
        const baseUrl = window.location.origin;
        const userId = $('meta[name=user]').prop('content')
        const containerChat = $('.container-chat')
        const sendChat = $('.send-chat')
        const username = $('.username')
        const chatMessages = $('.chat-messages')
        const searchBox = $('#search')
        const listProfile = $('.list')
        const receiver = $('#chat_id')
        const messageBox = $('#message')
        const product = $('#product')
        const time = 5000
        let messages = []

        const getAllMessages = () => {
            messages = []

            $.ajax({
                url: `${baseUrl}/all-messages`,
                method: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf_token]').prop('content')
                },
                success: function(res) {
                    messages.push(...res)
                    listProfile.empty()
                    let list = ''
                    res.map((v, i) => {
                        list += templateListProfile(v)
                        $(`.read_count-${v.user_id}`).show()
                    })

                    listProfile.append(list)

                    if (receiver.val()) {

                        newMessages = res.filter((v) => {
                            return v.user_id == receiver.val()
                        })

                        let chat = []
                        chatMessages.empty().append(templateListChat(newMessages[0]))
                        $(`.read_count-${newMessages[0].user_id}`).hide()
                        newMessages[0].messages.map((v, i) => {
                            if (!v.is_read) chat.push(v.chat_id)
                        })

                        if (chat.length > 0) {
                            readMessage(chat, newMessages[0].user_id)
                            scrollMsg()
                        }

                    }
                }
            })
        }
        const templateListProfile = (chat) => {
            return `<a href="#" class="mt-3 list-group-item list-group-item-action border-0 list-chat" data-user='${JSON.stringify(chat)}'>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('assets/img/avatar/avatar-1.png') }}"
                                                        class="rounded-circle mr-1" alt="Vanessa Tucker" width="40"
                                                        height="40">
                                                    <div class="flex-grow-1 ml-3">
                                                        ${chat.name}
                                                        ${chat.read_count == 0 ? '' : `<span class="badge rounded-circle bg-danger ml-3 read_count-${chat.user_id}">${chat.read_count}</span>`}
                                                    </div>
                                                </div>
                                            </a>`
        }

        const templateListChat = (chat) => {
            let list = '';
            chat.messages.map((v, i) => {
                list += `
                <div class="chat-message-${userId == v.sender_id ? 'right' : 'left'} text-white pb-4">
                <div class="mr-3">
                            <div class="text-muted small text-nowrap mt-2">
                              ${moment(v.created_at).format('hh:mm')}
                            </div>
                        </div>
                        <div
                            class="text-capitalize flex-shrink-1 bg-${userId == v.sender_id ? 'primary' : 'success'} rounded py-2 px-3 mr-3">
                            <div class="font-weight-bold mb-1">${userId == v.sender_id ? 'Anda' : chat.name}</div>
                                ${v.message}
                        </div>
                        </div>`
            })
            return list
        }

        const sendMessageTemplate = (msg, message = '') => {
            return `<div class="chat-message-right text-white pb-4">
                <div class="mr-3">
                            <div class="text-muted small text-nowrap mt-2">
                              ${moment(msg.created_at ?? new Date()).format('hh:mm')}
                            </div>
                        </div>
                        <div
                            class="flex-shrink-1 bg-primary rounded py-2 px-3 mr-3">
                            <div class="font-weight-bold mb-1">Anda</div>
                                ${(messageBox.val() == '') ? message : messageBox.val() }
                        </div>
                        </div>`
        }


        const readMessage = (chat_id, receiver_id) => {
            $.ajax({
                url: `${baseUrl}/read-messages`,
                method: 'post',
                dataType: 'json',
                data: {
                    chat_id,
                    receiver_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf_token]').prop('content')
                },
                success: function(res) {

                }
            })
        }

        const sendMessage = (msg, status = true) => {
            $.ajax({
                url: `${baseUrl}/send-messages`,
                method: 'post',
                dataType: 'json',
                data: msg,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf_token]').prop('content')
                },
                success: function(res) {
                    if (status) {
                        chatMessages.append(sendMessageTemplate(res));
                        messageBox.val(null)

                        scrollMsg()
                    }
                }
            })
        }

        const scrollMsg = () => {
            chatMessages.animate({
                    scrollTop: chatMessages.prop("scrollHeight"),
                },
                400
            );
        };



        $(function() {
            getAllMessages()

            let interval = setInterval(getAllMessages, time);

            $('body').on('click', '.list-chat', function() {
                let user = $(this).data('user')
                let chat = []
                containerChat.removeClass('d-none')
                sendChat.removeClass('d-none')
                username.text(user.name)

                chatMessages.empty().append(templateListChat(user))

                $(`.read_count-${user.user_id}`).hide()

                user.messages.map((v, i) => {
                    if (!v.is_read) chat.push(v.chat_id)
                })

                receiver.val(user.user_id)

                if (chat.length > 0) {

                    readMessage(chat, user.user_id)
                }

                scrollMsg()


            })

            searchBox.on('keyup', function() {
                clearInterval(interval)
                let value = $(this).val();
                let filter = messages.filter((v) => {
                    return (v.name.toLowerCase()).includes(value.toLowerCase())
                })

                listProfile.empty()
                let list = ''
                filter.map((v, i) => {
                    list += templateListProfile(v)
                })


                listProfile.append(list)
                interval = setInterval(getAllMessages, time);
            })

            $('body').on('click', '#chatBtn', function(e) {
                e.preventDefault()
                let msg = {
                    receiver_id: receiver.val(),
                    message: messageBox.val(),
                    product_id: product.val()
                }
                sendMessage(msg)

            })

            let chatProduct = sessionStorage.getItem('chat')

            if (chatProduct) {
                let cp = JSON.parse(chatProduct);
                let img = '/img/no-image.png'
                if (cp.product.user_id != userId) {
                    if (cp.product.photo_product.length) {
                        img = `/../storage/produk/${cp.product.photo_product[0].name}`
                    }

                    let msgproduct =
                        `<img src="${img}" width="80" height="80" ><br> <a href="${cp.url}" target="blank">${cp.url}</a> <br> produk ini apakah masih ada?`;
                    containerChat.removeClass('d-none')
                    sendChat.removeClass('d-none')
                    username.text(cp.product.name)

                    let msg = {
                        receiver_id: cp.product.user_id,
                        message: msgproduct,
                        product_id: cp.product.id
                    }

                    chatMessages.append(sendMessageTemplate(msg, msgproduct));

                    sendMessage(msg, false)
                    scrollMsg()
                    receiver.val(cp.product.user_id)
                    getAllMessages()

                    sessionStorage.clear()
                }



            }
        })
    </script>
@endsection
