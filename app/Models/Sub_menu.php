<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sub_menu extends Model
{
    protected $table = "sub_menu";
    protected $fillable = ['nama', 'no_urut', 'route', 'menu_id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class)->orderBy('no_urut');
    }

    public function sub_menus2()
    {
        return $this->hasMany(SubMenu2::class, 'sub_menu_id')->orderBy('no_urut');
    }
}
