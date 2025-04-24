<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'buyer_id',
        'seller_id',
        'status',
        'shipping_postal_code',
        'shipping_address',
        'shipping_building',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public const STATUS_DEALING = 0;
    public const STATUS_COMPLETED = 1;

    public const DEALS_STATUSES = [
        self::STATUS_DEALING => '取引中',
        self::STATUS_COMPLETED => '取引完了',
    ];

    public function getDealsStatusAttribute()
    {
        return self::DEALS_STATUSES[$this->status] ?? '不明';
    }
}