<?php

namespace App\Models\Section;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intro extends Model
{
    use HasFactory;
    protected $table = 'section_intro';
    protected $fillable = ['title','subtitle','description','text_button','href_button','image'];
}
