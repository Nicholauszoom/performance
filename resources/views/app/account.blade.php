
	<!-- /theme JS files -->
    @extends('layouts.vertical', ['title' => 'Dashboard'])

    @push('head-script')
    <script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    @endpush

    @push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
    @endpush

    @section('content')
</head>

<body>
					<div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
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

