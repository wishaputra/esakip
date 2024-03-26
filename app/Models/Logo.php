<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;
    protected $table = "logo";
    protected $fillable = ['logo', 'favicon'];

    public function getImage($id)
    {
        if ($id == 1) {
            return asset($this->logo);
        } else {
            return asset($this->favicon);
        }
    }
}
