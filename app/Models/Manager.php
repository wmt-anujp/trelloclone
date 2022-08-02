<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'status'];

    public function associates()
    {
        return $this->hasMany(Associate::class);
    }
}
