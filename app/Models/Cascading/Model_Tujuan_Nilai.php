<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Tujuan_Nilai extends Model
{
    protected $table = "cascading_tujuan_nilai";
    protected $fillable = ['id_indikator_tujuan', 'satuan', 'tahun', 'target', 'capaian', 'creator', 'created_at', 'updated_at'];

    public function tujuan_indikator()
    {
        return $this->belongsTo(Model_Tujuan_Indikator::class, 'id');
    }
}
