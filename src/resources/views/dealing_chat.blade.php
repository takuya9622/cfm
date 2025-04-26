@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/dealing_chat.css') }}" />
@endsection

@section('content')
<div class="dealing-chat-container">
    <div class="sidebar">
        <p class="sidebar-title">その他の取引</p>
        @foreach ($otherOrders as $order)
        <a class="other-deal adjustable-text" href="{{ route('chat.show', $order->id) }}">{{ $order->item->title }}</a>
        @endforeach
    </div>

    <div class="chat-container" id="chat-container" data-order-id="{{ $currentOrder->id }}">
        <section class="chat-header">
            <img class="user-image" src="{{ asset('storage/' . $otherUser->profile_image) }}" alt="{{ $otherUser->name }}">
            <h1 class="chat-header-title">{{ $otherUser->name }}さんとの取引画面</h1>
            @error('rating')
            <div class="error rating-error">{{ $message }}</div>
            @enderror
            @if ($currentOrder->buyer_id === auth()->user()->id &&
            $reviewSubmitted === false ||
            $reviewReceived === true)
            <button class="complete-deal" id="openReviewModal">取引を完了する</button>
            @endif
            <form id="reviewModal" class="modal" action="{{ route('review.store', $currentOrder->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <section class="headline-section">
                        <h2>取引が完了しました。</h2>
                    </section>
                    <section class="rating-section">
                        <p class="subtitle">今回の取引相手はどうでしたか？</p>
                        <input type="hidden" name="rating" id="ratingInput">
                        <div class="stars">
                            <span data-value="1">★</span>
                            <span data-value="2">★</span>
                            <span data-value="3">★</span>
                            <span data-value="4">★</span>
                            <span data-value="5">★</span>
                        </div>
                    </section>
                    <section class="action-section">
                        <button class="submit-button">送信する</button>
                    </section>
                </div>
            </form>
        </section>

        <section class="item-info-container">
            <img class="item-image" src="{{ asset('storage/' . $item->item_image) }}" alt="$item->name">
            <div class="item-info">
                <h2 class="item-title">{{ $item->title }}</h2>
                <p class="item-price">￥{{ $item->price }}</p>
            </div>
        </section>

        @error('edit.message')
            <div class="error edit-error">{{ $message }}</div>
        @enderror
        <section class="chat-messages-container">
            @foreach ($messages as $message)
            <div class="chat-message {{ $message->user_id === auth()->id() ? 'outgoing' : 'incoming' }}">
                <div class="chat-user">
                    @if ($message->user_id !== auth()->id())
                    <img class="user-image in-chat" src="{{ asset('storage/' . $otherUser->profile_image) }}" alt="{{ $otherUser->name }}">
                    <p>{{ $otherUser->name }}</p>
                    @else
                    <p>{{ auth()->user()->name }}</p>
                    <img class="user-image in-chat" src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="{{ auth()->user()->name }}">
                    @endif
                </div>
                <p class="chat-text" id="chat-text-{{ $message->id }}">{{ $message->message }}</p>
                <form class="edit-form hidden" id="edit-form-{{ $message->id }}" method="POST" action="{{ route('chat.update', $message->id) }}">
                    @csrf
                    @method('PUT')
                    <textarea class="edit-area auto-resize" name="edit[message]">{{ old('edit.message', $message->message) }}</textarea>
                </form>
                <div class="chat-actions">
                    <div class="left-actions">
                        <button class="chat-actions-button hidden" id="save-{{ $message->id }}" type="submit" form="edit-form-{{ $message->id }}">保存</button>
                    </div>
                    <div class="right-actions">
                        @if ($message->user_id === auth()->id())
                        <button class="chat-actions-button" type="button" id="edit-toggle-{{ $message->id }}" onclick="toggleEdit({{ $message->id }})">編集</button>
                        <form action="{{ route('chat.destroy', $message->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？')">
                            @csrf
                            @method('DELETE')
                            <button class="chat-actions-button" type="submit" class="button-link">削除</button>
                        </form>
                        @endif
                    </div>
                </div>
                @if ($message->image)
                <img class="chat-image" src="{{ asset('storage/' . $message->image) }}" alt="メッセージ画像">
                @endif
            </div>
            @endforeach
        </section>

        <section class="chat-input-container">
            @php
                $sendErrors = collect($errors->getMessages())
                    ->filter(function ($value, $key) {
                        return str_starts_with($key, 'send.');
                    });
            @endphp
            @if ($sendErrors->isNotEmpty())
                <ul class="error send-error">
                    @foreach ($sendErrors as $field => $messages)
                        @foreach ($messages as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    @endforeach
                </ul>
            @endif

            <form class="chat-form" action="{{ route('chat.store', ['orderId' => $currentOrder->id]) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <textarea
                    class="textarea auto-resize"
                    name="send[message]"
                    id="message"
                    placeholder="取引メッセージを記入してください"
                    autocomplete="off">{{ old('send.message') }}</textarea>
                <input type="file" name="send[image]" id="upload-image">
                <label class="upload-image-button" for="upload-image">画像を選択</label>
                <button class="chat-sending-button" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                        <path d="M120-160v-640l760 320-760 320Zm80-120 474-200-474-200v140l240 60-240 60v140Zm0 0v-400 400Z" />
                    </svg>
                </button>
            </form>
        </section>
    </div>
</div>
<script src="{{ asset('js/dealing_chat.js') }}"></script>
<script src="{{ asset('js/review.js') }}"></script>
@endsection