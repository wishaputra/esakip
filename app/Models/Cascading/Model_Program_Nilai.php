<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Program_Nilai extends Model
{
    protected $table = "cascading_program_nilai";
    protected $fillable = ['id_indikator_program', 'satuan', 'tahun', 'triwulan', 'pagu', 'target', 'capaian', 'creator', 'created_at', 'updated_at'];

    public function program_indikator()
    {
        return $this->belongsTo(Model_Program_Indikator::class, 'id');
    }
}
