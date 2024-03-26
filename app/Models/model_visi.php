<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class model_visi extends Model
{
    protected $table = "cascading_visi";
    protected $fillable = ['tahun_awal', 'tahun_akhir', 'visi', 'creator', 'created_at', 'updated_at'];

    public function misi()
    {
        return $this->hasMany(model_misi::class, 'id');
    }
}
