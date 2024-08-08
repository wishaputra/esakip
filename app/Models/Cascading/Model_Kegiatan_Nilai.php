<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Kegiatan_Nilai extends Model
{
    protected $table = "cascading_kegiatan_nilai";
    protected $fillable = ['id_indikator_kegiatan', 'satuan', 'tahun', 'triwulan', 'pagu', 'target', 'capaian', 'creator', 'created_at', 'updated_at'];

    public function kegiatan_indikator()
    {
        // Assuming 'id_indikator_kegiatan' is the correct foreign key
        return $this->belongsTo(Model_Kegiatan_Indikator::class, 'id_indikator_kegiatan');
    }

    public function subKegiatanNilai()
    {
        // This is assuming 'id_indikator_sub_kegiatan' is the foreign key in 'Model_SubKegiatan_Nilai'
        return $this->hasMany(Model_SubKegiatan_Nilai::class, 'id_indikator_sub_kegiatan', 'id');
    }
}
