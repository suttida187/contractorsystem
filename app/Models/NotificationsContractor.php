<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationsContractor extends Model
{
    use HasFactory;
    protected $fillable = [
        'notifiable_id',
        'data',
        'read_at',
    ];
}
