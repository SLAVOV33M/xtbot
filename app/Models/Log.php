<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $chatid
 * @property citext $chatname
 * @property integer $typemessage
 * @property text $message
 * @property string $created_at
 * @property string $updated_at
 */
class Log extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logs';

    /**
     * @var array
     */
    protected $fillable = ['chatid', 'chatname', 'typemessage', 'message', 'created_at', 'updated_at'];
}
