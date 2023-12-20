@extends('layouts.vertical', ['title' => 'Payroll'])
<style> .hdr {

    font-size: 15px !important;
}
</style>
@push('head-script')
@endpush

@push('head-scriptTwo')
@endpush

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/tables/datatables/extensions/buttons.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_extension_buttons_excel.js') }}"></script>
@endpush

@section('content')
    @php

        $payrollMonth = $payroll_date;
        $payrollState = $payroll_state;

        $total_previous = 0;
                    $total_current = 0;
                    $total_amount = 0;

    @endphp


<div class="card border-bottom-main rounded-0 border-0 shadow-none">

            @include('payroll.payroll_info_buttons')
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h4 class="me-4 text-center">Payroll Checklist</h4>

                    <div>
                        <label for="currency-tzs">
                          <input type="radio" id="currency-tzs" name="currency" value="2">
                          TZS
                        </label>
                        <label for="currency-usd">
                          <input type="radio" id="currency-usd" name="currency" value="3">
                          USD
                        </label>
                      </div>
{{--
                      <a id="pdf-link" href="#" target="_blank">
                        <button type="button" name="print" value="print" class="btn btn-main btn-sm">
                          <i class="ph-file-pdf"></i> PDF
                        </button>
                      </a> --}}

                      <button id="generate-pdf" class="btn btn-main btn-sm">
                        <i class="ph-file-pdf"></i> Generate PDF
                      </button>


                <table class="table datatable-excel-filter">

        @php

        $payNo_col = "";
        $name_col = "";
        $bank_col="";
        $branchCode_col="d-none";
        $accountNumber_col = "";
        $pensionNumber_col = "d-none";
        $currency_col="";
        $department_col = "d-none";
        $costCenter_col = "d-none";
        $basicSalary_col = "d-none";
        $netBasic_col = "d-none";
        $overtime_col = "d-none";
        $grossSalary_col = "d-none";
        $allowanceCat_col="d-none";
        $otherPayments_col="d-none";
        $taxBenefit_col = "d-none";
        $taxableGross_col = "d-none";
        $paye_col = "d-none";
        $nssfEmployee_col = "d-none";
        $nssfEmployer_col = "d-none";
        $nssfPayable_col = "d-none";
        $sdl_col = "d-none";
        $wcf_col = "d-none";
        $loanBoard_col = "d-none";
        $advanceOthers_col = "d-none";
        $totalDeduction_col = "d-none";
        $amountPayable_col = "";
        $colspan_col = "2";
        $show_terminations=false;
        $fitler_by_currency=true;


        @endphp
        @include('reports.payrolldetails.payroll_checklist_calculation')

        </table>
    </div>


    <!-- /column selectors -->



    <script>
        document.addEventListener('DOMContentLoaded', function() {
          const generatePDFButton = document.querySelector('#generate-pdf');
          const currencyRadios = document.querySelectorAll('input[name="currency"]');

          // Function to handle PDF generation
          function generatePDF() {
            const selectedCurrency = document.querySelector('input[name="currency"]:checked').value;

            // Send AJAX request to server to generate PDF
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `{{ route('reports.payrolldetails') }}?payrolldate={{ $payroll_date }}&payrollState={{ $payrollState }}&type=1&nature=${selectedCurrency}`, true);
            xhr.responseType = 'blob'; // Response type is set to blob

            xhr.onload = function() {
              if (xhr.status === 200) {
                // Create a blob object from the response
                const blob = new Blob([xhr.response], { type: 'application/pdf' });

                // Create a temporary link element to trigger the download
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'generated_pdf.pdf'; // Specify the filename for the downloaded file

                // Trigger the download
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
              }
            };

            xhr.send();
          }

          // Event listener for the Generate PDF button
          generatePDFButton.addEventListener('click', generatePDF);
        });
      </script>
@endsection
