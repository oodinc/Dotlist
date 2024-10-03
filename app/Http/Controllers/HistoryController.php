<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskHistory;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function deleteHistory($id)
    {
        $history = TaskHistory::findOrFail($id);
        $history->delete();

        return redirect()->route('tasks.history')->with('success', 'History entry deleted successfully.');
    }
    
    public function multiDeleteHistory(Request $request)
    {
        $selectedIds = $request->input('selected', []);

        if (empty($selectedIds)) {
            return redirect()->route('tasks.history')->with('error', 'No history tasks selected for deletion.');
        }

        // Get the user ID for authorization check
        $user = Auth::user();

        // Find and delete selected history tasks
        $historyTasks = TaskHistory::whereIn('id', $selectedIds)->get();
        foreach ($historyTasks as $historyTask) {
            // Check if the user owns the history task
            if ($historyTask->user_id === $user->id) {
                $historyTask->delete();
            }
        }

        return redirect()->route('tasks.history')->with('success', 'Selected history tasks deleted successfully.');
    }
}
