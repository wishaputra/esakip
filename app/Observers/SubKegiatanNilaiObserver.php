<?php

namespace App\Observers;

use App\Models\Cascading\Model_SubKegiatan_Nilai;
use App\Models\Cascading\Model_Kegiatan_Nilai;

class SubKegiatanNilaiObserver
{
    /**
     * Handle the Model_SubKegiatan_Nilai "created" event.
     *
     * @param  \App\Models\Cascading\Model_SubKegiatan_Nilai  $subKegiatanNilai
     * @return void
     */
    public function created(Model_SubKegiatan_Nilai $subKegiatanNilai)
    {
        $this->updateKegiatanNilaiPagu($subKegiatanNilai->id_indikator_sub_kegiatan);
    }

    /**
     * Handle the Model_SubKegiatan_Nilai "updated" event.
     *
     * @param  \App\Models\Cascading\Model_SubKegiatan_Nilai  $subKegiatanNilai
     * @return void
     */
    public function updated(Model_SubKegiatan_Nilai $subKegiatanNilai)
    {
        $this->updateKegiatanNilaiPagu($subKegiatanNilai->id_indikator_sub_kegiatan);
    }

    /**
     * Handle the Model_SubKegiatan_Nilai "deleted" event.
     *
     * @param  \App\Models\Cascading\Model_SubKegiatan_Nilai  $subKegiatanNilai
     * @return void
     */
    public function deleted(Model_SubKegiatan_Nilai $subKegiatanNilai)
    {
        $this->updateKegiatanNilaiPagu($subKegiatanNilai->id_indikator_sub_kegiatan);
    }

    /**
     * Update the pagu value in Model_Kegiatan_Nilai
     *
     * @param  int  $idIndikatorSubKegiatan
     * @return void
     */
    protected function updateKegiatanNilaiPagu($idIndikatorSubKegiatan)
    {
        $totalPagu = Model_SubKegiatan_Nilai::where('id_indikator_sub_kegiatan', $idIndikatorSubKegiatan)->sum('pagu');

        $kegiatanNilai = Model_Kegiatan_Nilai::where('id', $idIndikatorSubKegiatan)->first();
        if ($kegiatanNilai) {
            $kegiatanNilai->pagu = $totalPagu;
            $kegiatanNilai->save();
        }
    }
}
