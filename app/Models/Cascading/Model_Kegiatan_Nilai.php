<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Kegiatan_Nilai extends Model
{
    protected $table = "cascading_kegiatan_nilai";
    protected $fillable = [
        'id_indikator_kegiatan', 'satuan', 'tahun', 'triwulan', 
        'pagu', 'target', 'capaian', 'creator', 'created_at', 'updated_at'
    ];

    public function subKegiatanNilai()
    {
        return $this->hasMany(Model_SubKegiatan_Nilai::class, 'id_indikator_sub_kegiatan', 'id_indikator_sub_kegiatan');
    }

    public function updatePagu()
    {
        $this->pagu = $this->subKegiatanNilai->sum('pagu');
        $this->save();
    }
}
