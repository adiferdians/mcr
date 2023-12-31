<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';

    protected $guarded = [];
    public function detil_certifications()
    {
        return $this->hasMany('App\Models\detilCertification');
    }
}
