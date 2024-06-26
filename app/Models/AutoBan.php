<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $bot_id
 * @property integer $xatid
 * @property string $regname
 * @property integer $hours
 * @property string $method
 * @property string $created_at
 * @property string $updated_at
 * @property Bot $bot
 */
class AutoBan extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['bot_id', 'xatid', 'regname', 'hours', 'method', 'created_at', 'updated_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'autobans';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function autobanBot()
    {
        return $this->hasOne('App\Models\Bot', 'id', 'bot_id');
    }
}
