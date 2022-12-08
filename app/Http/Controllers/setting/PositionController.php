<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use App\Models\setting\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{

    public function __construct(Position $position)
    {
        $this->position = $position;
    }

    public function positionFetcher(Request $request)
    {

        if( isset($request->dept_id) ){

            $query = $this->position->positionfetcher($request->dept_id);

            $querypos = $query[0];
            $querylinemanager = $query[1];
            $querydirector = $query[2];

            $data = [];
            $data['position'] = $querypos;
            $data['linemanager'] = $querylinemanager;
            $data['director'] = $querydirector;

                echo json_encode($data);
            }
        //    else{
        //        echo '<option value="">Position not available</option>';
        //    }
    }
}
