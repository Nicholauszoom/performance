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
								<tr> <th>S/N</th>
									<th>MEMBER NO</th>
									<th>FULL NAME</th>
									<th hidden>MIDDLE NAME</th>
									<th hidden>SURNAME</th>
                                    <th>GROS PAY</th>
                                    <th>CONTRIBUTION</th>


								</tr>
							</thead>
							<tbody>
                                <?php
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
                                    $total_contribution= (2*$row->pension_employee);

                                ?>

                                <tr>
                                    <td>{{ $row->SNo }}</td>
									<td>{{ !empty($member_no)? $member_no : "unknown" }}</td>
									<td>{{ $row->name }}</td>
									<td hidden>{{ $row->mname }}</td>
                                    <td hidden>{{ $row->lname }}</td>
                                    <td hidden>{{ $salary }}</td>
									<td>{{ $total_contribution }}</td>


								</tr>
                                <?php }}} ?>


                                <?php
                                if(!empty($pension_termination)){
                                foreach ($pension_termination as $row){
                                    $salary= $row->total_gross;
                                    if($salary != 0){
                                    $name = $row->name;
                                    $member_no = $row->pf_membership_no;

                                    //if($salary == 0)dd($row->emp_id);
                                    $rate1= ($row->pension_employee/$salary);
                                    $rate2= ($row->pension_employee/$salary);
                                    $amount1= $row->pension_employee;
                                    $amount2= $row->pension_employee;
                                    $total_contribution= ($row->pension_employee*2);

                                ?>

                                <tr>
                                    <td>{{ $row->SNo }}</td>
									<td>{{ !empty($member_no)? $member_no : "unknown" }}</td>
									<td>{{ $row->name }}</td>
									<td hidden>{{ $row->mname }}</td>
                                    <td hidden>{{ $row->lname }}</td>
                                    <td>{{ $salary }}</td>
									<td>{{ $total_contribution }}</td>


								</tr>
                                <?php }}} ?>
                            </tbody>
						</table>
					</div>
					<!-- /column selectors -->
@endsection
