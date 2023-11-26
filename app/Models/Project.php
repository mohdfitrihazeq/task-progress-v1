<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_name'
    ];

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'project_company', 'project_id', 'company_id')->withTimestamps();
    }



    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

}
