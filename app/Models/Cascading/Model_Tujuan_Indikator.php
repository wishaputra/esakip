<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Tujuan_Indikator extends Model
{
    protected $table = "cascading_tujuan_indikator";
    protected $fillable = ['id_tujuan', 'indikator', 'creator', 'created_at', 'updated_at'];

    public function tujuan()
    {
        return $this->belongsTo(Model_Tujuan::class, 'id_tujuan');
    }

    public function tujuan_nilai()
    {
        return $this->hasMany(Model_Tujuan_Nilai::class, 'id_indikator_tujuan');
    }
}
