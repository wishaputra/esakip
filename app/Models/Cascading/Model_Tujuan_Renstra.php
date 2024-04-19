<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Tujuan_Renstra extends Model
{
    protected $table = "cascading_tujuan_renstra";
    protected $fillable = ['id_sasaran', 'id_visi' , 'id_perangkat_daerah', 'tujuan_renstra', 'creator', 'created_at', 'updated_at'];

    public function tujuan_renstra_indikator()
    {
        return $this->hasMany(Model_Tujuan_Renstra_Indikator::class, 'id_tujuan_renstra');
    }
}
