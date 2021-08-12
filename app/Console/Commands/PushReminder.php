<?php

namespace App\Console\Commands;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PushReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push reminder to user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        $reminders = Reminder::withoutGlobalScopes()
            ->where('users.notification', 1)
            ->where('snooze_time', '<=', Carbon::now())
            ->whereDay('reminder_date', Carbon::today())
            ->whereTime('reminder_time', Carbon::now()->format('H:i'))
            ->where('reminders.notification', 1)
            ->join('users', 'users.id', '=', 'user_id')
            ->selectRaw('reminders.name as title,reminders.content as body, users.device_key as device_key')
            ->get();
        foreach ($reminders as $reminder) {
            $this->sendWebNotification($reminder);
        }
        return 0;

    }

    private function sendWebNotification($reminder)
    {


        $serverKey = config('broadcasting.connections.fcm.server_key');

        $data = [
            "registration_ids" => [$reminder->device_key],
            "notification" => [
                "title" => $reminder->title,
                "body" => $reminder->body,
                "content_available" => true,
                "priority" => "high",
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        curl_exec($ch);

        print("success");

    }
}
