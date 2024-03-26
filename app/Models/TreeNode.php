<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreeNode extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'parent_id']; // List of fillable attributes

    // Define any relationships or additional methods here
}
