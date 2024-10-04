@extends('layouts.app')

@section('title', 'Today - Dotlist')

@section('content')
<div class="container">
    <div class="row">
        <div class="col mt-3">
            <h4 class="text-center">@lang('index.today_list')<span class="text-muted"> {{ now()->setTimezone('Asia/Jakarta')->isoFormat('dddd, DD MMMM YYYY') }}</span></h4>
            <div class="card shadow-sm my-2">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-end">
                        <!-- Information Icon for Tooltip -->
                        <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="@lang('index.This section displays tasks that are due today')"></i>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle text-center">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('index.task')</th>
                                    <th scope="col">@lang('index.status')</th>
                                    <th scope="col">@lang('index.due_date')</th>
                                    <th scope="col">@lang('index.action')</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="sortable">
                                @forelse ($tasks as $task)
                                <tr data-task-id="{{ $task->id }}">
                                    <td>{{ $task->title }}</td>
                                    <td>
                                        @if ($task->completed)
                                            <span class="badge bg-success d-none d-md-inline" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.Completed')">@lang('index.Completed')"</span>
                                            <i class="bi bi-check-square-fill d-md-none text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.Completed')"></i>
                                        @else
                                            <span class="badge bg-danger d-none d-md-inline" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.Not Completed')">@lang('index.Not Completed')</span>
                                            <i class="bi bi-x-square-fill d-md-none text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.Not Completed')"></i>
                                        @endif
                                    </td>
                                    <td>{{ Carbon\Carbon::parse($task->due_date)->format('H:i') }}</td>
                                    <td>
                                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.View')">
                                            <span class="d-none d-md-inline"><i class="bi bi-eye"></i> @lang('index.View')</span> <!-- Icon for larger screens -->
                                            <i class="bi bi-eye d-md-none"></i> <!-- Icon for smaller screens -->
                                        </a>
                                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.Edit')">
                                            <span class="d-none d-md-inline"><i class="bi bi-pencil"></i> @lang('index.Edit')</span> <!-- Icon for larger screens -->
                                            <i class="bi bi-pencil d-md-none"></i> <!-- Icon for smaller screens -->
                                        </a>
                                        <form id="delete-form-{{ $task->id }}" action="{{ route('tasks.destroy', $task) }}" method="POST" data-title="{{ $task->title }}" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-placement="top" title="@lang('index.Delete')" data-bs-target="#confirmDeleteModal-{{ $task->id }}">
                                                <span class="d-none d-md-inline"><i class="bi bi-trash"></i> @lang('index.Delete')</span> <!-- Icon for larger screens -->
                                                <i class="bi bi-trash-fill d-md-none"></i> <!-- Icon for smaller screens -->
                                            </button>
                                            
                                            <!-- Confirm Delete Modal -->
                                            <div class="modal fade" id="confirmDeleteModal-{{ $task->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel-{{ $task->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="confirmDeleteModalLabel-{{ $task->id }}">Confirm Delete</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @lang('index.Are you sure you want to delete task') "{{ $task->title }}"?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td><i class="bi bi-grip-vertical drag-handle"></i></td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="5">@lang('index.today_no_tasks')</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 mt-3">
            <h4 class="text-center mb-0">@lang('index.today_completed')</h4>
            <div class="card shadow-sm my-2">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-end">
                        <!-- Information Icon for Tooltip -->
                        <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="@lang('index.This section displays tasks that were completed today')"></i>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle text-center">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('index.task')</th>
                                    <th scope="col">@lang('index.status')</th>
                                    <th scope="col">@lang('index.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($completed as $task)
                                    <tr data-task-id="{{ $task->id }}">
                                        <td>{{ $task->title }}</td>
                                        <td>
                                            @if ($task->completed)
                                                <span class="badge bg-success d-none d-md-inline" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.Completed')">@lang('index.Completed')</span>
                                                <i class="bi bi-check-square-fill d-md-none text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.Completed')"></i>
                                            @else
                                                <span class="badge bg-danger d-none d-md-inline" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.Not Completed')">@lang('index.Not Completed')</span>
                                                <i class="bi bi-x-square-fill d-md-none text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.Not Completed')"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.View')">
                                                <span class="d-none d-md-inline"><i class="bi bi-eye"></i> @lang('index.View')</span> <!-- Icon for larger screens -->
                                                <i class="bi bi-eye d-md-none"></i> <!-- Icon for smaller screens -->
                                            </a>
                                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.Edit')">
                                                <span class="d-none d-md-inline"><i class="bi bi-pencil"></i> @lang('index.Edit')</span> <!-- Icon for larger screens -->
                                                <i class="bi bi-pencil d-md-none"></i> <!-- Icon for smaller screens -->
                                            </a>
                                            <form id="delete-form-{{ $task->id }}" action="{{ route('tasks.destroy', $task) }}" method="POST" data-title="{{ $task->title }}" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-placement="top" title="@lang('index.Delete')" data-bs-target="#confirmDeleteModal-{{ $task->id }}">
                                                    <span class="d-none d-md-inline"><i class="bi bi-trash"></i> @lang('index.Delete')</span> <!-- Icon for larger screens -->
                                                    <i class="bi bi-trash-fill d-md-none"></i> <!-- Icon for smaller screens -->
                                                </button>

                                                <!-- Confirm Delete Modal -->
                                                <div class="modal fade" id="confirmDeleteModal-{{ $task->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel-{{ $task->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="confirmDeleteModalLabel-{{ $task->id }}">@lang('index.Confirm Delete')</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @lang('index.Are you sure you want to delete task') "{{ $task->title }}"?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('index.Cancel')</button>
                                                                <button type="submit" class="btn btn-danger">@lang('index.Delete')</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="3">@lang('index.today_no_completed')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <h4 class="text-center mb-0">@lang('index.today_overdue')</h4>
            <div class="card shadow-sm my-2">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-end">
                        <!-- Information Icon for Tooltip -->
                        <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="@lang('index.This section displays tasks that were not completed and have passed their due date')"></i>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle text-center">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('index.task')</th>
                                    <th scope="col">@lang('index.due_date')</th>
                                    <th scope="col">@lang('index.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($overdueTasks as $task)
                                    <tr data-task-id="{{ $task->id }}">
                                        <td>{{ $task->title }}</td>
                                        <td>{{ Carbon\Carbon::parse($task->due_date)->format('H:i') }}</td>
                                        <td>
                                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.View')">
                                                <span class="d-none d-md-inline"><i class="bi bi-eye"></i> @lang('index.View')</span> <!-- Icon for larger screens -->
                                                <i class="bi bi-eye d-md-none"></i> <!-- Icon for smaller screens -->
                                            </a>
                                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('index.Edit')">
                                                <span class="d-none d-md-inline"><i class="bi bi-pencil"></i> @lang('index.Edit')</span> <!-- Icon for larger screens -->
                                                <i class="bi bi-pencil d-md-none"></i> <!-- Icon for smaller screens -->
                                            </a>
                                            <form id="delete-form-{{ $task->id }}" action="{{ route('tasks.destroy', $task) }}" method="POST" data-title="{{ $task->title }}" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-placement="top" title="@lang('index.Delete')" data-bs-target="#confirmDeleteModal-{{ $task->id }}">
                                                    <span class="d-none d-md-inline"><i class="bi bi-trash"></i> @lang('index.Delete')</span> <!-- Icon for larger screens -->
                                                    <i class="bi bi-trash-fill d-md-none"></i> <!-- Icon for smaller screens -->
                                                </button>

                                                <!-- Confirm Delete Modal -->
                                                <div class="modal fade" id="confirmDeleteModal-{{ $task->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel-{{ $task->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="confirmDeleteModalLabel-{{ $task->id }}">Confirm Delete</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @lang('index.Are you sure you want to delete task') "{{ $task->title }}"?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="3">@lang('index.today_no_overdue')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
