<?php

namespace App\Models\Section;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;
    protected $table = "section_pricing";
    protected $fillable = ['order','nama','deskripsi','harga','durasi','badge_text','text_button','link_button'];

    public function pricing_lists()
    {
        return $this->hasMany(PricingList::class, 'pricing_id')->orderBy('order', 'ASC');
    }
}
