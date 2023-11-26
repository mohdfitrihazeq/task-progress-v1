<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCompany extends Model
{
    use HasFactory;

    protected $table = 'project_company';

    protected $fillable = [
        'project_id',
        'company_id',
    ];
}
