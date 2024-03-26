<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KesReproduksiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "peserta_id" => $this->peserta_id,
            "riwayat_haid_id" => $this->riwayat_haid_id,
            "riwayat_haid" => $this->riwayat_haid->nama,
            "riwayat_penyakit_id" => $this->riwayat_penyakit_id,
            "riwayat_penyakit" => $this->riwayat_penyakit->nama,
            "umur_haid_pertama" => $this->umur_haid_pertama,
            "jumlah_kehamilan" => $this->jumlah_kehamilan,
            "jumlah_anak" => $this->jumlah_anak,
            "riwayat_keguguran" => $this->riwayat_keguguran,
            "sosialisasi" => $this->sosialisasi,
            "sosialisasi_jumlah" => $this->sosialisasi_jumlah,
            "sosialisasi_penyelenggara" => $this->sosialisasi_penyelenggara,
            "sosialisasi_tahun" => $this->sosialisasi_tahun,
            "sosialisasi_lokasi" => $this->sosialisasi_lokasi

        ];
    }
}
