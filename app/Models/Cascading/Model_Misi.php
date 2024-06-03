<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Misi extends Model
{
    protected $table = "cascading_misi";
    protected $fillable = ['id_visi', 'misi', 'creator', 'created_at', 'updated_at'];

    public function visi()
    {
        return $this->belongsTo(Model_Visi::class, 'id_visi');
    }

    public function tujuan()
    {
        return $this->hasMany(Model_Tujuan::class, 'id_misi');
    }
}
