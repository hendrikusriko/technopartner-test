<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';

    protected $fillable = [
        'type',
        'category_id',
        'nominal',
        'desc'
    ];
    use HasFactory;

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
