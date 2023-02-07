@extends('layouts.vertical', ['title' => 'Annual Leave Report'])

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
            <h5 class="text-main">Annual Leave Report</h5>
        </div>

        <table class="table datatable-excel-filter">
            <thead>
                <tr>
                <th>No</th>
                  <th>Employee Name</th>
                  {{-- 100032 100252 --}}
                  {{-- <th>Position</th> --}}
                  <th>Email</th>
                  <th>Leave Address</th>
                  <th>From</th>
                  <th>To</th>
                  {{-- <th>InputScreen</th> --}}
                </tr>
            </thead>

            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($leave_data as $row)
                    {{-- <tr id="{{ 'domain'.$row->id }}"> --}}
                        <td>{{ $i++ }}</td>
                        {{-- <td>{{ $row->empName }}</td> --}}
                        {{-- <td>{{ $row->position }}</td> --}}
                        <td>{{ $row->full_name }}</td>
                        {{-- <td>{{ $row->full_name }}</td> --}}

                        {{-- <td> {{ $row->empName }} </td> --}}

                        {{-- <td>
                            @php
                                $temp = explode(' ',$row->created_at);
                            @endphp

                            <p> <strong>Date </strong> : {{ $temp[0] }} </p>
                            <p> <strong>Time </strong> : {{ $temp[1] }} </p>
                        </td> --}}
                        <td>{{ $row->email }}</td>

                        <td>{{ $row->leave_address }}</td>
                        <td> {{ $row->start }} </td>

                        <td>{{ $row->end }}</td>


                        

                        {{-- <td>{{ $row->input_screen }}</td> --}}
                    </tr>
                @endforeach
              </tbody>
        </table>
    </div>

@endsection

