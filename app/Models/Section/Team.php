<?php

namespace App\Models\Section;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $table = 'section_team';
    protected $fillable = ['order','nama','jabatan','facebook_link','twitter_link','poto'];
}
