@extends('layouts.app')

@section('title', $query . ' - Dotlist')

@section('content')
<div class="container">
    <h4 class="text-center pt-3 me-4">Search Results for "{{ $query }}"</h4>
    <div class="card shadow-sm my-2">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle text-center">
                    <thead>
                        <tr>
                            <th scope="col">Task</th>
                            <th scope="col">Status</th>
                            <th scope="col">Found In</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                        <tr data-task-id="{{ $task->id }}">
                            <td>{{ $task->title }}</td>
                            <td>
                                @if ($task->completed)
                                    <span class="badge bg-success d-none d-md-inline" data-bs-toggle="tooltip" data-bs-placement="top" title="Completed">Completed</span>
                                    <i class="bi bi-check-square-fill d-md-none text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Completed"></i>
                                @else
                                    <span class="badge bg-danger d-none d-md-inline" data-bs-toggle="tooltip" data-bs-placement="top" title="Not Completed">Not Completed</span>
                                    <i class="bi bi-x-square-fill d-md-none text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Not Completed"></i>
                                @endif
                            </td>
                            <td>
                                @foreach(explode(', ', $task->found_in) as $foundIn)
                                    @if (strpos($foundIn, 'Labels') !== false)
                                        <?php $label = trim(str_replace(['Labels [', ']'], '', $foundIn)); ?>
                                        <a  class="text-decoration-none" href="{{ route('tasks.labels') }}?label={{ $label }}">{{ $foundIn }}</a>
                                    @elseif ($foundIn === 'Today')
                                        <a  class="text-decoration-none" href="{{ route('tasks.index') }}">{{ $foundIn }}</a>
                                    @elseif ($foundIn === 'Priority')
                                        <a  class="text-decoration-none" href="{{ route('tasks.priority') }}">{{ $foundIn }}</a>
                                    @elseif ($foundIn === 'Upcoming')
                                        <a  class="text-decoration-none" href="{{ route('tasks.upcoming') }}">{{ $foundIn }}</a>
                                    @else
                                        {{ $foundIn }}
                                    @endif
                                    @if (!$loop->last)
                                        , 
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="3">No tasks found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
