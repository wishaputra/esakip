<?php

namespace App\Models\Section;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    protected $table = 'trees'; // Ensure this matches your actual table name

    protected $fillable = [
        'name', // Assume each tree node has a name
        'parent_id', // This will be used to establish the parent-child relationship
        'order', // If you're using an 'order' column to determine the order of nodes
        // Add other columns as necessary
    ];

    /**
     * Get the parent node.
     */
    public function parent()
    {
        return $this->belongsTo(Tree::class, 'parent_id');
    }

    /**
     * Get the child nodes.
     */
    public function children()
    {
        return $this->hasMany(Tree::class, 'parent_id')->orderBy('order');
    }

    /**
     * Scope a query to only include root nodes.
     */
    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    // Add other necessary methods or relationships here
}
