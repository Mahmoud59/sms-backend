<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\BackController;
use App\Models\ClassTime;
use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends BackController
{
    public function __construct(Configuration $model)
    {
        parent::__construct($model);
    }

    public function get_configuration()
    {
        $configure = $this->model::find(1);

        $classTime = ClassTime::find(1);

        $configure->setAttribute('classTime', $classTime);

        return $this->APIResponse($configure, null, 200);
    }

    public function configuration(Request $request)
    {
        $configure = $this->model::find(1);
        $configure->update($request->all());

        $classTime = ClassTime::find(1);
        $classTime->update($request->all());

        $configure->setAttribute('classTime', $classTime);

        return $this->APIResponse($configure , null  ,  200);
    }

}
