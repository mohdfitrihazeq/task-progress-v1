<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $primaryKey = 'company_id';
    protected $fillable = [
        'company_name'
    ];
    protected $primaryKey = 'company_id';


    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_company', 'company_id', 'project_id')->withTimestamps();
    }

}
