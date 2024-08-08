<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_SubKegiatan_Nilai extends Model
{
    protected $table = "cascading_sub_kegiatan_nilai";
    protected $fillable = ['id_indikator_sub_kegiatan', 'satuan', 'tahun', 'triwulan', 'pagu', 'target', 'capaian', 'creator', 'created_at', 'updated_at'];

    public function subkegiatan_indikator()
    {
        // Assuming 'id' is the primary key in 'Model_SubKegiatan_Indikator'
        return $this->belongsTo(Model_SubKegiatan_Indikator::class, 'id_indikator_sub_kegiatan');
    }

    public function kegiatanNilai()
    {
        // Assuming 'id_indikator_kegiatan' is the correct foreign key in this model
        return $this->belongsTo(Model_Kegiatan_Nilai::class, 'id_indikator_kegiatan');
    }
}
