<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    // Укажите, какие атрибуты можно массово присваивать
    protected $fillable = [
        'product_id',
        'name',
        'quantity',
        'unit',
    ];

    // Определение связи с моделью Product (если нужна)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Можно добавить дополнительные методы, если это необходимо
}
