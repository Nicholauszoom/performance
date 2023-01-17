<?php

namespace App\Http\Controllers\Import;

use App\Models\BankLoan;
use Illuminate\Http\Request;
use App\Exports\BankLoanExport;
use App\Imports\BankLoanImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;


class BankLoanController extends Controller
{
  /**
    * @return \Illuminate\Support\Collection
    */
    public function index()
    {
        $loans = BankLoan::get();
  
        return view('loans.loans', compact('loans'));
    }
        
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new BankLoanExport, 'loans.xlsx');
    }
       
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import() 
    {
        Excel::import(new BankLoanImport,request()->file('file'));
        return back();
    }
}
