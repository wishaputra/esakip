<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = "menu";
    protected $fillable = ['nama', 'no_urut', 'route'];

    public function sub_menus()
    {
        return $this->hasMany(Sub_menu::class)->orderBy('no_urut');
    }
}
