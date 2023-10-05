<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    // Define the table associated with this model
    protected $table = 'solutions';

    // Define fillable fields
    protected $fillable = [
        'description',
    ];

    // Relationships
    public function problems()
    {
        return $this->belongsToMany(Problem::class, 'problem_rel_solution', 'solution_id', 'problem_id');
    }
}
