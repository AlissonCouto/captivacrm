<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'phone',
        'email',
        'website',
        'lastContact',
        'callScheduled',
        'status',
        'highlight',
        'order',
    ];

    public function messages(){
        return $this->hasMany(Message::class, 'leadId', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'cityId', 'id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'companyId', 'id');
    }

    public function niche(){
        return $this->belongsTo(Niche::class, 'nicheId', 'id');
    }

    public function status(){
        return $this->belongsTo(Status::class, 'statusId', 'id');
    }

    public function getCityAttribute()
    {
        $city = $this->city()->first();

        $name = $city ? $city->nome : 'Não informado';

        return $name;
    }

    public function getDateBrAttribute()
    {
        return Date('d/m/Y', strtotime($this->created_at));
    }

}
