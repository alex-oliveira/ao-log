<?php

namespace AoLogs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{

    use SoftDeletes;

    //------------------------------------------------------------------------------------------------------------------
    // ATTRIBUTES
    //------------------------------------------------------------------------------------------------------------------

    protected $table = 'ao_logs_logs';

    protected $fillable = ['user_id', 'operation', 'title', 'description'];

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