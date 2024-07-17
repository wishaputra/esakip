<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Sasaran_Nilai extends Model
{
    protected $table = "cascading_sasaran_nilai";
    protected $fillable = ['id_indikator_sasaran', 'satuan', 'tahun', 'triwulan', 'pagu', 'target', 'capaian', 'creator', 'created_at', 'updated_at'];

    public function sasaran_indikator()
    {
        return $this->belongsTo(Model_Sasaran_Indikator::class, 'id');
    }
}
