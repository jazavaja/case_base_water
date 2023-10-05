<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    // Define the table associated with this model
    protected $table = 'problems';

    // Define fillable fields
    protected $fillable = [
        'title',
        'description',
    ];

    // Relationships
    public function solutions()
    {
        return $this->belongsToMany(Solution::class, 'problem_rel_solution', 'problem_id', 'solution_id');
    }
}
