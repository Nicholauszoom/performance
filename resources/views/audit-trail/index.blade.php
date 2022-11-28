@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-body">
            @include('layouts.alerts.message')

            <div class="row">
                <div class="col-12 col-sm-6 col-lg-12">
                    <div class="card">
                        <div class="card-header header-elements-sm-inline">
                            <h4 class="card-title">Audit Trail</h4>
                        </div>

                        <div class="card-body">
                            <h5>This is where all the audit trail will be implimented</h5>
                        </div>
                    </div>
                    {{-- end of card --}}
                </div>
                {{-- end of col --}}
            </div>
            {{-- end of row --}}

        </div>
    </section>
@endsection
