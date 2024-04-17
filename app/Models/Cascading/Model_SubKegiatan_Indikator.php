<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_SubKegiatan_Indikator extends Model
{
    protected $table = "cascading_sub_kegiatan_indikator";
    protected $fillable = ['id_sub_kegiatan', 'indikator', 'creator', 'created_at', 'updated_at'];

    public function subkegiatan()
    {
        return $this->belongsTo(Model_SubKegiatan::class, 'id');
    }

    public function subkegiatan_nilai()
    {
        return $this->hasMany(Model_SubKegiatan_Nilai::class, 'id_indikator_sub_kegiatan');
    }
}
