<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu2 extends Model
{
    use HasFactory;
    protected $table = "sub_menu_2";
    protected $fillable = ['nama', 'no_urut', 'route', 'sub_menu_id'];

    public function sub_menu()
    {
        return $this->belongsTo(Sub_menu::class, 'sub_menu_id')->orderBy('no_urut');;
    }
}
