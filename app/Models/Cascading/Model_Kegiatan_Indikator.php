<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Kegiatan_Indikator extends Model
{
    protected $table = "cascading_kegiatan_indikator";
    protected $fillable = ['id_kegiatan', 'indikator', 'creator', 'created_at', 'updated_at'];

    // public function misi()
    // {
    //     return $this->hasMany(Model_Misi::class, 'id_visi');
    // }
}
