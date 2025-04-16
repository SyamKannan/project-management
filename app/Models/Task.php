<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded =[];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function tasks() {
        return $this->hasMany(Task::class);
    }
    public function remark() {
        return $this->hasMany(TaskRemark::class);
    }
    
}
