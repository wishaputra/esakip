<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextContent extends Model
{
    use HasFactory;
    protected $table = 'text_content';
    protected $fillable = ['title','subtitle','description','sub_subtitle','alamat','telp','email','link_maps','text_button','content'];
}
