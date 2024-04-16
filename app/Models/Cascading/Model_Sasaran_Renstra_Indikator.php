<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Sasaran_Renstra_Indikator extends Model
{
    protected $table = "cascading_sasaran_renstra_indikator";
    protected $fillable = ['id_sasaran_renstra', 'indikator', 'creator', 'created_at', 'updated_at'];

    // public function misi()
    // {
    //     return $this->hasMany(Model_Misi::class, 'id_visi');
    // }
}
