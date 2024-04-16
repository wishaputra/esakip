<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Kegiatan extends Model
{
    protected $table = "cascading_kegiatan";
    protected $fillable = ['id_program', 'kode_kegiatan', 'kegiatan', 'creator', 'created_at', 'updated_at'];

    // public function misi()
    // {
    //     return $this->hasMany(Model_Misi::class, 'id_visi');
    // }
}
