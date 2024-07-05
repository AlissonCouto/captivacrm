<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Niche extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'color',
    ];

    public function company(){
        return $this->belongsTo(Company::class, 'companyId', 'id');
    }

    public function leads(){
        return $this->hasMany(Lead::class, 'nicheId', 'id');
    }
}
