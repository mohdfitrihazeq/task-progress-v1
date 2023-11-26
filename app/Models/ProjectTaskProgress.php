<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTaskProgress extends Model
{
    use HasFactory;
    protected $fillable = [
        'task_sequence_no_wbs',
        'project_id',
        'task_name',
        'task_actual_start_date',
        'task_actual_end_date',
        'task_progress_percentage',
        'last_update_bywhom',
    ];
    protected $primaryKey = 'projecttaskprogress_id';
}
