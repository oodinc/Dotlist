@extends('layouts.app')

@section('title', 'Labels - Dotlist')

@section('content')
<div class="container">
    <div class="row">
        <div class="col col mt-3">
            <h4 class="text-center mb-0">@lang('labels.Labels')</h4>
            <div class="d-flex align-items-center justify-content-end mb-2">
                <!-- Information Icon for Tooltip -->
                <i class="bi bi-info-circle-fill me-2" data-bs-toggle="tooltip" data-bs-placement="left" title="@lang('labels.This page displays tasks grouped by their labels. Labels are displayed in capital letters')"></i>
            </div>
            @if (count($labelTasks) > 0)
                <div class="row">
                    @foreach ($labelTasks as $label => $tasks)
                        <div class="col-12 col-md-6">
                            <div class="card mb-3 shadow-sm my-2">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">{{ $label }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped align-middle">
                                            <tbody>
                                                @foreach ($tasks as $task)
                                                    <tr>
                                                        <td>{{ $task->title }}</td>
                                                        <td class="d-flex justify-content-end">
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
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card shadow-sm my-2">
                    <div class="card-body">
                        <p class="card-text text-center">@lang('labels.No labels found')</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
