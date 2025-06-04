<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeStep extends Model
{
    use HasFactory;

    // Укажите, какие атрибуты можно массово присваивать
    protected $fillable = [
        'product_id',
        'instruction',
        'image',
    ];

    // Определение связи с моделью Product (если нужна)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Возможно, добавление других методов
}
