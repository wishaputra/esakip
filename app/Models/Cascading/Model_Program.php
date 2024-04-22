<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Program extends Model
{
    protected $table = "cascading_program";
    protected $fillable = ['id_sasaran_renstra','id_visi', 'kode_program', 'program', 'creator', 'created_at', 'updated_at'];

    public function program_indikator()
    {
        return $this->hasMany(Model_Program_Indikator::class, 'id_program');
    }
}
