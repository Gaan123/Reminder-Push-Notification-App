@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('settings.update')}}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label  for="reminder_date"> Snooze until</label>
                        <div class="row">

                            <div class="col-6">
                                <label  for="reminder_date"> Reminder Date</label>
                                <input type="date" class="form-control" id="snooze_date" name="snooze_date" value="{{$user->snooze_time?\Carbon\Carbon::parse($user->snooze_time)->format('Y-m-d'):date('Y-m-d')}}">
                            </div>
                            <div class="col-6">
                                <label  for="reminder_date"> Reminder time</label>

                                <input type="time" class="form-control" id="snooze_time" name="snooze_time" value="{{\Carbon\Carbon::parse($user->snooze_time)->format('H:i:s')}}">
                            </div>
                        </div>

                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="Notification" name="notification" value="1" {{ $user->notification==1?"checked":"" }}>
                        <label class="form-check-label" for="Notification">Recive Notification</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>


    <script>
        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "{{config('broadcasting.connections.fcm.api_key')}}",
            authDomain: "storybooks-230718.firebaseapp.com",
            databaseURL: "https://storybooks-230718.firebaseio.com",
            projectId: "storybooks-230718",
            storageBucket: "storybooks-230718.appspot.com",
            messagingSenderId: "{{config('broadcasting.connections.fcm.sender_id')}},",
            appId: "{{config('broadcasting.connections.fcm.app_id')}},"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
        function initFirebaseMessagingRegistration() {
            messaging
                .requestPermission()
                .then(function () {
                    return messaging.getToken()
                })
                .then(function(token) {
                    console.log(token);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ route("store.token") }}',
                        type: 'POST',
                        data: {
                            token: token
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            // alert('Token saved successfully.');
                        },
                        error: function (err) {
                            console.log('User Chat Token Error'+ err);
                        },
                    });
                }).catch(function (err) {
                console.log('User Chat Token Error'+ err);
            });
        }
        initFirebaseMessagingRegistration();
        messaging.onMessage(function(payload) {
            const noteTitle = payload.notification.title;
            const noteOptions = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            new Notification(noteTitle, noteOptions);
        });
    </script>
@endsection
