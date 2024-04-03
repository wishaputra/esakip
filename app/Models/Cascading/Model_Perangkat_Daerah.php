<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Perangkat_Daerah extends Model
{
    protected $table = "cascading_perangkat_daerah";
    protected $fillable = ['perangkat_daerah', 'creator', 'created_at', 'updated_at'];

    // public function misi()
    // {
    //     return $this->hasMany(Model_Misi::class, 'id_visi');
    // }
}
