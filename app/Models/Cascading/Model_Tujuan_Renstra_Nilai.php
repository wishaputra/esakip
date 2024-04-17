<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Tujuan_Renstra_Nilai extends Model
{
    protected $table = "cascading_tujuan_renstra_nilai";
    protected $fillable = ['id_indikator_tujuan_renstra', 'satuan', 'tahun', 'target', 'capaian', 'creator', 'created_at', 'updated_at'];

    public function tujuan_renstra_indikator()
    {
        return $this->belongsTo(Model_Tujuan_Renstra_Indikator::class, 'id');
    }
}
