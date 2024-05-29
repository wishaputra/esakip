<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;


class Model_Kegiatan extends Model
{
    protected $table = "cascading_kegiatan";
    protected $fillable = ['id_program','id_visi', 'kode_kegiatan', 'kegiatan', 'creator', 'created_at', 'updated_at'];

    public function kegiatan_indikator()
    {
        return $this->hasMany(Model_Kegiatan_Indikator::class, 'id_kegiatan');
    }

    
    public function cascading_sub_kegiatan()
    {
        return $this->hasMany(Model_SubKegiatan::class, 'id_kegiatan');
    }
    
}
