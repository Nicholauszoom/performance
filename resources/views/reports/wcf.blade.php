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
							<h5 class="mb-0">(African Banking Corporation employees at WCF)</h5>
						</div>
						<table class="table datatable-button-html5-columns">
							<thead>
								<tr align="center">
									<th width="50" align="center"><b>S/N</b></th>
									<th width="60"><b>Employee ID</b></th>
									<th width="150"><b>Employee Name</b></th>
									<th><b>Tin</b></th>
									<th><b>National ID</b></th>	
									<th><b>Employee Basic Salary</b></th>
									<th><b>Employee Gross Salary</b></th>
									<th><b>WCF Contribution </b></th>
									</tr>
							</thead>
							<tbody>
								<?php
								foreach ($wcf as $row){
									$emp_id= $row->emp_id;
									$name= $row->name;
									$salary= $row->salary;
									$gross= ($row->allowances+$row->salary);
									$tin = $row->tin;
									$national_id = $row->national_id;
								  ?>
								  <tr align="right">
									<td width="50" align="center">{{$row->SNo}}</td>
									<td width="60" align="center">{{$emp_id}}</td>
									<td width="150" align ="left">{{$name}}</td>
									 <td align="left">{{$tin}}</td>
									 <td align="left">{{$national_id}}</td>
									<td align="right">{{number_format($salary,2)}}</td>
									<td align="right">{{number_format($gross,2)}}</td>
									<td align="right">{{number_format($row->wcf,2)}}</td>
									</tr>
									<?php } ?>
								
							</tbody>
						</table>
					</div>
					<!-- /column selectors -->
@endsection
