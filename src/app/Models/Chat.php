<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'order_id',
        'user_id',
        'is_read',
        'message',
        'image',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public const STATUS_UNREAD = 0;
    public const STATUS_IS_READ = 1;

    public const CHATS_STATUSES = [
        self::STATUS_UNREAD => '未読',
        self::STATUS_IS_READ => '既読',
    ];

    public function getChatsStatusAttribute()
    {
        return self::CHATS_STATUSES[$this->status] ?? '不明';
    }
}
