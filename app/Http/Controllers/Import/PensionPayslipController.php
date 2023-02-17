<?php

namespace App\Http\Controllers\Import;
use App\Models\BankLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BankLoanTemplateExport;
use App\Models\Payroll\FlexPerformanceModel;



class PensionPayslipController extends Controller
{
    protected $flexperformance_model;


    public function __construct(FlexPerformanceModel $flexperformance_model)
    {
        $this->flexperformance_model = $flexperformance_model;
    }
  /**
    * @return \Illuminate\Support\Collection
    */
    public function index()
    {
       // $loans = BankLoan::orderBy('created_at','DESC')->get();
       $data['month_list'] = $this->flexperformance_model->payroll_month_list();

        return view('payroll.pension_receipt',$data);
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
            'date'=>'required'
             ]
            );

            $loan = new BankLoan();
            $loan->employee_id=$request->employee_id;
            $loan->product=$request->product;
            $loan->amount=$request->amount;
            $loan->created_at=$request->created_at;
            $loan->added_by=Auth::user()->id;
            $loan->date=$request->date;


            dd($request->date);
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

      $date = $request->date;
      $receipt = $request->receipt;
      $payroll_date = $request->payroll_date;

      $data = DB::table('payroll_logs')->where("payroll_date",$payroll_date)->update(['receipt_no'=>$receipt,'receipt_date'=>$date]);


     if($data){
        return redirect()->back()->with('success', 'Pension Slip Updated successfully!');

     }else{
        return redirect()->back()->with('errror', 'Error! Not Updated Succesfull');

     }

     }
}
