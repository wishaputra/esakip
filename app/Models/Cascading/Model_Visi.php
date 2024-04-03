<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Visi extends Model
{
    protected $table = "cascading_visi";
    protected $fillable = ['tahun_awal', 'tahun_akhir', 'visi', 'creator', 'created_at', 'updated_at'];

    public function misi()
    {
        return $this->hasMany(Model_Misi::class, 'id_visi');
    }
}
