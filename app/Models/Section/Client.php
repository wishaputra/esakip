<?php

namespace App\Models\Section;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'section_client';
    protected $fillable = ['order','nama','image'];

    public function getImage()
    {
        return asset($this->image);
    }
}
