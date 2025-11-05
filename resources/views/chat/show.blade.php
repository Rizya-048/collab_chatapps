@extends('layouts.app')

@section('content')
<style>
    .chat-container {
        display: flex;
        height: 80vh;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }

    .chat-header {
        padding: 12px;
        background: #CD1AFF;
        color: white;
        font-weight: bold;
        text-align: center;
    }

    .messages-box {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        background: #F8F6FF;
    }

    .bubble {
        margin-bottom: 10px;
        padding: 10px 14px;
        border-radius: 12px;
        max-width: 65%;
        font-size: 15px;
    }

    .me {
        background: #CD1AFF;
        color: white;
        margin-left: auto;
        text-align: right;
    }

    .other {
        background: white;
        border: 1px solid #ddd;
        text-align: left;
    }

    .chat-input {
        display: flex;
        padding: 12px;
        background: white;
        border-top: 1px solid #ddd;
    }

    .chat-input input {
        flex: 1;
        border-radius: 6px;
        border: 1px solid #ccc;
        padding: 10px;
        margin-right: 8px;
    }

    .chat-input button {
        background: #CD1AFF;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 6px;
        cursor: pointer;
    }
</style>

<div class="chat-header">
    {{ $conversation->title ?? 'Percakapan' }}
</div>

<div class="chat-container">
    <div id="messages" class="messages-box">
        @foreach($conversation->messages as $msg)
            <div class="bubble {{ $msg->user_id == auth()->id() ? 'me' : 'other' }}">
                {{ $msg->content }}
            </div>
        @endforeach
    </div>
</div>

<form action="{{ route('chat.send', $conversation->id) }}" method="POST" class="chat-input">
    @csrf
    <input type="text" name="content" placeholder="Tulis pesan..." autocomplete="off" required>
    <button type="submit">Kirim</button>
</form>

@endsection

@section('scripts')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    window.Echo.join('conversation.{{ $conversation->id }}')
        .listen('MessageSent', (e) => {

            let box = document.getElementById('messages');

            box.innerHTML += `
            <div class="bubble other">
                ${e.message.content}
            </div>`;

            box.scrollTop = box.scrollHeight;
        });
</script>
@endsection
