@extends('layouts.vertical', ['title' => 'Dashboard'])

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
            <div class="d-flex justify-content-between align-center">
                <h5 class="text-main">User Activity Logs</h5>

                @if (!empty($logs) && session('mng_audit'))
                    <form action="{{ route('flex.LogsDestroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-main" id="show-confirm" title="Delete Logs">DELETE ALL LOGS</button>
                    </form>
                @endif
            </div>

            <div id="feedBack" class="mt-2"></div>
        </div>

        <table class="table datatable-excel-filter">
            <thead>
                <tr>
                  <th>S/N</th>
                  <th>Employee Name</th>
                  <th>Position</th>
                  <th>Action Description</th>
                  <th>Risk</th>
                  <th>Time</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($logs as $row)
                    <tr id="{{ 'domain'.$row->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a title="More Details">{{ $row->empName }}</a>
                        </td>

                        <td>
                            <p> <strong>Department </strong> : {{ $row->department }} </p>
                            <p> <strong>Position </strong> : {{ $row->position }} </p>
                        </td>

                        <td>{{ $row->action_performed }}</td>

                        <td>
                            @if ($row->risk == 1)
                                <span class="badge bg-danger bg-opacity-20 text-danger">High</span>
                            @elseif ($row->risk == 2)
                                <span class="badge bg-secondary bg-opacity-20 text-secondary">Medium</span>
                            @elseif ($row->risk == 3)
                                <span class="badge bg-success bg-opacity-20 text-success">Low</span>
                            @else
                                <span class="badge bg-dark bg-opacity-20 text-reset">No risk assigned</span>
                            @endif
                        </td>

                        <td>
                            @php
                                $temp = explode(' ',$row->created_at);
                            @endphp

                            <p> <strong>Date </strong> : {{ $temp[0] }} </p>
                            <p> <strong>Time </strong> : {{ $temp[1] }} </p>
                        </td>
                   </tr>
                @endforeach

                @foreach ($purge_logs as $row)
                   <tr id="{{ 'domain'.$row->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td><a title="More Details">{{ $row->empName }}</a></td>
                        <td>
                            <p> <strong>Department </strong> : {{ $row->department }} </p>
                            <p> <strong>Position </strong> : {{ $row->position }} </p>
                        </td>
                        <td> {{ $row->description }}</td>
                        <td>
                            <span class="badge bg-danger bg-opacity-20 text-danger">High</span>
                        </td>

                        <td>
                            <p> <strong>Date </strong> : {{ $row->dated }} </p>
                            <p> <strong>Time </strong> : {{ $row->timed }} </p>
                        </td>
                    </tr>
                @endforeach
              </tbody>
        </table>
    </div>

@endsection


@push('footer-script')

    <script type="text/javascript">

        $('#show-confirm').click(function(event) {

          var form =  $(this).closest("form");
          event.preventDefault();

          swal.fire({
            title: `Are You Sure You Want To Delete This Audit Trails?`,
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          })
          .then((result) => {
            if (result.isConfirmed) {
              form.submit();
            }
          });
      });

    </script>
@endpush
