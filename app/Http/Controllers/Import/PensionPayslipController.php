<?php

namespace App\Http\Controllers\Import;
use App\Models\BankLoan;

use Illuminate\Http\Request;
use App\Imports\PensionImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BankLoanTemplateExport;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Payroll\FlexPerformanceModel;




class PensionPayslipController extends Controller
{
    protected $flexperformance_model;

    public function __construct(FlexPerformanceModel $flexperformance_model)
    {
        $this->flexperformance_model = $flexperformance_model;
    }

    /**
     * @return
     */
    public function index()
    {
        // $loans = BankLoan::orderBy('created_at','DESC')->get();
        $data["parent"] = "Payroll";
        $data["child"] = "Receipt";
        $data['month_list'] = $this->flexperformance_model->payroll_month_list();

        return view('payroll.pension_receipt', $data);
    }


public function authenticateUser($permissions)
{
    // Check if the user is not authenticated
    if (!auth()->check()) {
        // Redirect the user to the login page
        return redirect()->route('login');
    }

    // Check if the authenticated user does not have the specified permissions
    if (Gate::allows($permissions)) {
        // If not, abort the request with a 401 Unauthorized status code
        abort(Response::HTTP_UNAUTHORIZED);
    }
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $this->authenticateUser('add-loan');

        request()->validate(
            [
                'employee_id' => 'required|max:255',
                'product' => 'required',
                'amount' => 'required',
                'created_at' => 'required',
                'date' => 'required',
            ]
        );

        $loan = new BankLoan();
        $loan->employee_id = $request->employee_id;
        $loan->product = $request->product;
        $loan->amount = $request->amount;
        $loan->created_at = $request->created_at;
        $loan->added_by = Auth::user()->id;
        $loan->date = $request->date;

        // dd($request->date);
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

    public function import(Request $request)
    {


        // $this->authenticateUser('add-loan');


        $date = $request->date;
        $receipt = $request->receipt;
        $payroll_date = $request->payroll_date;

        $data = DB::table('payroll_logs')->where("payroll_date", $payroll_date)->update(['receipt_no' => $receipt, 'receipt_date' => $date]);

        if ($data) {
            return redirect()->back()->with('success', 'Pension Slip Updated successfully!');

        } else {
            return redirect()->back()->with('error', 'Error! Not Updated Succesfull');

        }

    }

    public function uploadPensionData(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx'
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        Excel::import(new PensionImport, $request->file('file'));

        return redirect()->back()->with('success', 'Pension data uploaded successfully.');
    }

    public function downloadTemplate()
    {
        $filePath = public_path('uploads/templates/pensionss.xlsx');

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Template file not found.');
        }

        return Response::download($filePath, 'pension_template.xlsx');
    }
}
