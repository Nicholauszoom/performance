@extends('layouts.vertical', ['title' => 'non-statutory'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')
    <!-- Basic datatable -->
    <div class="card">
        <ul class="nav nav-tabs nav-tabs-underline nav-justified mb-3" id="tabs-target-right" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ url('/flex/financial_group')}}" class="nav-link "
                    aria-selected="false" role="tab" tabindex="-1">
                    <i class="ph-at me-2"></i>
                    Financial Groups
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ url('/flex/allowance_overtime')}}" class="nav-link" aria-selected="false" role="tab"
                    tabindex="-1">
                    <i class="ph-list me-2"></i>
                    Overtime
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ url('/flex/allowance')}}" class="nav-link" 
                    aria-selected="false" role="tab" tabindex="-1">
                    <i class="ph-at me-2"></i>
                    Allowance
                </a>
            </li>
        
          
            <li class="nav-item" role="presentation">
                <a href="{{ url('/flex/statutory_deductions')}}" class="nav-link "
                    aria-selected="false" role="tab" tabindex="-1">
                    <i class="ph-at me-2"></i>
                    Statutory Deductions
                </a>
            </li>
            <li class="nav-item" role="presentation">
              <a href="{{ url('/flex/non_statutory_deductions')}}" class="nav-link active show"
                  aria-selected="false" role="tab" tabindex="-1">
                  <i class="ph-at me-2"></i>
                  Non Statutory Deductions
              </a>
          </li>
         
        </ul>
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="mb-0">Deduction</h5>
                <button type="button" class="btn btn-perfrom" data-bs-toggle="modal" data-bs-target="#save_deduction">
                    <i class="ph-plus me-2"></i> Deduction

                </button>
            </div>

        </div>
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th class="text-center">Action</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deduction as $row)
                    <tr id="domain {{ $row->id }}">
                        <td width="1px">{{ $row->SNo }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->amount }}</td>
                        <td class="options-width">
                            <a href="{{ url('') }}/flex/updateBank/?category=2&id=".base64_encode{{ $row->id }}
                                <button type="button" class="btn btn-info btn-xs"><i
                                    class="fa fa-info-circle"></i></button> </a>
                            <a href="javascript:void(0)" onclick="deleteBank(<?php echo $row->id; ?>)" title="Delete"
                                class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i
                                        class="fa fa-trash-o"></i></button> </a>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- /basic datatable -->
@endsection

@section('modal')
    @include('setting.deduction.add_deduction')
@endsection
