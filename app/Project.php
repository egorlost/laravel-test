<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    const STATUS_PLANNED = 'planned';
    const STATUS_RUNNING = 'running';
    const STATUS_ON_HOLD = 'on hold';
    const STATUS_FINISHED = 'finished';
    const STATUS_CANCEL = 'cancel';

    public static function getStatuses()
    {
        return [
            self::STATUS_PLANNED,
            self::STATUS_RUNNING,
            self::STATUS_ON_HOLD,
            self::STATUS_FINISHED,
            self::STATUS_CANCEL,
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'statuses'
    ];
}
