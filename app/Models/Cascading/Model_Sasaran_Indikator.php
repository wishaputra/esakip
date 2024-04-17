<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Sasaran_Indikator extends Model
{
    protected $table = "cascading_sasaran_indikator";
    protected $fillable = ['id_sasaran', 'indikator', 'creator', 'created_at', 'updated_at'];

    public function sasaran()
    {
        return $this->belongsTo(Model_Sasaran::class, 'id');
    }

    public function sasaran_nilai()
    {
        return $this->hasMany(Model_Sasaran_Nilai::class, 'id_indikator_sasaran');
    }
}
