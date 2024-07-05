<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function setting(){
        return $this->hasOne(Setting::class, 'companyId', 'id');
    }

    public function niches(){
        return $this->hasMany(Niche::class, 'companyId', 'id');
    }

    public function leads(){
        return $this->hasMany(Lead::class, 'companyId', 'id');
    }

    public function statuses(){
        return $this->hasMany(Status::class, 'companyId', 'id');
    }

    public function messages(){
        return $this->hasMany(Message::class, 'companyId', 'id');
    }
}
