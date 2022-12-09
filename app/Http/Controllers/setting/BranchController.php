<?php

namespace App\Http\Controllers\setting;

use Illuminate\Http\Request;
use App\Models\setting\Branch;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BranchController extends Controller
{

    public function __construct(Branch $branch)
    {
        $this->branch =  $branch;
    }

    public function fetchBranch(Request $request)
    {
        if(isset($request->bank)){

            $queryBranch = $this->branch->bankBranchFetcher($request->bank);

            foreach ($queryBranch as $rows){
                echo "<option value='".$rows->id."'>".$rows->name."</option>";
            }

        }else{
            echo '<option value="">What are you looking for exactly</option>';
        }
    }
}
