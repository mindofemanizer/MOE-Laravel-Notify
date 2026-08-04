<?php

declare(strict_types=1);

namespace Moe\Notify\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'notifiable_type',
        'notifiable_id',
        'channel',
        'subject',
        'body',
        'data',
        'status',
        'sent_at',
        'read_at',
        'failed_reason',
    ];

    protected $casts = [
        'data' => 'array',
        'sent_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    protected $table = 'notifications';
}
