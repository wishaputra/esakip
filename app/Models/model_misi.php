<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class model_misi extends Model
{
    protected $table = "cascading_misi";
    protected $fillable = ['id_visi', 'misi', 'creator', 'created_at', 'updated_at'];

    public function visi()
    {
        return $this->belongsTo(model_visi::class)->orderBy('id');
    }
}
