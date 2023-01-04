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
            <h5 class="mb-0">(HESLB)</h5>
        </div>
        <table class="table datatable-button-html5-columns">
            <thead>
                <tr>
                    <th width = "40px" >S/NO</th>
                    <th>F4indexno</th>
                    <th >Pf/Check No</th>
                    <th width = "200px">FullName</th>
                    <th width = "160px">AmountDeducted</th>
                    <th >OustandingBalance</th>
            </tr>
            </thead>
           <tbody>
            <?php 
            foreach($heslb as $key){
                $index = $key->form_four_index_no;
                $pf = "N/A";
                $name = $key->name;
                $amountdeducted= $key->paid;
                $out = $key->remained;
              ?>
                <tr>
                  <td width= "40px">{{ $key->SNo }}</td>
                  <td >{{ $index }}</td>
                  <td >{{ $pf }}</td>
                  <td width = "200px">{{ $name }}</td>
                  <td width = "160px" align="right">{{ number_format($amountdeducted,2) }}</td>
                  <td align="right">{{ number_format($out,2) }}</td>
               </tr>
       <?php } ?>
           </tbody>
        </table>
    </div>
    <!-- /column selectors -->
@endsection
