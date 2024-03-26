<?php

namespace App\Models\Section;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'section_slider';
    protected $fillable = ['order', 'title', 'description', 'link', 'image'];

    public function getImage()
    {
        return asset($this->image);
    }
}
