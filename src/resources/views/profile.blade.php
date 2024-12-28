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
        <h1>{{ auth()->check() ? auth()->user()->name : 'ゲスト' }}</h1>
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
        </ul>
    </nav>
</div>

<div class="items-container">
    @forelse ($items as $item)
    <div class="item" data-item-id="{{ $item->id }}">
        <a href="{{ route('items.show', $item->id) }}" class="item-link">
            <div class="item-image">
                <img src="{{ asset('storage/' . $item->item_image) }}" alt="{{ $item->title }}">
            </div>
            <p class="item-name">{{ $item->title }}</p>
            @if ($item->sales_status == 'sold')
            <p class="item-status">Sold</p>
            @endif
        </a>
    </div>
    @empty
    <p>表示する商品がありません。</p>
    @endforelse
</div>
@endsection