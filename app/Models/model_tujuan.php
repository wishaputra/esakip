<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class model_tujuan extends Model
{
    protected $table = "cascading_tujuan";
    protected $fillable = ['id_misi', 'tujuan', 'creator', 'created_at', 'updated_at'];

    public function visi()
    {
        return $this->belongsTo(model_misi::class, 'id_misi');
    }
}
