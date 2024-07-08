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
							<h5 class="mb-0">(Pension Contribution)</h5>
						</div>
						<table class="table datatable-button-html5-columns">
							<thead>
								<tr>
                                    <th>S/N</th>
                                    <th>PAYROLL NO</th>
									<th>MEMBER NO</th>
									<th>FULL NAME</th>
									{{-- <th hidden>MIDDLE NAME</th>
									<th hidden>SURNAME</th> --}}
                                    <th>GROS PAY</th>
                                    <th>CONTRIBUTION</th>

								</tr>
							</thead>
							<tbody>
                                <?php
                                $total_contribution = 0;
                                $total_salary = 0;
                                if(!empty($pension)){
                                foreach ($pension as $row){
                                    $salary= $row->salary + $row->allowances;
                                    if($salary != 0){
                                    $name = $row->name;
                                    $member_no = $row->pf_membership_no;

                                    //if($salary == 0)dd($row->emp_id);
                                    $rate1= ($row->pension_employee/$salary);
                                    $rate2= ($row->pension_employee/$salary);
                                    $amount1= $row->pension_employee;
                                    $amount2= $row->pension_employee;
                                    $contribution= (2*$row->pension_employee);
                                    $total_contribution +=$contribution;
                                    $total_salary += $salary

                                ?>

                                <tr>
                                    <td>{{ $row->SNo }}</td>
                                    <td>{{ $row->emp_id }}</td>
									<td>{{ !empty($member_no)? $member_no : "unknown" }}</td>
									<td>{{ $row->name }}</td>
									{{-- <td hidden>{{ $row->mname }}</td>
                                    <td hidden>{{ $row->lname }}</td> --}}
                                    <td >{{ number_format($salary,2) }}</td>
									<td>{{ number_format($contribution,2) }}</td>
								</tr>
                                <?php }}} ?>


                                <?php
                                if(!empty($pension_termination)){
                                foreach ($pension_termination as $row2){
                                    $salary= $row2->total_gross;
                                    if($salary != 0){
                                    $name = $row2->name;
                                    $member_no = $row2->pf_membership_no;

                                    //if($salary == 0)dd($row2->emp_id);
                                    $rate1= ($row2->pension_employee/$salary);
                                    $rate2= ($row2->pension_employee/$salary);
                                    $amount1= $row2->pension_employee;
                                    $amount2= $row2->pension_employee;
                                    $contribution= ($row2->pension_employee*2);
                                    $total_contribution += $contribution;
                                    $total_salary +=$salary;

                                ?>

                                <tr>
                                    <td>{{ $row2->SNo }}</td>
                                    <td>{{ $row2->emp_id }}</td>
									<td>{{ !empty($member_no)? $member_no : "unknown" }}</td>
									<td>{{ $row2->name }}</td>
									{{-- <td hidden>{{ $row2->mname }}</td>
                                    <td hidden>{{ $row2->lname }}</td> --}}
                                    <td>{{ number_format($salary,2) }}</td>
									<td>{{ number_format($contribution,2) }}</td>
								</tr>
                                <?php }}} ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    {{-- <td hidden></td>
                                    <td hidden></td> --}}
                                    <td colspan="3"></td>
                                    <td><b>TOTAL</b></td>
                                    <td><b>{{ number_format($total_salary,2) }}</b></td>
									<td><b>{{ number_format($total_contribution,2) }}</b></td>
								</tr>
                            </tfoot>
						</table>
					</div>
					<!-- /column selectors -->
@endsection
