<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badword extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['badword', 'method'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'badwords';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function badwordBot()
    {
        return $this->hasOne('App\Models\Bot', 'id', 'bot_id');
    }
}
