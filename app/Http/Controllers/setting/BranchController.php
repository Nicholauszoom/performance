<?php

namespace App\Http\Controllers\setting;

use Illuminate\Http\Request;
use App\Models\setting\Branch;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BranchController extends Controller
{

    public function __construct($branchModel = null)
    {
        $this->branchModel = new Branch();
    }

    public function fetchBranch($id)
    {
        // $data = DB::table('bank_branch')->where('id', $id)->get();

        $data = $this->branchModel->bankBranchFetcher($id);

        return response()->json(['data' => $data]);
    }
}
