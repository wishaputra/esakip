<?php

namespace App\Http\Resources;

use App\Models\Riwayat_kb;
use Illuminate\Http\Resources\Json\JsonResource;

class PesertaResource extends JsonResource
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
            "id" => $this->id,
            "user_id" => $this->user_id,
            "pendidikan" => $this->pendidikan->nama,
            "pendidikan_id" => $this->pendidikan_id,
            "pekerjaan" => $this->pekerjaan->nama,
            "pekerjaan_id" => $this->pekerjaan_id,
            "cakupan" => $this->cakupan->nama,
            "cakupan_id" => $this->cakupan_id,
            "kecamatan" => $this->kecamatan->n_kecamatan,
            "kecamatan_id" => $this->kecamatan_id,
            "kelurahan" => $this->kelurahan->n_kelurahan,
            "kelurahan_id" => $this->kelurahan_id,
            'nik' => $this->nik,
            'nama' => $this->nama,
            "nama_suami" => $this->nama_suami,
            "nama_bapak" => $this->nama_bapak,
            "nama_ibu" => $this->nama_ibu,
            "tempat_lahir" => $this->tempat_lahir,
            "tanggal_lahir" => $this->tanggal_lahir,
            "alamat_domisili"=>$this->alamat_domisili,
            // 'kesreproduksi' => new KesReproduksiResource($this->kes_reproduksi),
            // 'riwayatkb' => RiwayatKbResource::collection($this->riwayat_kb) ,
        ];
    }
}
