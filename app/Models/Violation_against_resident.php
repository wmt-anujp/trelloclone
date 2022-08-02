<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation_against_resident extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'reports', 'report_description'];

    public function residents()
    {
        return $this->belongsTo(Resident::class);
    }
}
