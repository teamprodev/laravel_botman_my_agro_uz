@extends('voyager::master')
<link rel="stylesheet" href="/css/chatt.css">
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>

@section('content')

<style>
    :root {
        --body-bg: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        --msger-bg: #fff;
        --border: 2px solid #ddd;
        --left-msg-bg: #ececec;
        --right-msg-bg: #579ffb;
    }

    html {
        box-sizing: border-box;
    }

    body {
        overflow: hidden;
    }

    *,
    *:before,
    *:after {
        margin: 0;
        padding: 0;
        box-sizing: inherit;
    }

    .inputs {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-image: var(--body-bg);
        font-family: Helvetica, sans-serif;
    }

    .msger {
        display: flex;
        flex-flow: column wrap;
        justify-content: space-between;
        width: 100%;
        max-width: 1000px;
        margin: 25px 10px;
        height: calc(100% - 50px);
        border: var(--border);
        border-radius: 5px;
        background: var(--msger-bg);
        box-shadow: 0 15px 15px -5px rgba(0, 0, 0, 0.2);
    }

    .msger-header {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        border-bottom: var(--border);
        background: #eee;
        color: #666;
    }

    .msger-chat {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 10px;
    }

    .msger-chat::-webkit-scrollbar {
        width: 6px;
    }

    .msger-chat::-webkit-scrollbar-track {
        background: #ddd;
    }

    .msger-chat::-webkit-scrollbar-thumb {
        background: #bdbdbd;
    }

    .msg {
        display: flex;
        align-items: flex-end;
        margin-bottom: 10px;
    }

    .msg:last-of-type {
        margin: 0;
    }

    .msg-img {
        width: 50px;
        height: 50px;
        margin-right: 10px;
        background: #ddd;
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        border-radius: 50%;
    }

    .msg-bubble {
        max-width: 450px;
        padding: 15px;
        border-radius: 15px;
        background: var(--left-msg-bg);
    }

    .msg-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .msg-info-name {
        margin-right: 10px;
        font-weight: bold;
    }

    .msg-info-time {
        font-size: 0.85em;
    }

    .left-msg .msg-bubble {
        border-bottom-left-radius: 0;
    }

    .right-msg {
        flex-direction: row-reverse;
    }

    .right-msg .msg-bubble {
        background: var(--right-msg-bg);
        color: #fff;
        border-bottom-right-radius: 0;
    }

    .right-msg .msg-img {
        margin: 0 0 0 10px;
    }

    .msger-inputarea {
        display: flex;
        padding: 10px;
        border-top: var(--border);
        background: #eee;
    }

    .msger-inputarea * {
        padding: 10px;
        border: none;
        border-radius: 3px;
        font-size: 1em;
        margin-bottom: 40px;
    }

    .msger-input {
        flex: 1;
        background: #ddd;
    }

    .msger-send-btn {
        margin-left: 10px;
        background: rgb(0, 196, 65);
        color: #fff;
        font-weight: bold;
        cursor: pointer;
    }

    .msger-send-btn:hover {
        background: rgb(0, 180, 50);
    }

    .app-footer {
        display: none;
    }

    h4 {
        margin: 0;
    }

    .msger-chat {
        background-color: #fcfcfe;

    }

    .titles {
        background-color: #666;
        padding: 10px 5px;
        margin: 0;
        color: #fff;
    }

    .right {
        max-width: 300px;

        margin-top: -110px;
        background-color: #fff;
        padding: 10px;
        margin: 0;
    }

    .right .wrap {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .right .wrap .block {
        width: 100%;
        border-bottom: 1px solid grey;
        padding: 5px 0;
    }

    .right .wrap .block .btn {
        padding: 5px 10px;
        font-size: 14px;
        line-height: 1.5;
        border-radius: 3px;
        color: #fff;
        background-color: #f44336;
        border-color: #f44336;
    }

    .right .wrap .block span {
        font-size: 0.75rem;
        color: #9e9e9e;
        margin-bottom: 5px;
        display: block;
    }
    .right .wrap .block p {
        font-size: 16px;
    }
    .right{
        margin-top: 53px;
        height: 100vh;
    }
    @media screen and (min-width: 401px) and (max-width: 900px) {
  .right { display: none;}   /* hide it elsewhere */
}
</style>
</head>

<body>

    <div class="inputs">
        <section class="msger">
            <div class="titles">Lorem ip Quos delectus a Marepudiandae laborum.</div>
            <header class="msger-header">

                <div class="msger-header-title">

                    <i class="fas fa-comment-alt"></i>
                    <h4>SimpleChat</h4>
                </div>
                <div class="msger-header-options">
                    <span><i class="fas fa-cog"></i></span>
                </div>
            </header>
            <main class="msger-chat">
                @foreach ($conversations as $conversation)
                {{-- @dd($conversation); --}}
                @php
                $user = \App\Models\User::where('id', $conversation->user_id)->first();
                @endphp

                <div class='msg {{ $conversation->user_id == Auth::user()->id ? 'right-msg' : 'left-msg' }} '>
                    <div class="msg-img" style="background-image: url(https://image.flaticon.com/icons/svg/145/145867.svg)"></div>

                    <div class="msg-bubble">
                        <div class="msg-info">
                            <div class="msg-info-name">{{ $user->name }}</div>
                            <div class="msg-info-time">{{ date('H:m', strtotime($conversation->created_at)) }}</div>
                        </div>
                        <div class="msg-text">
                            {{ $conversation->text }}
                        </div>
                    </div>
                </div>
                @endforeach


            </main>
            @if($appeal->is_closed == 0)
            <form action="{{ route('conversation.send', $appeal->id) }}" method="post" class="msger-inputarea">
                @csrf
                <input name="text" type="text" class="msger-input" required placeholder="Enter your message...">
                <button type="submit" class="msger-send-btn">Send</button>
            </form>
            @endif
        </section>
        <div class="right">
            <div class="wrap">
                <div class="block">
                    <span>Запрашивающий</span>
                    <p>Xurshida Kamalova </p>
                </div>
                <div class="block">
                    <span>Отдел</span>
                    <p>Отдел технической поддержки</p>
                </div>
                <div class="block">
                    <span>Отправлен</span>
                    <p>10.09.2021 (18:32)</p>
                </div>
                <div class="block">
                    <span>Последнее обновление</span>
                    <p>4 дня назад</p>
                </div>
                <div class="block">
                    <span>Состояние/Приоритет</span>
                    <p>Отвечен Средняя</p>
                </div>
                <div class="block">
                    <form action="{{ route('appeal.close', $appeal) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn">Закрыть тикет</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script>
 var objDiv = document.querySelector(".msger-chat");
objDiv.scrollTop = objDiv.scrollHeight;
</script>

    @endsection
