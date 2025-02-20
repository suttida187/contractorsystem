<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageDeliverWork extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_project',
        'image',
        'message_admin',
        'message_pm',
        'status'
    ];
}