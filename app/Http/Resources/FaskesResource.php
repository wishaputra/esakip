<?php

namespace App\Http\Resources;

use App\Models\Jenis_faskes;
use Illuminate\Http\Resources\Json\JsonResource;

class FaskesResource extends JsonResource
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
            "kecamatan" => $this->kecamatan->n_kecamatan,
            "kecamatan_id" => $this->kecamatan_id,
            "kelurahan" => $this->kelurahan->n_kelurahan,
            "kelurahan_id" => $this->kelurahan_id,
            "n_jenis_faskes" => $this->jenis_faskes->nama,
            "jenis_faskes_id" => $this->jenis_faskes_id,
            "nama" => $this->nama,
            "alamat" => $this->alamat,
            "telp" => $this->telp,
            "whatsapp" => $this->whatsapp,
            "photo" => $this->getPhoto(),
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            // "jenis_faskes" => JenisFaskesResource::collection(Jenis_faskes::all())
        ];
    }
}
