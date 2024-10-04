@extends('layouts.app')

@section('title', 'History - Dotlist')

@section('content')
<form id="multi-delete-form" action="{{ route('history.multi-delete') }}" method="POST">
    @csrf
    @method('DELETE')
    <div class="container">
        <div class="row">
            <div class="col mt-3">
                <h4 class="text-center mb-0">@lang('history.Task History')</h4>
                <div class="card shadow-sm my-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-end">
                            <!-- Information Icon for Tooltip -->
                            <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="This page displays the history of tasks, including their events and actions performed."></i>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('history.event')</th>
                                        <th scope="col">@lang('history.task')</th>
                                        <th scope="col">@lang('history.date')</th>
                                        <th scope="col">@lang('history.time')</th>
                                        <th scope="col">@lang('history.action')</th>
                                        @if(count($historyTasks) > 0)
                                            <th scope="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                                </div>
                                            </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($historyTasks as $history)
                                        <tr>
                                            <td>{{ $history->event }}</td>
                                            <td>
                                                @if ($history->task)
                                                    {{ $history->task->title }}
                                                @else
                                                    Task Deleted
                                                @endif
                                            </td>
                                            <td>{{ $history->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y') }}</td>
                                            <td>{{ $history->created_at->setTimezone('Asia/Jakarta')->toTimeString() }}</td>
                                            <td>
                                                <form action="{{ route('history.delete', $history->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $history->id }}">
                                                        <span class="d-none d-md-inline"><i class="bi bi-trash"></i> Delete</span> <!-- Icon for larger screens -->
                                                        <i class="bi bi-trash-fill d-md-none"></i> <!-- Icon for smaller screens -->
                                                    </button>
                                                    <!-- Confirm Delete Modal -->
                                                    <div class="modal fade" id="confirmDeleteModal-{{ $history->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel-{{ $history->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="confirmDeleteModalLabel-{{ $history->id }}">Confirm Delete</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete history "{{ $history->event }}"?
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
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="selected[]" value="{{ $history->id }}">
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="6">No history tasks.</td> <!-- Update colspan to 6 -->
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @if(count($historyTasks) > 0)
                    <div class="text-end mt-2 mb-5">
                        <button type="button" class="btn btn-danger" id="deleteSelectedBtn" data-bs-toggle="modal" data-bs-target="#confirmMultiDeleteModal" disabled>Delete Selected</button>
                    </div>
                @endif
                <!-- Confirm Multi-Delete Modal -->
                <div class="modal fade" id="confirmMultiDeleteModal" tabindex="-1" aria-labelledby="confirmMultiDeleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmMultiDeleteModalLabel">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete the selected history tasks?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger" form="multi-delete-form">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection