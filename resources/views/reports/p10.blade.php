@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>

    <script src="{{ asset('assets/js/components/tables/datatables/extensions/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/tables/datatables/extensions/pdfmake/vfs_fonts.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/tables/datatables/extensions/buttons.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatables_extension_buttons_html5.js') }} "></script>
@endpush

@section('content')
    <!-- Column selectors -->
    <div class="card border-top-width-3 border-top-width-3 border-top-main  border-top-main  p-2">
        <div class="card-header">
            <h5 class="mb-0">(SDL)</h5>

            </li>
        </div>
        {{-- <table class="table1 datatable-button-html5-columns1">
            <thead>
                <tr>
                    <th width='70'><b>Month</b></th>
                    <th><b>Payment to Permanent employees TZS</b></th>
                    <th><b>Payment to Casual employees TZS</b></th>
                    <th><b>Total Gross Emoluments TZS</b></th>
                    <th><b>Amount of SDL Paid TZS</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($sdl as $key) {
                    $month = $key->payroll_date;
		          $permanent = $key->sum_salary;
		          $casual = 0;
		          $total_gross = $key->sum_gross;
		          $sdl_paid = $key->sum_sdl;

                ?>
                <tr>
                    <td><b>{{ date('F', strtotime($month)) }}</b></td>
                    <td align="right">{{ number_format($total_gross, 2) }}</td>
                    <td align="right">{{ number_format($casual, 2) }}</td>
                    <td align="right">{{ number_format($total_gross + $casual, 2) }}</td>
                    <td align="right">{{ number_format($sdl_paid, 2) }}</td>
                </tr>
            </tbody>
                <?php } ?>
                <tfoot>
                 <?php foreach($total as $key){
		                          $totalpermanent = $key->total_salary;
		                            $totalcasual = 0.00;
		                               $totalgross = $key->total_gross;
		                            $totalsdl = $key->total_sdl;
		                          $rate = (($totalsdl/$totalpermanent)*100);


                                        ?>
                                      <tr>
                                        <th>TOTAL</th>
                                      <th align="right">{{ number_format($totalgross,2) }}</th>
                                      <th align="right">{{ number_format($totalcasual,2) }}</th>
                                      <th align="right">{{ number_format($totalgross+$totalcasual,2) }}</th>
                                      <th align="right">{{ number_format($totalsdl,2) }}</th>
                                      </tr>
                                     <?php } ?>
                                    </tfoot>
        </table> --}}
<hr>
        <table class="table datatable-button-html5-columns">
            <thead>
                <tr>	<td ><b>S/NO</b></td>
                    <th ><b>NAME OF EMPLOYEE</b></th>
                    <th><b>TIN</b></th>
                    <th><b>NATIONAL ID</b></th>
                    <th><b>POSTAL ADDRESS</b></th>
                     <th><b>POSTAL CITY</b></th>
                     <th><b>BASIC PAY</b></th>
                     <th><b>GROSS PAY</b></th>
                     <th><b>SDL</b></th>
                     </tr>
            </thead>
            <tbody>
                <?php
                foreach ($paye as $key) {
                    $salary = $key->salary;
    $gross = $key->salary + $key->allowances;
    $name = $key->name;
    $deductions = $key->pension_employee;
    $taxable = $key->salary + $key->allowances - $key->pension_employee;
    $taxdue = $key->taxdue;
    $sdl = 0.04 * $gross;
    $tin = $key->tin;
    $national_id = $key->national_id;

                ?>
               <tr>
                <td >{{ $key->sNo }}</td>
                <td >{{ $name }}</td>
                <td>{{ $tin }}</td>
                <td>{{ $national_id }}</td>
                <td >{{  $key->postal_address }}</td>
                <td>{{ $key->postal_city }}</td>
                <td>{{ number_format($salary,2) }}</td>
                <td>{{ number_format($gross,2) }}</td>
                <td>{{ number_format($sdl,2) }}</td>
             </tr>
            </tbody>
                <?php } ?>
                <tfoot>
                 <?php foreach($total as $key){
		                          $salary = $key->total_salary;
    $gross = $key->total_gross;
    $total_sdl = $key->total_sdl;

                                        ?>
                                     <tr>
                                        <td colspan ="4" style="background-color:#FFFF00;">TOTAL</td>
                                        <td align="right"></td>
                                        <td align="right"></td>
                                        <td align="right">{{ number_format($salary,2) }}</td>
                                        <td align="right">{{ number_format($gross,2) }}</td>
                                        <td align="right">{{ number_format($total_sdl,2) }}</td>

                                        </tr>
                                     <?php } ?>
                                    </tfoot>
        </table>
        <hr>

    </div>
    <!-- /column selectors -->
@endsection
