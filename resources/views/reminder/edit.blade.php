@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <p><strong>Opps Something went wrong</strong></p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-body">
                        <form action="{{ route('reminders.update',$reminder->id)}}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="name">Reminder Subject</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter reminder name" value="{{$reminder->name}}" required>
                            </div>
                            <div class="form-group">
                                <label for="content">Short Description</label>
                                <textarea class="form-control" id="content" name="content">{{$reminder->content}}</textarea>
                            </div>
                            <div class="form-group">

                                <div class="row">

                                    <div class="col-6">
                                        <label  for="reminder_date"> Reminder Date</label>
                                        <input type="date" class="form-control" id="reminder_date" name="reminder_date" value="{{$reminder->reminder_date}}">
                                    </div>
                                    <div class="col-6">
                                        <label  for="reminder_date"> Reminder time</label>
                                        <input type="time" class="form-control" id="reminder_time" name="reminder_time" value="{{$reminder->reminder_time}}" required>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="Notification" name="notification" value="1" {{ $reminder->notification==1?"checked":"" }}>
                                <label class="form-check-label" for="Notification">Get Notification</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
