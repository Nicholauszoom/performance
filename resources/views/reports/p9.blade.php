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
					<div class="card">
						<div class="card-header">
							<h5 class="mb-0">(P.A.Y.E)</h5>
						</div>
						<table class="table datatable-button-html5-columns">
							<thead>
								<tr>	<td width="50"><b>S/NO</b></td>
                                    <th width="180"><b>NAME OF EMPLOYEE</b></th>
                                     <th width="140"><b>BASIC PAY</b></th>
                                     <th width="140"><b>GROSS PAY</b></th>
                                     <th width="140"><b>DEDUCTIONS</b></th>
                                     <th width="140"><b>TAXABLE AMOUNT</b></th>
                                     <th width="140"><b>TAX DUE</b></th>
                                     </tr>
							</thead>
							<tbody>
                                <?php
                                foreach($paye as $key){ 
                                    $salary = $key->salary;
                                    $gross = $key->salary + $key->allowances;
                                    $name = $key->name;
                                    $deductions = $key->pension_employee;
                                    $taxable = $key->salary + $key->allowances - $key->pension_employee; 
                                    $taxdue = $key->taxdue;

                                    ?>
                                    <tr>
                                        <td width="50">{{ $key->sNo }}</td>
                                        <td align="left" width="180">{{ $name }}</td>
                                        <td width="140" align="right">{{ number_format($salary,2) }}</td>
                                        <td width="140" align="right">{{ number_format($gross,2) }}</td>
                                        <td width="140" align="right">{{ number_format($deductions,2) }}</td>
                                        <td width="140" align="right">{{ number_format($taxable,2) }}</td>
                                        <td width="140" align="right">{{ number_format($taxdue,2) }}</td>
                                     </tr>
                                     <?php } ?>
                                     {{-- <?php foreach($total as $key){
                                        $salary = $key->sum_salary;
                                        $gross = $key->sum_gross;
                                        $deductions = $key->sum_deductions;
                                        $taxable = $key->sum_taxable; 
                                        $taxdue = $key->sum_taxdue; 
                                        ?>
                                       <tr>
                                          <td colspan ="2" style="background-color:#FFFF00;">TOTAL</td>
                                          <td align="right">{{ number_format($salary,2) }}</td>
                                          <td align="right">{{ number_format($gross,2) }}</td>
                                          <td align="right">{{ number_format($deductions,2) }}</td>
                                          <td align="right">{{ number_format($taxable,2) }}</td>
                                          <td align="right">{{ number_format($taxdue,2) }}</td>
                                          </tr>
                                     <?php } ?> --}}
                            </tbody>
						</table>
					</div>
					<!-- /column selectors -->
@endsection
