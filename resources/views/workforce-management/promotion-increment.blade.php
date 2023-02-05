@extends('layouts.vertical', ['title' => 'Promotion/Increment'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('page-header')
  @include('layouts.shared.page-header')
@endsection

@section('content')

<div class="card">
    <div class="card-header border-0">
        <div class="">
            <div class="row">
                <div class="col-md-7">
                    <h6 class="mb-0 text-muted text-start">Promotion| Increment</h6>
                </div>
                <div class="col-md-5">
           
                        {{-- start of increment salary button --}}
                        @can('add-increment')
                        <a href="{{ route('flex.addIncrement') }}" class="btn btn-perfrom float-end text-end mx-1 ">
                        <i class="ph-plus me-2"></i> Increment Salary
                        </a>
                        @endcan
                        {{-- / --}}

                        {{--  start of perform promotion button --}}
                        @can('add-promotion')
                        <a href="{{ route('flex.addPromotion') }}" class="btn btn-perfrom float-end mx-1">
                            <i class="ph-plus me-2"></i> Peform Promotion
                        </a>
                        @endcan
                        {{-- / --}}
                </div>
            </div>
    


        </div>
    </div>
    @if (session('msg'))
    <div class="alert alert-success col-md-8 mx-auto" role="alert">
    {{ session('msg') }}
    </div>
    @endif


    <table class="table table-striped table-bordered datatable-basic">
        <thead>
            <tr>
                <th>SN</th>
                <th>Employee Name</th>
                <th>Position</th>
                <th>Old Salary</th>
                <th>New Salary</th>
                <th>Activity</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
               @foreach ($promotions as $item)
            <tr>
            <td>{{$i++}}</td>
             <td>{{ $item->employee->fname}} {{ $item->employee->mname}} {{ $item->employee->lname}}</td>
             <td>{{ $item->position->name}}</td>
             <td>{{ number_format($item->oldSalary,2)}} </td>
             <td>{{ number_format($item->newSalary,2)}} </td>
             <td>
                @if($item->action=="incremented")
                    <span class="badge bg-success bg-opacity-10 text-success">{{ $item->action}}</span>
                    <br>
                @else
                    <span class="badge bg-success bg-opacity-20 text-success">{{ $item->action}}</span>

                @endif
            </td>
            <td>
                @if($level)
                @if($item->status!='Successful')
                @if ($item->status!=$check)
                @can('confirm-termination')
                <small class="text-gray text-center"> Please Approve {{ $item->action =='promoted' ? 'Promotion':'Incremention' }} !</small>
                <br>
                {{-- start of termination confirm button --}}
                <a  href="{{ url('flex/approve-promotion/'.$item->id) }}"  title="Confirm Promotion">
                    <button type="button" class="btn btn-success btn-xs" > <i class="ph-check"></i> Confirm</button>
                </a>
                {{-- / --}}

                {{-- start of termination confirm button --}}
                <a  href="{{ url('flex/view-termination/'.$item->id) }}"  title="Cancel Termination">
                    <button type="button" class="btn btn-danger btn-xs" ><i class="ph-trash"></i> Cancel </button>
                </a>
                {{-- / --}}
                @endcan
                @endif
                @endif
                @endif
            </td>
    
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection



@push('footer-script')

@endpush