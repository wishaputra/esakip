<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_SubKegiatan extends Model
{
    protected $table = "cascading_sub_kegiatan";
    protected $fillable = ['id_kegiatan', 'kode_sub_kegiatan', 'sub_kegiatan', 'creator', 'created_at', 'updated_at'];

    // public function misi()
    // {
    //     return $this->hasMany(Model_Misi::class, 'id_visi');
    // }
}
