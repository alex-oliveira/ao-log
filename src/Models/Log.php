<?php

namespace AoLogs\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

    //------------------------------------------------------------------------------------------------------------------
    // DYNAMIC
    //------------------------------------------------------------------------------------------------------------------

    public $dynamicClass;

    public $dynamicTable;

    public $dynamicForeign;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dynamicWith()
    {
        return $this->belongsToMany($this->dynamicClass, $this->dynamicTable, 'log_id', $this->dynamicForeign);
    }

    //------------------------------------------------------------------------------------------------------------------
    // ATTRIBUTES
    //------------------------------------------------------------------------------------------------------------------

    protected $table = 'ao_logs_logs';

    protected $fillable = ['user_id', 'operation', 'title', 'description'];

    //------------------------------------------------------------------------------------------------------------------
    // RELATIONSHIPS BY OTHER PACKAGES
    //------------------------------------------------------------------------------------------------------------------

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('ao.models.users'));
    }

}