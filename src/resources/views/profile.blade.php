@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/appearance_profile.css') }}" />
<link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
<div class="mypage-header-container">
    <div class="logo-container">
        <div class="profile-image">
            <img src="{{ asset(auth()->check() && auth()->user()->profile_image ? 'storage/' . auth()->user()->profile_image : 'storage/users/default.png') }}" alt="プロフィール画像">
        </div>
        <div>
            <h1>{{ auth()->check() ? auth()->user()->name : 'ゲスト' }}</h1>
            @if ($averageRating > 0)
            <div class="rating-stars">
                @for ($i = 1; $i <= 5; $i++)
                    <span class="star {{ $i <= $averageRating ? 'filled' : '' }}">★</span>
                @endfor
            </div>
            @endif
        </div>
    </div>
    <div>
        <a href="{{ route('profile.edit') }}" class="edit-profile-button">プロフィールを編集</a>
    </div>
</div>

<div>
    <nav class="items-tab">
        <ul class="tabs">
            <li class="{{ $tab === 'sell' ? 'active-tab' : '' }}">
                <a href="{{ route('profile.index', ['tab' => 'sell']) }}">
                    出品した商品
                </a>
            </li>
            <li class="{{ $tab === 'buy' ? 'active-tab' : '' }}">
                <a href="{{ route('profile.index', ['tab' => 'buy']) }}">
                    購入した商品
                </a>
            </li>
            <li class="{{ $tab === 'dealing' ? 'active-tab' : '' }}">
                <a href="{{ route('profile.index', ['tab' => 'dealing']) }}">
                    取引中の商品
                    @if ($unreadCount > 0)
                    <span>{{ $unreadCount }}</span>
                    @endif
                </a>
            </li>
        </ul>
    </nav>
</div>

<div class="items-container">
    @forelse ($items as $item)
        @php
            $itemUnreadCount = $item->orders->sum(function ($order) {
                return $order->chats->filter(function ($chat) {
                    return $chat->user_id !== auth()->id();
                })->count();
            });
        @endphp
        <div class="item" data-item-id="{{ $item->id }}">
            @if ($tab === 'dealing')
                <a href="{{ route('chat.show', $item->orders->first()->id) }}" class="item-link">
            @else
                <a href="{{ route('items.show', $item->id) }}" class="item-link">
            @endif
                <div class="item-image">
                    <img src="{{ asset('storage/' . $item->item_image) }}" alt="{{ $item->title }}">
                </div>
                <p class="item-name">{{ $item->title }}</p>
                @if ($item->sales_status == 'sold')
                    <p class="item-status">Sold</p>
                @endif
                @if ($tab === 'dealing' && $itemUnreadCount > 0)
                    <p class="unread-count">{{ $itemUnreadCount }}</p>
                @endif
            </a>
        </div>
        @empty
        <p>表示する商品がありません。</p>
    @endforelse
</div>
@endsection