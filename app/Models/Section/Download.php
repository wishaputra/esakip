<?php

namespace App\Models\Section;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;
    protected $table = 'section_download';
    protected $fillable = ['order', 'nama', 'file'];

    public function getUrl()
    {
        return asset($this->file);
    }
}
