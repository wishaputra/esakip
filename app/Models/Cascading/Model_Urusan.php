<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Urusan extends Model
{
    protected $table = "cascading_urusan";
    protected $fillable = ['id_sasaran','id_visi', 'urusan', 'creator', 'created_at', 'updated_at'];

    public function sasaran()
    {
        return $this->belongsTo(Model_Sasaran::class, 'id_sasaran');
    }

    public function urusan_indikator()
    {
        return $this->hasMany(Model_Urusan_Indikator::class, 'id_urusan');
    }

    // Updated relationship
    public function tujuanRenstra()
    {
        return $this->hasMany(Model_Tujuan_Renstra::class, 'id_urusan');
    }
}