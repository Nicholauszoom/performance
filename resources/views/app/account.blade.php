<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


	<!-- Global stylesheets -->
	<link href="../../../assets/fonts/inter/inter.css" rel="stylesheet" type="text/css">
	<link href="../../../assets/icons/phosphor/styles.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/ltr/all.min.css" id="stylesheet" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="../../../assets/demo/demo_configurator.js"></script>
	<script src="../../../assets/js/bootstrap/bootstrap.bundle.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="../../../assets/js/jquery/jquery.min.js"></script>
	<script src="../../../assets/js/vendor/tables/datatables/datatables.min.js"></script>

	<script src="assets/js/app.js"></script>
	<script src="../../../assets/demo/pages/datatables_basic.js"></script>
	<!-- /theme JS files -->
    @extends('layouts.vertical', ['title' => 'Dashboard'])

    @push('head-script')
    <script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    @endpush

    @push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
    @endpush

    @section('content')('content')
</head>

<body>
					<div class="card">
						<div class="card-header">
                            <h3>Account Coding </h3>
						</div>

						<div class="card-body">
                            <h2> Account Codes</h2>
						</div>

						<table class="table datatable-basic">
							<thead>
								<tr>
									<th>S/N</th>
                                    <th>Code</th>
                                    <th>Name</th>
									<th>Status</th>
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
								<tr>
                                    @foreach ($accounting_coding as $row)

									<td>{{ $row->id }}</td>
									<td>{{ $row->code }}</td>
									<td>{{ $row->name }}</td>
									<td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>

                                    @endforeach
							</tbody>
						</table>
					</div>
					<!-- /basic datatable -->

				</div>
				<!-- /content area -->

