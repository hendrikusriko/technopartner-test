<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    
    protected $fillable = [
        'type',
        'name',
        'desc'
    ];

    use HasFactory;
}
