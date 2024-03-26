<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatKbResource extends JsonResource
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
            // "peserta_id" =>$this->peserta_id,
            "jenis_kb_id" =>$this->jenis_kb_id,
            "jenis_kb" =>$this->jenis_kb->nama,
            "faskes_id" =>$this->faskes_id,
            "faskes" =>$this->faskes->nama,
            "tgl_kb" =>$this->tgl_kb,

        ];
    }
}
