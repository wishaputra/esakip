<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Tujuan_Renstra_Indikator extends Model
{
    protected $table = "cascading_tujuan_renstra_indikator";
    protected $fillable = ['id_tujuan_renstra', 'indikator', 'creator', 'created_at', 'updated_at'];

    public function tujuan_renstra()
    {
        return $this->belongsTo(Model_Tujuan_Renstra::class, 'id');
    }

    public function tujuan_renstra_nilai()
    {
        return $this->hasMany(Model_Tujuan_Renstra_Nilai::class, 'id_indikator_tujuan_renstra');
    }
}
