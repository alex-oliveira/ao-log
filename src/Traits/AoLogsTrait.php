<?php

namespace AoLogs\Traits;

use AoLogs\Models\Log;

trait AoLogsTrait
{

    /**
     * @return Log[]|\Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function logs()
    {
        return $this->belongsToMany(Log::class, AoLogs()->schema()->table($this->getTable()));
    }

}