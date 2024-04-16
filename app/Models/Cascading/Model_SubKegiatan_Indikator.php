<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_SubKegiatan_Indikator extends Model
{
    protected $table = "cascading_sub_kegiatan_indikator";
    protected $fillable = ['id_sub_kegiatan', 'indikator', 'creator', 'created_at', 'updated_at'];

    // public function misi()
    // {
    //     return $this->hasMany(Model_Misi::class, 'id_visi');
    // }
}
