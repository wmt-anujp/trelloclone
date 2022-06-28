<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'task_id', 'comment'];

    public function userComment()
    {
        return $this->belongsTo(User::class);
    }

    public function taskComment()
    {
        return $this->belongsTo(Task::class);
    }
}
