<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['assigned_by', 'assigned_to', 'title', 'description', 'due_date'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
