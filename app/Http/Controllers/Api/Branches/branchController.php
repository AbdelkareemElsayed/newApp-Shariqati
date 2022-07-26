<?php

namespace App\Http\Controllers\Api\Branches;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\branchesResource;
use App\Http\Resources\SingleBranchesResource;
use App\Models\dashboard\Branches\branch;
use Illuminate\Http\Request;

class branchController extends AppBaseController
{
    //

   # Get All Branches . . .
    public function LoadBranches($ownerId)
    {
        $data =  branch::where('company_id', $ownerId)->get();

        return $this->sendResponse(["data" => branchesResource :: collection($data), "message" => __('Branches retrieved successfully') , "count" => count($data)]);
    }


    # Get Single Branch . . .
    public function SingleBranch($id)
    {
        $data =  branch::find($id)->with(["GetCountry" => function ($query) {
            $query->select('id', 'name', 'name_ar');
        }])->with(["Getstate" => function ($query) {
            $query->select('id', 'name', 'name_ar');
        }])->with(["GetCity" => function ($query) {
            $query->select('id', 'name', 'name_ar');
        }])->get();

        return $this->sendResponse(["data" => SingleBranchesResource :: collection($data), "message" => __('Branches retrieved successfully') , "count" => count($data)]);
    }


}
