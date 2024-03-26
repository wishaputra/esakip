<?php

namespace App\Models\Section;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingList extends Model
{
    use HasFactory;
    protected $table = "section_pricing_list";
    protected $fillable = ['order','pricing_id','nama','check'];
}
