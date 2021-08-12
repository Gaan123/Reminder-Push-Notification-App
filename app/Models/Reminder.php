<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;
    protected $fillable=[
        'name','content','reminder_date','reminder_time','user_id','notification'
    ];
    protected static function booted()
    {

        static::addGlobalScope('user_reminder', function (Builder $builder) {

            $builder->where('user_id', '=',auth()->id() );
        });
    }
    public function setReminderDateAttribute($value)
    {
        $this->attributes['reminder_date']=$value??date('Y-m-d');
    }
    public function getNotificationStatusAttribute()
    {
        return $this->notification==1?'ON':'OFF';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
