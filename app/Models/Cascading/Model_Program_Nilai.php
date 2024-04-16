<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Program_Nilai extends Model
{
    protected $table = "cascading_program_nilai";
    protected $fillable = ['id_indikator_program', 'satuan', 'tahun', 'target', 'capaian', 'creator', 'created_at', 'updated_at'];

    // public function misi()
    // {
    //     return $this->hasMany(Model_Misi::class, 'id_visi');
    // }
}
