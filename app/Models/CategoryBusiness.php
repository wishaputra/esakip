<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryBusiness extends Model
{
    use HasFactory;
    protected $table = 'category_business';
    protected $fillable = ['name', 'order', 'icon', 'slug', 'type', 'url'];

    public function business()
    {
        return $this->hasMany(Business::class, 'business_category_id');
    }
}
