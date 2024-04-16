<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class model_visi extends Model
{
    protected $table = "cascading_visi";
    protected $fillable = ['tahun_awal', 'tahun_akhir', 'visi', 'creator', 'created_at', 'updated_at', 'has_child'];


    public function visi()
{
    return $this->belongsTo(model_visi::class, 'id_visi');
}
}
