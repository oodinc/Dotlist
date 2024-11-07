<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\TaskHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TaskController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();
        $previousUrl = $request->query('previous_url', route('tasks.index'));
        session(['previous_url' => $previousUrl]);
    
        return view('tasks.create', compact('user'));
    }    

    public function store(Request $request)
    {
        $data = $request->all();
        $data['labels'] = ucwords($data['labels']);

        $task = new Task($data);
        $task->user_id = Auth::id();
        $task->order = Task::max('order') + 1;
        $task->save();

        $event = 'Task created with title "' . $task->title . '".';
        $user = Auth::user();
        TaskHistory::create([
            'task_id' => $task->id,
            'event' => $event,
            'user_id' => $user->id,
        ]);
        
        $previousUrl = session('previous_url', route('tasks.index'));
        session()->forget('previous_url');

        Session::flash('success', 'Task created successfully.');

        return redirect($previousUrl);
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $previousTask = $task->replicate();
        $task->update($request->all());

        if ($previousTask->isDirty()) {
            $event = '';

            if ($previousTask->title !== $task->title) {
                $event .= 'Title changed from "' . $previousTask->title . '" to "' . $task->title . '". ';
            }

            if ($previousTask->priority !== $task->priority) {
                $event .= 'Priority changed from "' . $previousTask->priority . '" to "' . $task->priority . '". ';
            }

            $previousLabels = array_map('strtolower', explode(',', $previousTask->labels));
            $currentLabels = array_map('strtolower', explode(',', $task->labels));
            $labelChanges = array_diff($currentLabels, $previousLabels);
            if (!empty($labelChanges)) {
                $event .= 'Label changed to "' . $task->labels . '". ';
            }

            if ($previousTask->description !== $task->description) {
                $event .= 'Description changed from "' . $previousTask->description . '" to "' . $task->description . '". ';
            }

            if ($previousTask->completed !== $task->completed) {
                $previousStatus = $previousTask->completed ? 'Completed' : 'Not Completed';
                $currentStatus = $task->completed ? 'Completed' : 'Not Completed';

                if ($previousStatus !== $currentStatus) {
                    $event .= 'Status changed from "' . $previousStatus . '" to "' . $currentStatus . '". ';
                }
            }
            if ($previousTask->due_date !== $task->due_date) {
                $previousDueDate = $previousTask->due_date ? Carbon::parse($previousTask->due_date)->format('d-m-Y ~ H:i') : 'None';
                $currentDueDate = $task->due_date ? Carbon::parse($task->due_date)->format('d-m-Y ~ H:i') : 'None';
    
                if ($previousDueDate !== $currentDueDate) {
                    $event .= 'Due date changed from "' . $previousDueDate . '" to "' . $currentDueDate . '". ';
                }
            }
            if ($event === '') {
                $event = 'Other changes.';
            }

            $user = Auth::user();

            TaskHistory::create([
                'task_id' => $task->id,
                'event' => $event,
                'user_id' => $user->id,
            ]);
        }

        return redirect($request->input('previous_url', URL::previous()));
    }

    public function destroy(Task $task)
    {
        // Add event for task deletion
        $event = 'Task "' . $task->title . '" deleted.';
        $user = Auth::user();
        TaskHistory::create([
            'task_id' => $task->id,
            'event' => $event,
            'user_id' => $user->id,
        ]);
        
        $task->delete();
        
        $previousUrl = URL::previous();
        return redirect($previousUrl);
    }

    public function updateOrder(Request $request)
    {
        $task_ids = $request->task_ids;

        foreach ($task_ids as $index => $task_id) {
            Task::where('id', $task_id)->update(['order' => $index + 1]);
        }

        return response()->json(['message' => 'Task order updated successfully.']);
    }   

    public function search(Request $request)
    {
        $user = Auth::user();
        $query = $request->input('query');

        // Perform the search and retrieve the matching tasks
        $tasks = $user->tasks()
        ->where('title', 'like', '%' . $query . '%')
        ->get();

        foreach ($tasks as $task) {
            $foundIn = [];

            if ($task->isFoundInTodayList()) {
                $foundIn[] = 'Today';
            }
            if ($task->isFoundInPriority()) {
                $foundIn[] = 'Priority';
            }
            if ($task->isFoundInUpcomingList()) {
                $foundIn[] = 'Upcoming';
            }
            $labels = explode(',', $task->labels);
            foreach ($labels as $label) {
                $label = trim($label);
                if (!empty($label)) {

                    $foundIn[] = 'Labels [' . ucfirst(strtolower(trim($label))) . ']';
                }
            }

            $task->found_in = implode(', ', $foundIn);
        }
        // You can customize the search results as needed and pass them to the view
        return view('tasks.search_results', compact('tasks', 'query'));
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::now('Asia/Jakarta')->startOfDay();
        
        // Retrieve tasks specific to the logged-in user
        $tasks = $user->tasks()
            ->where(function ($query) {
                $query->where('due_date', '>=', Carbon::now('Asia/Jakarta'))
                    ->orWhereNull('due_date');
                })
            ->whereDate('due_date', $today)
            ->where('completed', false)
            ->orderBy('order')
            ->get();

        $completed = $user->tasks()
            ->whereDate('due_date', $today)
            ->where('completed', true)
            ->orderBy('order')
            ->get();

        $overdueTasks = $user->tasks()
            ->where(function ($query) {
                $query->where('due_date', '<', Carbon::now('Asia/Jakarta'));
                })
            ->whereDate('due_date', $today)
            ->where('completed', false)
            ->orderBy('due_date')
            ->get();

        return view('tasks.index', compact('tasks', 'completed', 'overdueTasks'));
    } 

    public function priority()
    {
        $user = Auth::user();
        $tasks = $user->tasks()
            ->whereNotNull('priority')
            ->orderByRaw("FIELD(priority, 'High', 'Medium', 'Low')")
            ->get();

        return view('tasks.priority', compact('tasks'));
    }

    public function upcoming()
    {
        $user = Auth::user();
        $tomorrow = Carbon::tomorrow('Asia/Jakarta');
        $upcomingTasks = $user->tasks()
            ->where('due_date', '>=', $tomorrow)
            ->orderBy('due_date')
            ->get();

        return view('tasks.upcoming', compact('upcomingTasks'));
    }

    public function labels()
    {
        $user = Auth::user();
        $labels = $user->tasks()->pluck('labels')->unique()->filter()->toArray();

        $labelTasks = [];
        foreach ($labels as $label) {
            $capitalizedLabel = ucwords(strtolower($label));
            $tasks = $user->tasks()->where('labels', $label)->get();
            $labelTasks[$capitalizedLabel] = $tasks;
        }

        return view('tasks.labels', compact('labelTasks'));
    }

    public function history()
    {
        $user = Auth::user();
        $historyTasks = TaskHistory::with('task')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return view('tasks.history', compact('historyTasks'));
    }
}