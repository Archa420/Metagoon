<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'company',
        'salary',
        'description',
        'logo',
        'category',
        'county',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
