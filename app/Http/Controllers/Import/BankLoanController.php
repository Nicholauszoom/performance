<?php

namespace App\Http\Controllers\Import;

use App\Models\BankLoan;
use Illuminate\Http\Request;
use App\Exports\BankLoanExport;
use App\Imports\BankLoanImport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BankLoanTemplateExport;
use Maatwebsite\Excel\Validators\ValidationException;


class BankLoanController extends Controller
{
  /**
    * @return \Illuminate\Support\Collection
    */
    public function index()
    {
        $loans = BankLoan::orderBy('created_at','DESC')->get();
  
        return view('loans.loans', compact('loans'));
    }
       
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(
            [
            'employee_id' => 'required|max:255',
            'product' => 'required',
            'amount' => 'required',
            'created_at' => 'required',
             ]
            );

            $loan = new BankLoan();
            $loan->employee_id=$request->employee_id;
            $loan->product=$request->product;
            $loan->amount=$request->amount;
            $loan->created_at=$request->created_at;
            $loan->added_by=Auth::user()->id;
            $loan->save();
           
            return response()->json(['status' => "success"]);
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
    public function template() 
    {
        return Excel::download(new BankLoanTemplateExport, 'loans_template.xlsx');
    }


    public function import(Request $request) {
        $this->validate($request, [
            'file' => 'required|mimes:xls,csv,xlsx,txt' // txt is needed for csv mime type validation
        ]);
        if($request->file('file')) {
        try {
            Excel::import(new BankLoanImport, $request->file('file'));
            return redirect('flex/bank-loans/all-loans')->with('status', 'Loans have been uploaded successfully!');
        } catch (ValidationException $e) {
                $msg = '';
                $failures = $e->failures();
                foreach ($failures as $failure) {
                    $msg = 'The uploaded file has a problem in a row '.$failure->row(); // row that went wrong
                    $msg = $msg.'There is a problem in a column '.$failure->attribute(); // either heading key (if using heading row concern) or column index
                    $msg = $msg.'. '.$failure->errors()[0]; // Actual error messages from Laravel validator
                    
                }
                return redirect('flex/bank-loans/all-loans')->with('status', $msg);
            }
        }

        return redirect('flex/bank-loans/all-loans')->with('status', 'Sorry! ,there are some issues with the uploaded file.');
     }
}