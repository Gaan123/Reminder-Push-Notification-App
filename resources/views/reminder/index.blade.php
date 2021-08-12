@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <a href="{{ route('reminders.create')}}" class="btn btn-success m-4">Add reminder</a>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Time</th>
                                <th scope="col">Notification</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($reminders as $key => $reminder)
                            <tr>
                                <th scope="row">{{$key+1}}</th>
                                <td>{{$reminder->name}}</td>
                                <td>{{$reminder->reminder_date.'  '.date('H:i a',strtotime($reminder->reminder_time))}}</td>
                                <td>{{$reminder->notification_status}}</td>
                                <td>
                                    <form method="POST" action="{{route('reminders.destroy',$reminder->id)}}">
                                       @csrf
                                        {{ method_field('DELETE') }}

                                        <div class="form-group">
                                            <input type="submit" class="btn btn-danger delete-user" value="Delete">
                                        </div>
                                    </form>
                                    <a href="{{route('reminders.edit',$reminder->id)}}" class="btn btn-success">Edit</a>
                                </td>
                            </tr>
                           @endforeach
                            </tbody>

                        </table>
                        {{ $reminders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
