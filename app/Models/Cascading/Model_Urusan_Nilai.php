<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Urusan_Nilai extends Model
{
    protected $table = "cascading_urusan_nilai";
    protected $fillable = ['id_indikator_urusan', 'satuan', 'tahun', 'triwulan', 'pagu', 'target', 'capaian', 'creator', 'created_at', 'updated_at'];

    public function urusan_indikator()
    {
        return $this->belongsTo(Model_Urusan_Indikator::class, 'id');
    }
}
