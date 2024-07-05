<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public function leads(){
        return $this->hasMany(Lead::class, 'statusId', 'id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'companyId', 'id');
    }
}
