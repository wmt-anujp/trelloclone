<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Associate extends Model
{
    use HasFactory;
    protected $fillable = ['manager_id', 'name', 'email'];

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }
}
