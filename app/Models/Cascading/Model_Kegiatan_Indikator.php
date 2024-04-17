<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Kegiatan_Indikator extends Model
{
    protected $table = "cascading_kegiatan_indikator";
    protected $fillable = ['id_kegiatan', 'indikator', 'creator', 'created_at', 'updated_at'];

    public function kegiatan()
    {
        return $this->belongsTo(Model_Kegiatan::class, 'id');
    }

    public function kegiatan_nilai()
    {
        return $this->hasMany(Model_Kegiatan_Nilai::class, 'id_indikator_kegiatan');
    }
}
