@extends('layouts.app')

@section('title', 'Buat Tugas - Dotlist')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col mt-3">
            <div class="card shadow-sm">
                <div class="card-header bg-primary-subtle">@lang('create.Add Task')</div>
                <div class="card-body">
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" name="title" id="title" class="form-control" placeholder="@lang('create.Task Name')" required maxlength="14">
                            <label for="title">@lang('create.Task Name')</label>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea name="description" id="description" class="form-control" placeholder="@lang('create.Description')"></textarea>
                            <label for="description">@lang('create.Description')</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select name="priority" id="priority" class="form-select">
                                <option value="Low">@lang('create.Low')</option>
                                <option value="Medium">@lang('create.Medium')</option>
                                <option value="High">@lang('create.High')</option>
                            </select>
                            <label for="priority">@lang('create.Priority')</label>
                        </div>

                        <div class="form-floating mb-3">
                            <?php
                            $today = now()->format('Y-m-d\TH:i');
                            ?>
                            <input type="datetime-local" name="due_date" id="due_date" class="form-control" placeholder="@lang('create.Due Date')" required min="<?= $today ?>">
                            <label for="due_date">@lang('create.Due Date')</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input type="text" name="labels" id="labels" class="form-control" placeholder="@lang('create.Labels')" maxlength="14">
                            <label for="labels">@lang('create.Labels')</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <select name="completed" id="completed" class="form-select">
                                <option value="0">@lang('create.Not Completed')</option>
                                <option value="1">@lang('create.Completed')</option>
                            </select>
                            <label for="completed">@lang('create.Status')</label>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> @lang('create.Save')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection