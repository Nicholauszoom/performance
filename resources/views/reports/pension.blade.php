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
								<tr> <th>S/N</th>
									<th>MEMBER NO</th>
									<th>FIRST NAME</th>
									<th>MIDDLE NAME</th>
									<th>SURNAME</th>
                                    <th>WAGE</th>
                                   
									
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
                                    $rate2= ($row->pension_employer/$salary);
                                    $amount1= $row->pension_employee;
                                    $amount2= $row->pension_employer;
                                    $total_contribution= ($row->pension_employer+$row->pension_employee);

                                ?>

                                <tr>
                                    <td>{{ $row->SNo }}</td>
									<td>{{ !empty($member_no)? $member_no : "unknown" }}</td>
									<td>{{ $row->fname }}</td>
									<td>{{ $row->mname }}</td>
                                    <td>{{ $row->lname }}</td>
									<td>{{ $total_contribution }}</td>
                                    
									
								</tr>
                                <?php }}} ?>
                            </tbody>
						</table>
					</div>
					<!-- /column selectors -->
@endsection
