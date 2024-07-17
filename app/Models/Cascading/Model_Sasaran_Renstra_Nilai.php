<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Sasaran_Renstra_Nilai extends Model
{
    protected $table = "cascading_sasaran_renstra_nilai";
    protected $fillable = ['id_indikator_sasaran_renstra', 'satuan', 'tahun', 'triwulan', 'pagu', 'target', 'capaian', 'creator', 'created_at', 'updated_at'];

    public function sasaran_renstra_indikator()
    {
        return $this->belongsTo(Model_Sasaran_Renstra_Indikator::class, 'id');
    }
}
