<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'completed',
        'priority',
        'due_date',
        'labels',
    ];

    // Method to check if the task is found in Today-list
    public function isFoundInTodayList()
    {
        $today = Carbon::now('Asia/Jakarta')->startOfDay();
        $dueDate = Carbon::parse($this->due_date)->startOfDay(); // Get the start of the task's due date
    
        return $this->due_date !== null && $dueDate->isSameDay($today);
    }

    // Method to check if the task is found based on Priority
    public function isFoundInPriority()
    {
        return $this->priority !== null;
    }

    // Method to check if the task is found in Upcoming-list
    public function isFoundInUpcomingList()
    {
        $tomorrow = Carbon::tomorrow('Asia/Jakarta')->startOfDay(); // Get the start of tomorrow
        $dueDate = Carbon::parse($this->due_date)->startOfDay(); // Get the start of the task's due date

        return $this->due_date !== null && $dueDate->isAfter($tomorrow);
    }

    // Check if the task's labels contain the given label
    public function isFoundInLabel($label)
    {
        return stripos($this->labels, $label) !== false;
    }

}
