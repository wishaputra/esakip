<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Tujuan_Indikator extends Model
{
    protected $table = "cascading_tujuan_indikator";
    protected $fillable = ['id_tujuan', 'indikator', 'creator', 'created_at', 'updated_at'];

    // public function misi()
    // {
    //     return $this->hasMany(Model_Misi::class, 'id_visi');
    // }
}
