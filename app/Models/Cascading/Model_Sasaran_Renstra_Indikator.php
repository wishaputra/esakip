<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Sasaran_Renstra_Indikator extends Model
{
    protected $table = "cascading_sasaran_renstra_indikator";
    protected $fillable = ['id_sasaran_renstra', 'indikator', 'creator', 'created_at', 'updated_at'];

    public function sasaran_renstra()
    {
        return $this->belongsTo(Model_Sasaran_Renstra::class, 'id');
    }

    public function sasaran_renstra_nilai()
    {
        return $this->hasMany(Model_Sasaran_Renstra_Nilai::class, 'id_indikator_sasaran_renstra');
    }
}
