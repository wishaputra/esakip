<?php

namespace App\Models\Section;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;
    protected $table = 'info';
    protected $fillable = ['kategori', 'total_bed', 'bed_terpakai'];

    public function getUrl()
    {
        return asset($this->file);
    }
}
