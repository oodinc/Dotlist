@extends('layouts.app')

@section('title', 'Edit "' . $task->title . '" - Dotlist')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col mt-3">
            <div class="card shadow-sm">
                <div class="card-header bg-primary-subtle">@lang('edit.Edit Task')</div>
                <div class="card-body">
                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="previous_url" value="{{ URL::previous() }}">
                        <div class="form-floating mb-3">
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ $task->title }}" placeholder="@lang('edit.Task Title')" required maxlength="14">
                            <label for="title">@lang('edit.Task Name')</label>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="description" id="description" class="form-control" placeholder="@lang('edit.Description')">{{ $task->description }}</textarea>
                            <label for="description">@lang('edit.Description')</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select name="completed" id="completed" class="form-select">
                                <option value="0" {{ $task->completed == 0 ? 'selected' : '' }}>@lang('edit.Not Completed')</option>
                                <option value="1" {{ $task->completed == 1 ? 'selected' : '' }}>@lang('edit.Completed')</option>
                            </select>
                            <label for="completed">@lang('edit.Status')</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select name="priority" id="priority" class="form-select">
                                <option value="Low" {{ $task->priority == 'Low' ? 'selected' : '' }}>@lang('edit.Low')</option>
                                <option value="Medium" {{ $task->priority == 'Medium' ? 'selected' : '' }}>@lang('edit.Medium')</option>
                                <option value="High" {{ $task->priority == 'High' ? 'selected' : '' }}>@lang('edit.High')</option>
                            </select>
                            <label for="priority">@lang('edit.Priority')</label>
                        </div>
                        <div class="form-floating mb-3">
                            <?php
                            $today = now()->format('Y-m-d\TH:i');
                            ?>
                            <input type="datetime-local" name="due_date" id="due_date" class="form-control" required value="{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d\TH:i') : '' }}" min="<?= $today ?>">
                            <label for="due_date">@lang('edit.Due Date')</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="labels" id="labels" class="form-control" value="{{ $task->labels }}" placeholder="@lang('edit.Labels')" maxlength="14">
                            <label for="labels">@lang('edit.Labels')</label>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-secondary me-2">
                                <i class="bi bi-house"></i> @lang('create.Home')
                            </a>
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="bi bi-save"></i> @lang('create.Save')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
