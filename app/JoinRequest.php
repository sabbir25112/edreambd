<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class JoinRequest extends Model
{
    protected $guarded = ['id'];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
