<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id',
    'course_id',
    'title',
    'description',
    'priority',
    'deadline',
    'status_task',
    'completed_at'
])]
class Task extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
