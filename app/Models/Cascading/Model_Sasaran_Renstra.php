<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Sasaran_Renstra extends Model
{
    protected $table = "cascading_sasaran_renstra";
    protected $fillable = ['id_tujuan_renstra', 'sasaran_renstra', 'creator', 'created_at', 'updated_at'];

    // public function misi()
    // {
    //     return $this->hasMany(Model_Misi::class, 'id_visi');
    // }
}
