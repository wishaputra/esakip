<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Kegiatan_Nilai extends Model
{
    protected $table = "cascading_kegiatan_nilai";
    protected $fillable = ['id_indikator_kegiatan', 'satuan', 'tahun', 'target', 'capaian', 'creator', 'created_at', 'updated_at'];

    public function kegiatan_indikator()
    {
        return $this->belongsTo(Model_Kegiatan_Indikator::class, 'id');
    }
}
