@extends('layouts.vertical', ['title' => 'Organisation'])

@push('head-script')
<script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>

    @endpush

    @push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    @endpush

@section('content')
<div class="row">
{{-- <div class="col-md-6"> --}}
  <h3>Organization structure </h3>

<div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
  <div class="card-header">

  <h5>Position Organization structure</h5>
  </div>
  <table class="table datatable-basic">
      <thead>
          <tr>
              <th>S/N</th>
              <th>Code</th>
              <th>Name</th>
              <th>Status</th>
              <th class="text-center">Actions</th>
              {{-- <th>action</th> --}}
          </tr>
      </thead>
      <tbody>
          <tr>
              <td></td>
              <td></td>
              <td></td>
              <td><span class="badge bg-success bg-opacity-10 text-success"></span></td>
              <td></td>
              <td></td>

          </tr>


      </tbody>
  </table>
</div>
  <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
    <div class="card-header">
<h5>Department OrganizationStructure</h5>
</div>
  <table class="table datatable-basic">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Code</th>
            <th>Name</th>
            <th>Status</th>
            <th class="text-center">Actions</th>
            {{-- <th>action</th> --}}
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><span class="badge bg-success bg-opacity-10 text-success"></span></td>
            <td></td>
            <td></td>
        </tr>


    </tbody>
</table>
  </div>
</div>
 @endsection
