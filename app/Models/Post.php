<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;
    public $fillable = ['date', 'title', 'content', 'status', 'menu_id', 'type', 'slug', 'thumbnail', 'post_category_id', 'created_by', 'updated_by', 'created_at'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = Auth::user()->name;
        });
        static::updating(function ($model) {
            $model->updated_by = Auth::user()->name;
        });
    }

    public function getImage()
    {
        return asset($this->thumbnail);
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'post_category_id');
    }
}
