<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Urusan_Indikator extends Model
{
    protected $table = "cascading_urusan_indikator";
    protected $fillable = ['id_urusan', 'indikator', 'creator', 'created_at', 'updated_at'];

    public function urusan()
    {
        return $this->belongsTo(Model_Urusan::class, 'id');
    }

    public function urusan_nilai()
    {
        return $this->hasMany(Model_Urusan_Nilai::class, 'id_indikator_urusan');
    }
}
