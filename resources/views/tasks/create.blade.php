@extends('layouts.app')

@section('title', 'Create Task - Dotlist')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col mt-3">
            <div class="card shadow-sm">
                <div class="card-header bg-primary-subtle">Add Task</div>
                <div class="card-body">
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" name="title" id="title" class="form-control" placeholder="Task Name" required maxlength="14">
                            <label for="title">Task Name</label>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea name="description" id="description" class="form-control" placeholder="Description"></textarea>
                            <label for="description">Description</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select name="priority" id="priority" class="form-select">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                            <label for="priority">Priority</label>
                        </div>

                        <div class="form-floating mb-3">
                            <?php
                            $today = now()->format('Y-m-d\TH:i');
                            ?>
                            <input type="datetime-local" name="due_date" id="due_date" class="form-control" placeholder="Due Date" required min="<?= $today ?>">
                            <label for="due_date">Due Date</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input type="text" name="labels" id="labels" class="form-control" placeholder="Labels" maxlength="14">
                            <label for="labels">Labels</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <select name="completed" id="completed" class="form-select">
                                <option value="0">Not Completed</option>
                                <option value="1">Completed</option>
                            </select>
                            <label for="completed">Status</label>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection