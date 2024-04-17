<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Program_Indikator extends Model
{
    protected $table = "cascading_program_indikator";
    protected $fillable = ['id_program', 'indikator', 'creator', 'created_at', 'updated_at'];

    public function program()
    {
        return $this->belongsTo(Model_Program::class, 'id');
    }

    public function program_nilai()
    {
        return $this->hasMany(Model_Program_Nilai::class, 'id_indikator_program');
    }
}
