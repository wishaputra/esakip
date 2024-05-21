<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Sasaran extends Model
{
    protected $table = "cascading_sasaran";
    protected $fillable = ['id_tujuan','id_visi', 'sasaran', 'creator', 'created_at', 'updated_at'];

    public function tujuan()
    {
        return $this->belongsTo(Model_Tujuan::class, 'id');
    }

    public function sasaran_indikator()
    {
        return $this->hasMany(Model_Sasaran_Indikator::class, 'id_sasaran');
    }

    public function perangkatDaerah()
    {
    return $this->hasMany(Model_Perangkat_Daerah::class, 'sasaran_id');
    }
}
