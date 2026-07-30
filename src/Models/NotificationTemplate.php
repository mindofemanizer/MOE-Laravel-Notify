<?php

declare(strict_types=1);

namespace MOE\Notify\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    protected $fillable = [
        'key',
        'name',
        'subject',
        'body',
        'channels',
        'variables',
    ];

    protected $casts = [
        'channels' => 'array',
        'variables' => 'array',
    ];

    protected $table = 'notification_templates';
}
