@extends('layouts.vertical', ['title' => 'Audit-trail'])

@push('head-css')

@endpush

@push('head-script')
    <script src="{{ asset('tasset/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('tasset/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('tasset/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('page-header')
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                Setting - <span class="fw-normal">Audit Trail</span>
            </h4>

            <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>
    </div>

    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="index.html" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="#" class="breadcrumb-item">Setting</a>
                <span class="breadcrumb-item active">Audit Trail</span>
            </div>

            <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>
    </div>
@endsection

@section('content')

<!-- Basic datatable -->
<div class="card">
    <div class="card-header border-0">
        <h5 class="mb-0 text-muted">Audit Trail</h5>
    </div>


    <table class="table datatable-basic">
        <thead>
            <tr>
                <th>User ID</th>
                <th>User Name</th>
                <th>User Email</th>
                <th>Action</th>
                <th>Risk</th>
                <th>Time performed</th>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                <td>47</td>
                <td><a href="#">Douglas Fortunatus</a></td>
                <td>fortunatusdouglas@gmail.com</td>
                <td>Created a user</td>
                <td><span class="badge bg-success bg-opacity-10 text-success">High</span></td>
                <td>23:10:00 12/06/2022</td>
            </tr>


            <tr>
                <td>Jackelyn</td>
                <td>Weible</td>
                <td><a href="#">Airline Transport Pilot</a></td>
                <td>3 Oct 1981</td>
                <td><span class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span></td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-list"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-pdf me-2"></i>
                                    Export to .pdf
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-xls me-2"></i>
                                    Export to .csv
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-doc me-2"></i>
                                    Export to .doc
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Aura</td>
                <td>Hard</td>
                <td>Business Services Sales Representative</td>
                <td>19 Apr 1969</td>
                <td><span class="badge bg-danger bg-opacity-10 text-danger">Suspended</span></td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-list"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-pdf me-2"></i>
                                    Export to .pdf
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-xls me-2"></i>
                                    Export to .csv
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-doc me-2"></i>
                                    Export to .doc
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Nathalie</td>
                <td><a href="#">Pretty</a></td>
                <td>Drywall Stripper</td>
                <td>13 Dec 1977</td>
                <td><span class="badge bg-info bg-opacity-10 text-info">Pending</span></td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-list"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-pdf me-2"></i>
                                    Export to .pdf
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-xls me-2"></i>
                                    Export to .csv
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-doc me-2"></i>
                                    Export to .doc
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Sharan</td>
                <td>Leland</td>
                <td>Aviation Tactical Readiness Officer</td>
                <td>30 Dec 1991</td>
                <td><span class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span></td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-list"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-pdf me-2"></i>
                                    Export to .pdf
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-xls me-2"></i>
                                    Export to .csv
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-doc me-2"></i>
                                    Export to .doc
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Maxine</td>
                <td><a href="#">Woldt</a></td>
                <td><a href="#">Business Services Sales Representative</a></td>
                <td>17 Oct 1987</td>
                <td><span class="badge bg-info bg-opacity-10 text-info">Pending</span></td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-list"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-pdf me-2"></i>
                                    Export to .pdf
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-xls me-2"></i>
                                    Export to .csv
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-doc me-2"></i>
                                    Export to .doc
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Sylvia</td>
                <td><a href="#">Mcgaughy</a></td>
                <td>Hemodialysis Technician</td>
                <td>11 Nov 1983</td>
                <td><span class="badge bg-danger bg-opacity-10 text-danger">Suspended</span></td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-list"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-pdf me-2"></i>
                                    Export to .pdf
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-xls me-2"></i>
                                    Export to .csv
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-doc me-2"></i>
                                    Export to .doc
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Lizzee</td>
                <td><a href="#">Goodlow</a></td>
                <td>Technical Services Librarian</td>
                <td>1 Nov 1961</td>
                <td><span class="badge bg-danger bg-opacity-10 text-danger">Suspended</span></td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-list"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-pdf me-2"></i>
                                    Export to .pdf
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-xls me-2"></i>
                                    Export to .csv
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-doc me-2"></i>
                                    Export to .doc
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Kennedy</td>
                <td>Haley</td>
                <td>Senior Marketing Designer</td>
                <td>18 Dec 1960</td>
                <td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-list"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-pdf me-2"></i>
                                    Export to .pdf
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-xls me-2"></i>
                                    Export to .csv
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-doc me-2"></i>
                                    Export to .doc
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Chantal</td>
                <td><a href="#">Nailor</a></td>
                <td>Technical Services Librarian</td>
                <td>10 Jan 1980</td>
                <td><span class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span></td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-list"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-pdf me-2"></i>
                                    Export to .pdf
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-xls me-2"></i>
                                    Export to .csv
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-doc me-2"></i>
                                    Export to .doc
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Delma</td>
                <td>Bonds</td>
                <td>Lead Brand Manager</td>
                <td>21 Dec 1968</td>
                <td><span class="badge bg-info bg-opacity-10 text-info">Pending</span></td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-list"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-pdf me-2"></i>
                                    Export to .pdf
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-xls me-2"></i>
                                    Export to .csv
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-doc me-2"></i>
                                    Export to .doc
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Roland</td>
                <td>Salmos</td>
                <td><a href="#">Senior Program Developer</a></td>
                <td>5 Jun 1986</td>
                <td><span class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span></td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-list"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-pdf me-2"></i>
                                    Export to .pdf
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-xls me-2"></i>
                                    Export to .csv
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-doc me-2"></i>
                                    Export to .doc
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Coy</td>
                <td>Wollard</td>
                <td>Customer Service Operator</td>
                <td>12 Oct 1982</td>
                <td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-list"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-pdf me-2"></i>
                                    Export to .pdf
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-xls me-2"></i>
                                    Export to .csv
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-doc me-2"></i>
                                    Export to .doc
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Maxwell</td>
                <td>Maben</td>
                <td>Regional Representative</td>
                <td>25 Feb 1988</td>
                <td><span class="badge bg-danger bg-opacity-10 text-danger">Suspended</span></td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-list"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-pdf me-2"></i>
                                    Export to .pdf
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-xls me-2"></i>
                                    Export to .csv
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-doc me-2"></i>
                                    Export to .doc
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Cicely</td>
                <td>Sigler</td>
                <td><a href="#">Senior Research Officer</a></td>
                <td>15 Mar 1960</td>
                <td><span class="badge bg-info bg-opacity-10 text-info">Pending</span></td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <div class="dropdown">
                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                <i class="ph-list"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-pdf me-2"></i>
                                    Export to .pdf
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-xls me-2"></i>
                                    Export to .csv
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-file-doc me-2"></i>
                                    Export to .doc
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<!-- /basic datatable -->

@endsection


