<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class model_misi extends Model
{
    protected $table = "cascading_misi";
    protected $fillable = ['id_visi', 'misi', 'creator', 'created_at', 'updated_at', 'parent_id'];


    public function misi()
{
    return $this->hasMany(model_misi::class, 'id_visi');
}
}
