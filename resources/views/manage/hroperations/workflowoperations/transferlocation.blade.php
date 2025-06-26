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



<div class="card mt-2 mb-2">
    <div class="row">
        <div class="col-12">
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
</div>

<div class="row mt-2">
    <div class="col-xl-2">
        <div class="card card-height-100">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Transfer</h4>
            </div>
            <div class="card-body m-navbar-menu">
                <ul class="m-menu-side navbar-nav">
                    @forelse($submenuItems as $item)
                    <li>
                        <a href="{{ route($item->route_define) }}" title="{{ $item->name }}">
                            <i class="ri-apps-2-line"></i> {{ $item->name }}
                        </a>
                    </li>
                    @empty
                    <li><em>No submodules found.</em></li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-xl-10">
        <div class="card p-2 mb-2">
            <div class="row">
                <div class="col-8">
                    <ol class="breadcrumb m-0 mt-1 flex-grow-1">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Transfer</a></li>
                        <li class="breadcrumb-item active">Location</li>
                    </ol>
                </div>
                <div class="col-2">
                    <p class="float-start mb-0 mt-1">Search for Department:</p>
                </div>
                <div class="col-2">
                    <select id="departmentSelect" name="department" class="form-select form-select-sm me-3" aria-label="Select department">
                        <option value="" selected>Select Department</option>
                        @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}">
                            {{ $dept->department_name }} ({{ $dept->department_code ?? strtoupper(substr($dept->department_name, 0, 3)) }})
                        </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <b class="float-start me-2">Activity List: </b>
                <ul class="nav nav-pills arrow-navtabs nav-success bg-light float-start" role="tablist">
                    @foreach ($activityLogs as $index => $log)
                    @php
                    $safeName = Str::slug($log->name); // Convert name to valid HTML ID
                    @endphp
                    <li class="nav-item" role="presentation">
                        <a
                            style="font-size:11px;min-width:105px;"
                            class="nav-link {{ $index === 0 ? 'active' : '' }}"
                            data-bs-toggle="tab"
                            href="#{{ $safeName }}"
                            role="tab"
                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                            <span class="d-none d-sm-block">{{ $log->name }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>

                <!-- <ul class="nav nav-pills arrow-navtabs nav-success bg-light  float-start" role="tablist">
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
                </ul> -->

                <div class="float-end">
                    <!--<button type="button" class="btn btn-info" data-bs-toggle="offcanvas" href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i> Fliters</button>-->
                    <button type="button" class="btn btn-sm btn-success waves-effect waves-light me-2 float-start" data-bs-toggle="offcanvas" href="#offcanvasExample"> Overall Save</button>

                </div>
            </div>
            <div class="card-body table-responsive p-1">
                <div class="tab-content mt-2">
                    @foreach ($activityLogs as $index => $log)
                    @php
                    $safeName = Str::slug($log->name);
                    $modules = json_decode($log->modules, true);
                    $types = json_decode($log->notification_type, true);
                    @endphp
                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="{{ $safeName }}" role="tabpanel">
                        <h6>{{ $log->name }}</h6>

                        @if($log->name === 'Initiation')
                        {{-- Initiation Table --}}
                        <table class="table text-center table-bordered dt-responsive nowrap table-striped align-middle equal-header" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="vertical-align: middle;" rowspan="2">Grade</th>
                                    <th colspan="2">Request By</th>

                                    <th colspan="5">Initial Grade Level</th>
                                    <th style="vertical-align: middle;" rowspan="2">Status</th>
                                    <th style="vertical-align: middle;" rowspan="2">Action<br>
                                        <a title="All Edit" href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a> |
                                        <a title="All Save" data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Reporting</th>
                                    <th>HOD</th>

                                    <th>S</th>
                                    <th>J</th>
                                    <th>M</th>
                                    <th>L</th>
                                    <th>MG</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grades as $grade)
                                <tr>
                                    <td>{{ $grade->grade_name ?? $grade->grade_name ?? 'N/A' }}</td> {{-- Adjust field name for grade display --}}

                                    {{-- Authorization checkboxes --}}
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="reporting_{{ $grade->id }}" value="reporting_{{ $grade->id }}">
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="hod_{{ $grade->id }}" value="hod_{{ $grade->id }}">
                                    </td>


                                    {{-- Initial Grade Level checkboxes --}}
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="level_s_{{ $grade->id }}" value="level_s_{{ $grade->id }}">
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="level_j_{{ $grade->id }}" value="level_j_{{ $grade->id }}">
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="level_m_{{ $grade->id }}" value="level_m_{{ $grade->id }}">
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="level_l_{{ $grade->id }}" value="level_l_{{ $grade->id }}">
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="level_mg_{{ $grade->id }}" value="level_mg_{{ $grade->id }}">
                                    </td>

                                    {{-- Status --}}
                                    <td>
                                        <span class="badge bg-success-subtle text-success">Active</span>
                                    </td>

                                    {{-- Action --}}
                                    <td>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                        |
                                        <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                        @elseif($log->name === 'Authorization')
                        {{-- Authorization Table --}}
                        <table class="table text-center table-bordered dt-responsive nowrap table-striped align-middle equal-header" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="vertical-align: middle;" rowspan="2">Grade</th>
                                    <th colspan="3">Authorization</th>

                                    <th colspan="5">Initial Grade Level</th>
                                    <th style="vertical-align: middle;" rowspan="2">Status</th>
                                    <th style="vertical-align: middle;" rowspan="2">Action<br>
                                        <a title="All Edit" href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a> |
                                        <a title="All Save" data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a>
                                    </th>
                                </tr>
                                <tr>
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
                                @foreach ($grades as $grade)
                                <tr>
                                    <td>{{ $grade->grade_name ?? $grade->grade_name ?? 'N/A' }}</td> {{-- Adjust field name for grade display --}}

                                    {{-- Authorization checkboxes --}}
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="reporting_{{ $grade->id }}" value="reporting_{{ $grade->id }}">
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="hod_{{ $grade->id }}" value="hod_{{ $grade->id }}">
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="hr_{{ $grade->id }}" value="hr_{{ $grade->id }}">
                                    </td>

                                    {{-- Initial Grade Level checkboxes --}}
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="level_s_{{ $grade->id }}" value="level_s_{{ $grade->id }}">
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="level_j_{{ $grade->id }}" value="level_j_{{ $grade->id }}">
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="level_m_{{ $grade->id }}" value="level_m_{{ $grade->id }}">
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="level_l_{{ $grade->id }}" value="level_l_{{ $grade->id }}">
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="level_mg_{{ $grade->id }}" value="level_mg_{{ $grade->id }}">
                                    </td>

                                    {{-- Status --}}
                                    <td>
                                        <span class="badge bg-success-subtle text-success">Active</span>
                                    </td>

                                    {{-- Action --}}
                                    <td>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                        |
                                        <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                        @else
                        <table class="table text-center table-bordered dt-responsive nowrap table-striped align-middle equal-header" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="vertical-align: middle;" rowspan="2">Grade</th>
                                    <th colspan="3">Authorization</th>

                                    <th colspan="5">Initial Grade Level</th>
                                    <th style="vertical-align: middle;" rowspan="2">Status</th>
                                    <th style="vertical-align: middle;" rowspan="2">Action<br>
                                        <a title="All Edit" href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a> |
                                        <a title="All Save" data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a>
                                    </th>
                                </tr>
                                <tr>
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
                                @foreach ($grades as $grade)
                                <tr>
                                    <td>{{ $grade->grade_name ?? $grade->grade_name ?? 'N/A' }}</td> {{-- Adjust field name for grade display --}}

                                    {{-- Authorization checkboxes --}}
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="reporting_{{ $grade->id }}" value="reporting_{{ $grade->id }}">
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="hod_{{ $grade->id }}" value="hod_{{ $grade->id }}">
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="hr_{{ $grade->id }}" value="hr_{{ $grade->id }}">
                                    </td>

                                    {{-- Initial Grade Level checkboxes --}}
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="level_s_{{ $grade->id }}" value="level_s_{{ $grade->id }}">
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="level_j_{{ $grade->id }}" value="level_j_{{ $grade->id }}">
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="level_m_{{ $grade->id }}" value="level_m_{{ $grade->id }}">
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="level_l_{{ $grade->id }}" value="level_l_{{ $grade->id }}">
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" id="level_mg_{{ $grade->id }}" value="level_mg_{{ $grade->id }}">
                                    </td>

                                    {{-- Status --}}
                                    <td>
                                        <span class="badge bg-success-subtle text-success">Active</span>
                                    </td>

                                    {{-- Action --}}
                                    <td>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#AddleavetypeModal" title="Edit"><i class="ri-edit-line"></i></a>
                                        |
                                        <a data-bs-toggle="modal" data-bs-target="#requestEditModal" href=""><i class="ri-save-line"></i></a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        @endif
                    </div>
                    @endforeach

                </div>


            </div>
        </div> <!-- .card-->
    </div> <!-- .col-->
</div>

@endsection