<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class GenericModel extends Model
{
    public function parseValuesFromRequest(Request $request)
    {
        foreach ($this->fillable as $field) {
            if ($request->{$field}) {
                $this->{$field} = $request->{$field};
            }
        }

        return $this;
    }
}
