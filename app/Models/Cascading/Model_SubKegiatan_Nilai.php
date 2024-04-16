<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_SubKegiatan_Nilai extends Model
{
    protected $table = "cascading_sub_kegiatan_nilai";
    protected $fillable = ['id_indikator_sub_kegiatan', 'satuan', 'tahun', 'target', 'capaian', 'creator', 'created_at', 'updated_at'];

    // public function misi()
    // {
    //     return $this->hasMany(Model_Misi::class, 'id_visi');
    // }
}
