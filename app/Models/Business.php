<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Storage;

class Business extends Model
{
    use HasFactory;
    protected $table = "business";
    protected $fillable = ['date', 'title','tab_content', 'content','tab_content_2', 'content_2','tab_content_3', 'content_3','tab_content_4', 'content_4','tab_content_5', 'content_5', 'status', 'menu_id', 'type', 'slug', 'thumbnail','business_category_id','created_by','updated_by'];

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
        if (Storage::disk('public')->exists($this->thumbnail)) {
            return asset($this->thumbnail);
        }
        return 'https://via.placeholder.com/960x760.png';
    }
    public function category()
    {
        return $this->belongsTo(CategoryBusiness::class, 'business_category_id');
    }
}
