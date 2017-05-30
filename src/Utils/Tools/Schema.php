<?php

namespace AoLogs\Utils\Tools;

use AoScrud\Utils\Traits\BuildTrait;
use Illuminate\Support\Facades\Schema as LaraSchema;
use Illuminate\Database\Schema\Blueprint;

class Schema
{
    use BuildTrait;

    protected $prefix = 'ao_logs_x_';

    public function table($table)
    {
        return $this->prefix . '' . $table;
    }

    public function create($table, $fk = null, $type = 'integer')
    {
        if (is_null($fk))
            $fk = str_singular($table) . '_id';

        LaraSchema::create($this->table($table), function (Blueprint $t) use ($table, $fk, $type) {
            $t->$type($fk)->unsigned();
            $t->foreign($fk, 'fk_' . $table . '_x_ao_logs')->references('id')->on($table);

            $t->bigInteger('log_id')->unsigned();
            $t->foreign('log_id', 'fk_ao_logs_x_' . $table)->references('id')->on('ao_logs_logs');

            $t->primary([$fk, 'log_id'], 'pk_ao_logs_x_' . $table);
        });
    }

    public function drop($table)
    {
        LaraSchema::dropIfExists($this->table($table));
    }

}