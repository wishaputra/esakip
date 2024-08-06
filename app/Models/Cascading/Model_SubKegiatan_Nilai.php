<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_SubKegiatan_Nilai extends Model
{
    protected $table = "cascading_sub_kegiatan_nilai";
    protected $fillable = [
        'id_indikator_sub_kegiatan', 'satuan', 'tahun', 'triwulan', 
        'pagu', 'target', 'capaian', 'creator', 'created_at', 'updated_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($subKegiatanNilai) {
            $subKegiatanNilai->updateKegiatanNilaiPagu();
        });

        static::deleted(function ($subKegiatanNilai) {
            $subKegiatanNilai->updateKegiatanNilaiPagu();
        });
    }

    public function kegiatanNilai()
    {
        return $this->belongsTo(Model_Kegiatan_Nilai::class, 'id_indikator_kegiatan', 'id_indikator_kegiatan');
    }

    public function updateKegiatanNilaiPagu()
    {
        if ($this->kegiatanNilai) {
            $this->kegiatanNilai->updatePagu();
        }
    }
}
