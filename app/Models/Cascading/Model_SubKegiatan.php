<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_SubKegiatan extends Model
{
    protected $table = "cascading_sub_kegiatan";
    protected $fillable = ['id_kegiatan','id_visi', 'kode_sub_kegiatan', 'sub_kegiatan', 'creator', 'created_at', 'updated_at'];

    public function subkegiatan_indikator()
    {
        return $this->hasMany(Model_SubKegiatan_Indikator::class, 'id_sub_kegiatan');
    }
}
