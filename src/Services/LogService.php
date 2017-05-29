<?php

namespace AoLogs\Services;

use AoLogs\Models\Log;
use AoScrud\Core\ScrudService;
use Illuminate\Support\Facades\Auth;

class LogService extends ScrudService
{

    //------------------------------------------------------------------------------------------------------------------
    // DYNAMIC
    //------------------------------------------------------------------------------------------------------------------

    protected $dynamicClass;

    protected $dynamicTable;

    protected $dynamicForeign;

    public function setDynamicClass($dynamicClass)
    {
        $parts = explode('.', app()->make($dynamicClass)->logs()->getQualifiedForeignKeyName());

        $this->dynamicClass = $dynamicClass;
        $this->dynamicTable = $parts[0];
        $this->dynamicForeign = $parts[1];

        return $this;
    }

    protected function applyDynamicFilter($config)
    {
        $model = $config->model();
        $model->dynamicClass = $this->dynamicClass;
        $model->dynamicTable = $this->dynamicTable;
        $model->dynamicForeign = $this->dynamicForeign;

        $id = $config->data()->get($this->dynamicForeign);

        if (!app()->make($this->dynamicClass)->find($id))
            abort(404);

        $config->model($model->whereHas('dynamicWith', function ($query) use ($id) {
            $query->where('id', $id);
        }));
    }

    //------------------------------------------------------------------------------------------------------------------
    // OWNER
    //------------------------------------------------------------------------------------------------------------------

    private $owner;

    protected function setOwner($config)
    {
        $this->owner = app()->make($this->dynamicClass)->find($config->data()->get($this->dynamicForeign));
        if (!$this->owner)
            abort(404);
    }

    //------------------------------------------------------------------------------------------------------------------
    // CONSTRUCTOR
    //------------------------------------------------------------------------------------------------------------------

    private $temp = false;

    public function __construct()
    {
        parent::__construct();

        // SEARCH //----------------------------------------------------------------------------------------------------

        $this->search
            ->model(Log::class)
            ->columns(['id', 'operation', 'title'])
            ->otherColumns(['user_id', 'description', 'created_at', 'updated_at'])
            ->setAllOrders()
            ->with([
                'user' => [
                    'columns' => ['id', 'name'],
                    'otherColumns' => ['email', 'created_at', 'updated_at', 'deleted_at']
                ]
            ])
            ->rules([
                'id' => '=',
                'operation' => '=',
                [
                    'title' => '%like%|get:search',
                    'description' => '%like%|get:search',
                ]
            ])
            ->onPrepare(function ($config) {
                $this->applyDynamicFilter($config);
            });


        // READ //------------------------------------------------------------------------------------------------------

        $this->read
            ->model(Log::class)
            ->columns($this->search->columns()->all())
            ->with($this->search->with()->all())
            ->otherColumns($this->search->otherColumns()->all())
            ->onPrepare(function ($config) {
                $this->applyDynamicFilter($config);
            });

        // CREATE //----------------------------------------------------------------------------------------------------

        $this->create
            ->model(Log::class)
            ->columns(['user_id', 'operation', 'title', 'description'])
            ->rules([
                'operation' => 'required|in:GET,POST,PUT,DELETE',
                'title' => 'required',
                'description' => 'required',
                'user_id' => 'sometimes|nullable|integer|exists:' . config('ao.tables.users') . ',id'
            ]);
    }

}