<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Program extends Model
{
    protected $table = "cascading_program";
    protected $fillable = ['id_sasaran_renstra', 'kode_program', 'program', 'creator', 'created_at', 'updated_at'];

    // public function misi()
    // {
    //     return $this->hasMany(Model_Misi::class, 'id_visi');
    // }
}
