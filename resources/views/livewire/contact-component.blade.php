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
    <div class="chat">
        <div class="top">
            <div>
                <p>Reda</p>
                <small>Online</small>
            </div>
        </div>
        
        <div class="messages">
            @foreach($messages as $message)
                <div class="message">
                    <strong>{{ $message->user->name }}:</strong> {{ $message->message }}
                </div>
            @endforeach
        </div>
        <div class="bottom">
            <form id="chat-form">
                <input type="text" name="message" id="message" placeholder="enter message...">
                <button type="submit">Send</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                forceTLS: true
            });

            const channel = pusher.subscribe('public');

            // Receive messages
            channel.bind('chat', function(data) {
                console.log('Received message:', data.message);  // Debug log
                $.post("/receive", {
                    _token: '{{ csrf_token() }}',
                    message: data.message,
                }).done(function(res) {
                    $(".messages").append(res);  // Ensure new messages are appended
                    $(document).scrollTop($(document).height());
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('Error receiving message:', textStatus, errorThrown);
                });
            });

            // Broadcast messages
            $("#chat-form").submit(function(event) {
                event.preventDefault();
                const message = $("#message").val();
                console.log('Sending message:', message);  // Debug log
                $.ajax({
                    url: "/broadcast",
                    method: 'POST',
                    headers: {
                        'X-Socket-Id': pusher.connection.socket_id
                    },
                    data: {
                        _token: '{{ csrf_token() }}',
                        message: message,
                    }
                }).done(function(res) {
                    $(".messages").append(res);  // Ensure new messages are appended
                    $("#message").val('');
                    $(document).scrollTop($(document).height());
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('Error sending message:', textStatus, errorThrown);
                });
            });
        });
    </script>
</body>
</html>
