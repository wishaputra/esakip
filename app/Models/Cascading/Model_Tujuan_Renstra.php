<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Tujuan_Renstra extends Model
{
    protected $table = "cascading_tujuan_renstra";
    protected $fillable = ['id_sasaran', 'id_perangkat_daerah', 'tujuan_renstra', 'creator', 'created_at', 'updated_at'];

    // public function misi()
    // {
    //     return $this->hasMany(Model_Misi::class, 'id_visi');
    // }
}
