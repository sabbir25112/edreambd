<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function getStartTimeIsoAttribute()
    {
        return $this->start_time ? Carbon::create($this->start_time)->toDateTimeLocalString() : '';
    }

    public function getEndTimeAttribute()
    {
        return Carbon::create($this->start_time)->addMinutes($this->duration + 1);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function isEditable()
    {
        return Carbon::create($this->start_time)->isFuture();
    }

    public function isRunning()
    {
        $start_time = Carbon::create($this->start_time);
        $end_time = Carbon::create($this->start_time)->addMinutes($this->duration + 1);
        return $start_time->isPast() && $end_time->isFuture();
    }

    public function isEnded()
    {
        $start_time = Carbon::create($this->start_time);
        $end_time = Carbon::create($this->start_time)->addMinutes($this->duration + 1);
        return $start_time->isPast() && $end_time->isPast();
    }
}
