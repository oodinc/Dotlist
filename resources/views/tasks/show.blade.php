@extends('layouts.app')

@section('title', $task->title . ' - Dotlist')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col mt-3">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5>{{ $task->title }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> {{ $task->description }}</p>
                    <p><strong>Due Date:</strong> {{ Carbon\Carbon::parse($task->due_date)->format('d-m-Y ~ H:i') }}</p>
                    <p><strong>Priority:</strong> {{ $task->priority }}</p>
                    <p><strong>Labels:</strong> {{ $task->labels }}</p>
                    <p><strong>Status:</strong> 
                        @if ($task->completed)
                            <span class="badge bg-success">Completed</span>
                        @else
                            <span class="badge bg-danger">Not completed</span>
                        @endif
                    </p>
                    <p><strong>Created at:</strong> {{ $task->created_at->timezone('Asia/Jakarta')->format('l, d M Y H:i') }}</p>
                    <p><strong>Updated at:</strong> {{ $task->updated_at->timezone('Asia/Jakarta')->format('l, d M Y H:i') }}</p>
                </div>                
                <div class="card-footer">
                    <div class="btn-group" role="group">
                        <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-secondary">
                            <i class="bi bi-house"></i> @lang('create.Home')
                        </a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Edit</a>
                    </div>
                    <div class="btn-group" role="group">
                        <form id="delete-form-<?php echo $task['id']; ?>" action="crud/delete.php" method="POST" style="display: inline-block;">
                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete">
                                <span><i class="bi bi-trash"></i> Delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
