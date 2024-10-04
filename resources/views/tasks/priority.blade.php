@extends('layouts.app')

@section('title', 'Priority - Dotlist')

@section('content')
<div class="container">
    <div class="row">
        <div class="col mt-3">
            <h4 class="text-center mb-0">@lang('priority.Priority Tasks')</h4>
            <div class="card shadow-sm my-2">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-end">
                        <!-- Information Icon for Tooltip -->
                        <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="@lang('priority.This page displays tasks sorted by priority. All tasks are displayed on this page')"></i>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle text-center">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('priority.task')</th>
                                    <th scope="col">@lang('priority.priority')</th>
                                    <th scope="col">@lang('priority.due_date')</th>
                                    <th scope="col">@lang('priority.status')</th>
                                    <th scope="col">@lang('priority.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tasks as $task)
                                    <tr>
                                        <td>{{ $task->title }}</td>
                                        <td>
                                            @if ($task->priority == 'High')
                                                <span class="badge bg-danger d-none d-md-inline" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('priority.High')">@lang('priority.High')</span>
                                                <i class="bi bi-arrow-up-square-fill d-md-none text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('priority.High')"></i>
                                            @elseif ($task->priority == 'Medium')
                                                <span class="badge bg-warning d-none d-md-inline" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('priority.Medium')">@lang('priority.Medium')</span>
                                                <i class="bi bi-arrow-right-square-fill d-md-none text-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('priority.Medium')"></i>
                                            @else
                                                <span class="badge bg-secondary d-none d-md-inline" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('priority.Low')">@lang('priority.Low')</span>
                                                <i class="bi bi-arrow-down-square-fill d-md-none text-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('priority.Low')"></i>
                                            @endif
                                        </td>
                                        <td>{{ Carbon\Carbon::parse($task->due_date)->format('d-m-Y ~ H:i') }}</td>
                                        <td>
                                            @if ($task->completed)
                                                <span class="badge bg-success d-none d-md-inline" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('priority.Completed')">@lang('priority.Completed')</span>
                                                <i class="bi bi-check-square-fill d-md-none text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('priority.Completed')"></i>
                                            @else
                                                <span class="badge bg-danger d-none d-md-inline" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('priority.Not Completed')">@lang('priority.Not Completed')</span>
                                                <i class="bi bi-x-square-fill d-md-none text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('priority.Not Completed')"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('priority.View')">
                                                <span class="d-none d-md-inline"><i class="bi bi-eye"></i> @lang('priority.View')</span> <!-- Icon for larger screens -->
                                                <i class="bi bi-eye d-md-none"></i> <!-- Icon for smaller screens -->
                                            </a>
                                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('priority.Edit')">
                                                <span class="d-none d-md-inline"><i class="bi bi-pencil"></i> @lang('priority.Edit')</span> <!-- Icon for larger screens -->
                                                <i class="bi bi-pencil d-md-none"></i> <!-- Icon for smaller screens -->
                                            </a>
                                            <form id="delete-form-{{ $task->id }}" action="{{ route('tasks.destroy', $task) }}" method="POST" data-title="{{ $task->title }}" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-placement="top" title="@lang('priority.Delete')" data-bs-target="#confirmDeleteModal-{{ $task->id }}">
                                                    <span class="d-none d-md-inline"><i class="bi bi-trash"></i> @lang('priority.Delete')</span> <!-- Icon for larger screens -->
                                                    <i class="bi bi-trash-fill d-md-none"></i> <!-- Icon for smaller screens -->
                                                </button>
                                                
                                                <!-- Confirm Delete Modal -->
                                                <div class="modal fade" id="confirmDeleteModal-{{ $task->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel-{{ $task->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="confirmDeleteModalLabel-{{ $task->id }}">@lang('priority.Confirm Delete')</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @lang('priority.Are you sure you want to delete task') "{{ $task->title }}"?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('priority.Cancel')</button>
                                                                <button type="submit" class="btn btn-danger">@lang('priority.Delete')</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="5">@lang('priority.No priority tasks')</td>
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
