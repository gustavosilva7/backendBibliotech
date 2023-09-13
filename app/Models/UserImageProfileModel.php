<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImageProfileModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'imageUrl'
    ];
}
