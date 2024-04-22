<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Sasaran_Renstra extends Model
{
    protected $table = "cascading_sasaran_renstra";
    protected $fillable = ['id_tujuan_renstra','id_visi', 'sasaran_renstra', 'creator', 'created_at', 'updated_at'];

    public function sasaran_renstra_indikator()
    {
        return $this->hasMany(Model_Sasaran_Renstra_Indikator::class, 'id_sasaran_renstra');
    }
}
