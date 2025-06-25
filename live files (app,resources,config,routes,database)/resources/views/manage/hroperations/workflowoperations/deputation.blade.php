@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#"><i class="las la-home"></i></a></li>
                    <li class="breadcrumb-item active">HR Operations</li>
                    <li class="breadcrumb-item active">Workflow</li>
                    <li class="breadcrumb-item active">Transfer</li>
                </ol>
            </div>
        </div>
    </div>
</div>

@include('manage.hroperations.hropeerations_widget_workflow')
<div class="row mt-2">
    <div class="col-xl-12">
        <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified float-start" role="tablist">
            @foreach($masterTransactionNames as $item)
            @php
            $route = $item->route_define;
            $isValidRoute = $route && $route !== '#' && $route !== '[]' && Route::has($route);
            @endphp
            @if($isValidRoute)
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ request()->routeIs($route) ? 'active' : '' }}"
                    href="{{ route($route) }}"
                    role="tab"
                    aria-selected="{{ request()->routeIs($route) ? 'true' : 'false' }}">
                    <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                    <span class="d-none d-sm-block">{{ $item->name }}</span>
                </a>
            </li>
            @endif
            @endforeach
        </ul>
    </div>
</div>

<div class="row mt-2">
    <div class="col-xl-2">
        <div class="card card-height-100">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Deputation</h4>
            </div><!-- end card header -->

            <div class="card-body m-navbar-menu">
                <ul class="m-menu-side navbar-nav">
                    <li><a href="" title="Location"><b><i class="ri-apps-2-line"></i> Location</b></a></li>
                    <li><a title="" href=""><i class="ri-apps-2-line"></i> Department</a></li>
                    <li><a title="" href=""><i class="ri-apps-2-line"></i> Reporting</a></li>
                </ul>
            </div>
        </div> <!-- .card-->
    </div> <!-- .col-->
    <div class="col-xl-10">
        <div class="card p-2 mb-2">
            <div class="row">
                <div class="col-7">
                    <ol class="breadcrumb m-0 mt-1 flex-grow-1">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Deputation</a></li>
                        <li class="breadcrumb-item active">Location</li>
                    </ol>
                </div>
                <div class="col-2">
                    <p class="float-start mb-0 mt-1">Search for Department:</p>
                </div>
                <div class="col-3">
                    <select id="departmentSelect" name="department" style="width:200px;float: left;" class="form-select form-select-sm me-3" aria-label="Select department">
                        <option selected="" value="">Information Technology (IT)</option>
                        <option value="1">
                            Administration (ADM)
                        </option>
                        <option value="2">
                            Breeding (BRD)
                        </option>
                        <option value="3">
                            Breeding Support (BS)
                        </option>
                        <option value="19">
                            Common (COM)
                        </option>
                        <option value="4">
                            Finance &amp; Account (FIN)
                        </option>
                        <option value="5">
                            Human Resource (HR)
                        </option>
                        <option value="6">
                            In Licensing &amp; Procurement (ILP)
                        </option>
                        <option value="7">
                            Information Technology (IT)
                        </option>
                        <option value="8">
                            Legal (LGL)
                        </option>
                        <option value="18">
                            Management (MGT)
                        </option>
                        <option value="10">
                            Marketing (MKT)
                        </option>
                        <option value="9">
                            MIS (MIS)
                        </option>
                        <option value="11">
                            Parent Seed (PSD)
                        </option>
                        <option value="12">
                            Processing (PRS)
                        </option>
                        <option value="13">
                            Production (PDN)
                        </option>
                        <option value="14">
                            Quality Assurance (QA)
                        </option>
                        <option value="15">
                            Sales (SLS)
                        </option>
                        <option value="16">
                            Seed Tech (SDT)
                        </option>
                        <option value="17">
                            Trialing &amp; PD (TPD)
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <b class="float-start me-2">Activity List: </b>
                <ul class="nav nav-pills arrow-navtabs nav-success bg-light  float-start" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a style="font-size:11px;min-width:105px;" class="nav-link active" data-bs-toggle="tab" href="#request" role="tab" aria-selected="true">
                            <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                            <span class="d-none d-sm-block">Request/Apply</span>
                        </a>
                    </li>
                    <li class="nav-item " role="presentation">
                        <a style="font-size:11px;min-width:105px;" class="nav-link " href="#approval" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">
                            <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                            <span class="d-none d-sm-block">Approval/Reject</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a style="font-size:11px;min-width:105px;" class="nav-link" data-bs-toggle="tab" href="#hr-approval" role="tab" aria-selected="false" tabindex="-1">
                            <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                            <span class="d-none d-sm-block">HR Approval</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a style="font-size:11px;min-width:105px;" class="nav-link" data-bs-toggle="tab" href="#cancel" role="tab" aria-selected="false" tabindex="-1">
                            <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                            <span class="d-none d-sm-block">Cancel</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a style="font-size:11px;min-width:105px;" class="nav-link" data-bs-toggle="tab" href="#delete" role="tab" aria-selected="false" tabindex="-1">
                            <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                            <span class="d-none d-sm-block">Delete</span>
                        </a>
                    </li>
                </ul>

                <div class="float-end">
                    <!--<button type="button" class="btn btn-info" data-bs-toggle="offcanvas" href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i> Fliters</button>-->
                    <button type="button" class="btn btn-sm btn-success waves-effect waves-light me-2 float-start" data-bs-toggle="offcanvas" href="#offcanvasExample"> Overall Save</button>

                </div>
            </div>
            <div class="card-body table-responsive p-1">
                <style>
                    table.equal-header th {
                        width: auto;
                        text-align: center;
                        vertical-align: middle;
                        white-space: nowrap;
                    }

                    table.equal-header th,
                    table.equal-header td {
                        padding: 10px;
                    }

                    table.equal-header {
                        width: 100%;
                        table-layout: fixed;
                        /* Ensures equal width distribution */
                    }

                    /* Optional: Responsive tweak for small screens */
                    @media (max-width: 768px) {
                        table.equal-header {
                            font-size: 12px;
                        }
                    }
                </style>
                <table class="table text-center table-bordered dt-responsive nowrap table-striped align-middle equal-header" style="width:100%">
                    <thead>
                        <tr>
                            <th style="vertical-align: middle;" rowspan="2">Grade</th>
                            <th colspan="2">Request By</th>
                            <th colspan="3">Authorization</th>
                            <th colspan="5">Grade Level</th>
                            <th style="vertical-align: middle;" rowspan="2">Status</th>
                            <th style="vertical-align: middle;" rowspan="2">Action<br>
                                <a title="All Edit" href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a> |
                                <a title="All Save" data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a>
                            </th>
                        </tr>
                        <tr>
                            <th>Reporting</th>
                            <th>HOD</th>
                            <th>Reporting</th>
                            <th>HOD</th>
                            <th>HR</th>
                            <th>S</th>
                            <th>J</th>
                            <th>M</th>
                            <th>L</th>
                            <th>MG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>S1</td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                | <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>S2</td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                | <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a></td>
                        </tr>
                        <tr>
                            <td>J1</td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                | <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a></td>
                        </tr>
                        <tr>
                            <td>J2</td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                | <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a></td>
                        </tr>
                        <tr>
                            <td>J3</td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                | <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a></td>
                        </tr>
                        <tr>
                            <td>J4</td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                | <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a></td>
                        </tr>
                        <tr>
                            <td>M1</td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                | <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a></td>
                        </tr>
                        <tr>
                            <td>M2</td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                | <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a></td>
                        </tr>
                        <tr>
                            <td>M3</td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                | <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a></td>
                        </tr>
                        <tr>
                            <td>M4</td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                | <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a></td>
                        </tr>
                        <tr>
                            <td>M5</td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                | <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a></td>
                        </tr>
                        <tr>
                            <td>L1</td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                | <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a></td>
                        </tr>
                        <tr>
                            <td>L2</td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                | <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a></td>
                        </tr>
                        <tr>
                            <td>L3</td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                | <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a></td>
                        </tr>
                        <tr>
                            <td>L4</td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                | <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a></td>
                        </tr>
                        <tr>
                            <td>L5</td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                | <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a></td>
                        </tr>
                        <tr>
                            <td>MG</td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td>
                                <div class="form-check text-center">
                                    <input class="form-check-input" type="checkbox" id="management" value="management">
                                </div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                | <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div> <!-- .card-->
    </div> <!-- .col-->
</div>

@endsection