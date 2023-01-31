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
							<h5 class="mb-0">Leave Balance</h5>
						</div>
						<table class="table datatable-button-html5-columns">
            <thead>
              <tr>
                <th>S/N</th>
                <th>EMP ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Opening Balance</th>
                <th>Accrual Balance</th>
                <th>Used Days</th>
                <th>Current Balance</th>
              </tr>
            </thead>

              <tbody>
              <?php
              $i=0;
                foreach ($employees as $employee) { $i++ ?>
                <tr>
                <td ><?php echo $i; ?></td>
                  <td ><?php echo $employee->emp_id; ?></td>
                  <td><?php  echo $employee->fname; ?></td>
                  <td><?php  echo $employee->lname; ?></td>
                  <td><?php echo number_format($employee->maximum_days,2) ?></td>
                  <td><?php echo number_format($employee->accrual_days,2) ?></td>
                  <td><?php echo number_format($employee->maximum_days,2) ?></td>
                  <td><?php echo number_format($employee->accrual_days,2) ?></td>
                
                  </tr>

                <?php } ?>
            </tbody>

						</table>
					</div>
					<!-- /column selectors -->
@endsection
