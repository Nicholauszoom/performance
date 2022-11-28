<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <title> System Name</title>

    {{-- Global stylesheets --}}
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">

    <link href="{{asset('global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets2/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets2/css/datepicker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/dataTables.dateTime.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/dataTables.dateTime.min.css')}}" rel="stylesheet" type="text/css">
    {{-- /global stylesheets --}}

    <link href="{{ asset('assets2/css/toastr.min.css') }}" rel="stylesheet" type="text/css">

    {{-- Core JS files --}}

    <script src="{{asset('global_assets/js/main/jquery.min.js')}}"></script>
	<script src="{{asset('global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/visualization/echarts/echarts.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/visualization/charts-js/charts.js')}}"></script>

	{{-- /core JS files --}}


    <script src="{{url('assets/js/jquery.bootstrap-growl.min.js')}}"></script>


    <script>
        $(function(){

            @if(Session::has('success'))
                $.bootstrapGrowl('{{ Session::get("success") }}',{
                    type: 'success',
                    delay: 4000,
                });
            @endif

            @if(Session::has('error'))
                $.bootstrapGrowl('{{ Session::get("error") }}',{
                    type: 'danger',
                    delay: 4000,
                });
            @endif

            @if(Session::has('info'))
                $.bootstrapGrowl('{{ Session::get("info") }}',{
                    type: 'info',
                    delay: 4000,
                });
            @endif

            @if(Session::has('warning'))
                $.bootstrapGrowl('{{ Session::get("warning") }}',{
                    type: 'warning',
                    delay: 4000,
                });
            @endif
        });
    </script>



    <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>

    <!--  The following JS library files are loaded to use Copy CSV Excel Print Options -->
    <script src="{{ asset('plugins/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/table/datatable/button-ext/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/table/datatable/button-ext/buttons.print.min.js') }}"></script>

    <!-- The following JS library files are loaded to use PDF Options-->
    <script src="{{ asset('plugins/table/datatable/button-ext/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/table/datatable/button-ext/vfs_fonts.js') }}"></script>
    <script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>

    <script>
        $(document).ready(function(){
            /*
                * Multiple drop down select
            */
            $('.m-b').select2({ width: '100%', });
        });
    </script>
    <!-- Stack array for including inline js or scripts -->

    @stack('plugin-scripts')

    @stack('custom-scripts')


    <!-- Stack array for including inline css or head elements -->
    @stack('plugin-styles')

    <script type="text/javascript" >
        function CheckAll(obj){
            var row = obj.parentNode.parentNode;
            var inputs = row.getElementsByTagName("input");

            for(var i = 0; i < inputs.length; i++){
                if(inputs[i].type == "checkbox") {
                    inputs[i].checked = obj.checked;
                }

            }
        }
    </script>

    <script>
        $(document).ready(function(){
            $('#select-all').click( function()  {
                $('input[type="checkbox"]').prop('checked', this.checked);
            })
        });
    </script>

</head>
