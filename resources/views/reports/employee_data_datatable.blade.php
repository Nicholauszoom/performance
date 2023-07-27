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
            {{-- <h5 class="mb-0">(Payroll Details)</h5> --}}
        </div>

        <table class="table datatable-button-html5-columns">
            <thead>
                <tr>
                    <th><b>Payroll No</b></th>

                    <th class="text-center"><b>Full Name</b><br>
                    </th>
                    <th class="text-end"><b>Grade</b></th>
                    <th class="text-end"><b>Job Title</b></th>

                    <th class="text-end"><b>Cost Center/Category</b></th>
                    <th class="text-end"><b>Department</b></th>

                    <th class="text-end"><b>Office/Branch</b></th>
                    <th class="text-end"><b>basic salary</b></th>
                    <th class="text-end"><b>Pension Number</b></th>
                    <th class="text-end"><b>Bank Ac No</b></th>
                    <th class="text-end"><b>TIN</b></th>
                    <th class="text-end"><b>NIDA</b></th>

                    <th class="text-end"><b>Gender</b></th>
                    <th class="text-end"><b>Contract Type</b></th>

                    <th class="text-end"><b>Date Of birth</b></th>
                    <th class="text-end"><b>Joining Date</b></th>

                    <th class="text-end"><b>Contract Month</b></th>
                    <th class="text-end"><b>Contract End Date</b></th>
                    <th class="text-end"><b>Leave Entitlement</b></th>
                    <th class="text-end"><b>Accrue Rate</b></th>
                    <th class="text-end"><b>Email Address</b></th>
                    <th class="text-end"><b>Phone Number</b></th>





                </tr>
            </thead>
            <tbody>
                @foreach ($employee as $row)
                <tr>
                    <td>{{ $row->emp_id }}</td>
                    <td>{{ $row->fname.' '.$row->mname.' '.$row->lname }}</td>
                    <td>{{ $row->emp_level }}</td>
                    <td>{{ $row->positions->name }}</td>
                    <td>{{ $row->cost_center }}</td>
                    <td>{{ $row->departments->name }}</td>
                    <td>{{ $row->branchies->name }}</td>
                    <td>{{ $row->salary }}</td>
                 <td>{{ $row->pf_membership_no }}</td>
                 <td>{{ $row->account_no }}</td>
                 <td>{{ $row->tin }}</td>
                 <td>{{ $row->national_id }}</td>
                 <td>{{ $row->gender }}</td>
                 <td>{{ $row->contracts->name }}</td>
                 <td>{{ $row->birthdate }}</td>
                 <td>{{ $row->hire_date }}</td>
                 <td>{{ date('M', strtotime($row->hire_date))  }}</td>
                 <td>{{ $row->contract_end }}</td>
                 <td>{{ $row->leave_days_entitled }}</td>
                 <td>{{ $row->accrual_rate }}</td>
                 <td>{{ $row->email }}</td>
                 <td>{{ $row->phone }}</td>

                </tr>

                @endforeach

            </tbody>



        </table>
    </div>


    <!-- /column selectors -->
@endsection
