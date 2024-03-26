<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $table = "info";
    protected $fillable = ['kategori', 'totalBed', 'bedTerpakai'];
    public $timestamps = false;

    // public function sub_menus()
    // {
    //     return $this->hasMany(Sub_menu::class)->orderBy('no_urut');
    // }
}
