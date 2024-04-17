<?php

namespace App\Models\Cascading;

use Illuminate\Database\Eloquent\Model;

class Model_Tujuan extends Model
{
    protected $table = "cascading_tujuan";
    protected $fillable = ['id_misi', 'tujuan', 'creator', 'created_at', 'updated_at'];

    public function misi()
    {
        return $this->belongsTo(Model_Misi::class, 'id_misi');
    }
}
