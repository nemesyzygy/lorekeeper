<?php

namespace App\Models\WorldExpansion;

use App\Models\News;
use Illuminate\Database\Eloquent\Model;

class EventNews extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'news_id', 'event_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_newses';

    public $timestamps = false;

    /**********************************************************************************************

        RELATIONS

    **********************************************************************************************/

    /**
     * Get the news attached to this.
     */
    public function news()
    {
        return $this->belongsTo('App\Models\News', 'news_id');
    }

    /**
     * Get the event attached to this.
     */
    public function event()
    {
        return $this->belongsTo('App\Models\WorldExpansion\Event', 'event_id');
    }
}
