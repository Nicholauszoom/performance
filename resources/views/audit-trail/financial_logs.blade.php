@extends('layouts.vertical', ['title' => 'Payroll Input Changes Approval Report'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/tables/datatables/extensions/buttons.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_extension_buttons_excel.js') }}"></script>
@endpush

@section('content')

    <div class="card">
        <div class="card-header">
            <h5 class="text-main">Payroll Input Changes Approval Report</h5>
        </div>

        <table class="table datatable-excel-filter">
            <thead>
                <tr>
                  <th>Payrollno</th>
                  <th>Name</th>
                  <th>Time Stamp</th>
                  <th>Change Made By</th>
                  <th>FieldName</th>
                  <th>From</th>
                  <th>To</th>
                  <th>InputScreen</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($logs as $row)
                    <tr id="{{ 'domain'.$row->id }}">
                        <td>{{ $row->payrollno }}</td>

                        <td> {{ $row->empName }} </td>

                        <td>
                            @php
                                $temp = explode(' ',$row->created_at);
                            @endphp

                            <p> <strong>Date </strong> : {{ $temp[0] }} </p>
                            <p> <strong>Time </strong> : {{ $temp[1] }} </p>
                        </td>

                        <td> {{ $row->authName }} </td>

                        <td>{{ $row->field_name }}</td>

                        <td>{{ $row->action_from }}</td>

                        <td>{{ $row->action_to }}</td>

                        <td>{{ $row->input_screen }}</td>
                    </tr>
                @endforeach
              </tbody>
        </table>
    </div>

@endsection

