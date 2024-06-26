<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alias extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['command', 'alias'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'aliases';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function aliasBot()
    {
        return $this->hasOne('App\Models\Bot', 'id', 'bot_id');
    }
}
