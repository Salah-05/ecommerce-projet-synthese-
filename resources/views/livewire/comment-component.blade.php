<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <title>Document</title>
    <link rel="stylesheet" href="/style_chat.css">
</head>
<body>
<div>
    <form id="chat-form">
        <input type="text" name="comment" id="comment" placeholder="enter comment...">
        <button type="submit">Send</button>
    </form>
    <div class="single-comment justify-content-between d-flex">
        <div class="user justify-content-between d-flex">
            <div class="thumb text-center">
                <img src="{{asset('assets/imgs/page/avatar-6.jpg" al')}}" alt="#">
                <h6><a href="#">Jacky Chan</a></h6>
                <p class="font-xxs">Since 2012</p>
            </div>
            <div class="desc">
                <div class="product-rate d-inline-block">
                    <div class="product-rating" style="width:90%">
                    </div>
                </div>
                <p>Thank you very fast shipping from Poland only 3days.</p>
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <p class="font-xs mr-30">December 4, 2020 at 3:12 pm </p>
                        <a href="#" class="text-brand btn-reply">Reply <i class="fi-rs-arrow-right"></i> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<body>
    <script>
        $(document).ready(function() {
            const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                forceTLS: true
            });

            const channel = pusher.subscribe('public');

            // Receive comments
            channel.bind('chat', function(data) {
                console.log('Received comment:', data.comment);  // Debug log
                $.post("/receive", {
                    _token: '{{ csrf_token() }}',
                    comment: data.comment,
                }).done(function(res) {
                    $(".comments").append(res);  // Ensure new comments are appended
                    $(document).scrollTop($(document).height());
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('Error receiving comment:', textStatus, errorThrown);
                });
            });

            // Broadcast comments
            $("#chat-form").submit(function(event) {
                event.preventDefault();
                const comment = $("#comment").val();
                console.log('Sending comment:', comment);  // Debug log
                $.ajax({
                    url: "/broadcast",
                    method: 'POST',
                    headers: {
                        'X-Socket-Id': pusher.connection.socket_id
                    },
                    data: {
                        _token: '{{ csrf_token() }}',
                        comment: comment,
                    }
                }).done(function(res) {
                    $(".comments").append(res);  // Ensure new comments are appended
                    $("#comment").val('');
                    $(document).scrollTop($(document).height());
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('Error sending comment:', textStatus, errorThrown);
                });
            });
        });
    </script>
</html>
