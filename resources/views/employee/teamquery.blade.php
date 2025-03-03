@include('employee.header')

<body class="mini-sidebar">
    @include('employee.sidebar')

    <div class="loader" style="display: none;">
        <div class="spinner" style="display: none;">
            <img src="./SplashDash_files/loader.gif" alt="" />
        </div>
    </div>
    <!-- Main Body -->
    <div class="page-wrapper">
        <!-- Header Start -->
        @include('employee.head')
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="{{route('dashboard')}}"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">My Team - Query</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                @include('employee.menuteam')
                <!-- Revanue Status Start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="row">
                            @if($isReviewer)
                            <div class="flex-shrink-0" style="float: right;">
                                <form method="GET">
                                    @csrf
                                    <div class="form-check form-switch form-switch-right form-switch-md">
                                        <label for="hod-view" class="form-label text-muted mt-1 mr-1 ml-2" style="float: right;">HOD/Reviewer</label>
                                        <input class="form-check-input" type="checkbox" name="hod_view" id="hod-view" />
                                    </div>
                                </form>
                            </div>
                            @endif
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h5><b>Team: Queries</b></h5>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table class="table" id="teamQueryTable">
                                            <thead class="thead-light" style="background-color: #f1f1f1;">
                                                <tr style="background-color: #ddd;">
                                                    <th>SN</th>
                                                    <th>Employee Details</th>
                                                    <th>Query Req. Date</th>
                                                    <th>Query Details</th>
                                                    <th>Status</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody id="teamQueryTableBody"></tbody>
                                        </table>
                                        <p id="noEmployeeQueriesMessage" class="text-center no-record-found" style="display: none;">No queries found for this employee.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('employee.footerbottom')
            </div>
        </div>
    </div>

    <!--Approval Message-->
    <div class="modal fade show" id="querypopup" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle3">Query Details</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><b>Department - Admin</b></p>
                    <p><b>Subject - ----</b></p>
                    <p></p>
                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even</p>
                    <br />
                    <p>Raise Date:15 May 2024</p>
                    <table class="table table-border mt-2">
                        <thead>
                            <tr>
                                <td>Level 1</td>
                                <td>Level 2</td>
                                <td>Level 3</td>
                            </tr>
                        </thead>
                        <tr>
                            <td><b>Done</b></td>
                            <td><b>Open</b></td>
                            <td><b>Pending</b></td>
                        </tr>

                        <tr></tr>
                        <tr>
                            <td>16 May</td>
                            <td>19 May</td>
                            <td>Pending</td>
                        </tr>

                        <tr></tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal query details -->
    <div id="viewqueryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewqueryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewqueryModalLabel">Query Details</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="query-request-box">
                        <div class="query-req-section">
                            <div class="float-start w-100 pb-2 mb-2" style="border-bottom: 1px solid #ddd;">
                                <span class="float-start"><b>Dept.: </b><span id="modalDept"></span></span>
                                <span class="float-end"><b>Sub: </b><span id="modalSub"></span></span>
                            </div>
                            <div class="mb-2"><p id="modalQueryDetails"></p></div>
                            <div class="w-100" style="font-size: 11px;">
                                <span class="me-3"><b>Raise on:</b> <span id="modalRaiseDate"></span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Level 1 -->
                    <div class="level-box-1 mb-3">
                        <div class="float-start w-100 pb-1 mb-1" style="border-bottom: 1px solid #ddd;">
                            <span class="float-start"><b>Level 1</b></span>
                        </div>
                        <div class="mb-2">
                            <span>
                                <small><b>Status:</b> <span id="level1Status"></span></small>
                            </span>
                            <span class="float-end">
                                <small><span id="level1Date"></span></small>
                            </span>
                            <p><b>Remarks:</b> <span id="level1Remarks"></span></p>
                        </div>
                    </div>

                    <!-- Level 2 -->
                    <div class="level-box-2 mb-3">
                        <div class="float-start w-100 pb-1 mb-1" style="border-bottom: 1px solid #ddd;">
                            <span class="float-start"><b>Level 2</b></span>
                        </div>
                        <div class="mb-2">
                            <span>
                                <small><b>Status:</b> <span id="level2Status"></span></small>
                            </span>
                            <span class="float-end">
                                <small><span id="level2Date"></span></small>
                            </span>
                            <p><b>Remarks:</b> <span id="level2Remarks"></span></p>
                        </div>
                    </div>

                    <!-- Level 3 -->
                    <div class="level-box-3 mb-3">
                        <div class="float-start w-100 pb-1 mb-1" style="border-bottom: 1px solid #ddd;">
                            <span class="float-start"><b>Level 3</b></span>
                        </div>
                        <div class="mb-2">
                            <span>
                                <small><b>Status:</b> <span id="level3Status"></span></small>
                            </span>
                            <span class="float-end">
                                <small><span id="level3Date"></span></small>
                            </span>
                            <p><b>Remarks:</b> <span id="level3Remarks"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for taking action -->
    <div id="actionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="actionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="actionModalLabel">Query Action</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="actionMessage" class="alert" style="display: none;">
                        <!-- This will display the message from the server -->
                    </div>
                    <form id="queryActionForm">
                        @csrf
                        <!-- Form Fields -->
                        <div class="form-group">
                            <label for="querySubject">Subject</label>
                            <input type="text" id="querySubject" class="form-control" name="querySubject" readonly />
                        </div>
                        <div class="form-group">
                            <label for="querySubjectValue">Subject Details</label>
                            <input type="text" id="querySubjectValue" class="form-control" name="querySubjectValue" readonly />
                        </div>
                        <div class="form-group">
                            <label for="queryName">Employee Name</label>
                            <input type="text" id="queryName" class="form-control" name="queryName" readonly />
                        </div>
                        <div class="form-group">
                            <label for="queryDepartment">Query Department</label>
                            <input type="text" id="queryDepartment" class="form-control" name="queryDepartment" readonly />
                        </div>
                        <div class="form-group s-opt">
                            <label for="status">Status</label>
                            <select id="status" class="select2 form-control select-opt" name="status">
                                <option value="0">Open</option>
                                <option value="1">In Progress</option>
                                <option value="2">Reply</option>
                                <option value="4">Esclose</option>
                                <option value="3">Closed</option>
                            </select>
                            <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="reply">Reply</label>
                            <textarea id="reply" class="form-control" name="reply" rows="3"></textarea>
                        </div>
                        <div class="form-group s-opt">
                            <label for="forwardTo">Forward To</label>
                            <select id="forwardTo" class="select2 form-control select-opt" name="forwardTo">
                                <option value="0">Select a Forward To</option>
                                <!-- Default option with value 0 -->
                            </select>
                            <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="forwardReason">Forward Reason</label>
                            <textarea id="forwardReason" class="form-control" name="forwardReason" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Action</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- approval modal  -->
    <div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approvalModalLabel">Approval Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="approvalMessage" class="alert" style="display: none;"></div>

                    <!-- Form to approve or reject -->
                    <form action="{{ route('approve.request.team.assest') }}" method="POST" id="approvalForm">
                        @csrf
                        <input type="hidden" name="request_id" id="request_id" />
                        <input type="hidden" name="employee_id" id="employee_id" />

                        <div class="mb-3">
                            <label for="employee_name" class="form-label">Employee Name</label>
                            <input type="text" class="form-control" id="employee_name" readonly />
                        </div>

                        <div class="mb-3">
                            <label for="asset_id" class="form-label">Asset ID</label>
                            <input type="text" class="form-control" id="asset_id" readonly />
                        </div>

                        <div class="mb-3">
                            <label for="req_amt" class="form-label">Request Amount</label>
                            <input type="text" class="form-control" id="req_amt" readonly />
                        </div>

                        <div class="mb-3 form-group s-opt">
                            <label for="approval_status" class="form-label">Approval Status</label>
                            <select class="select2 form-control select-opt" id="approval_status" name="approval_status" required>
                                <option value="">Select Status</option>
                                <option value="1">Approved</option>
                                <option value="0">Rejected</option>
                            </select>
                            <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </div>

                        <div class="mb-3">
                            <label for="remark" class="form-label">Remark</label>
                            <textarea class="form-control" id="remark" name="remark" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="reg_Date" class="form-label">Reg Date</label>
                            <input type="date" class="form-control" id="reg_Date" name="reg_Date" required readonly />
                        </div>
                        <input type="hidden" id="employeeId" name="employeeId" />
                        <input type="hidden" id="assestsid" name="assestsid" />

                        <div class="mb-3">
                            <label for="approval_date" class="form-label">Approval Date</label>
                            <input type="date" class="form-control" id="approval_date" name="approval_date" required />
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade show" id="billdetails" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle3">Details of Assets</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <img class="w-100" src="./images/excel-invoice.jpg" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalLabel">File Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Dynamically load the content here -->
                    <div id="filePreviewContainer">
                        <!-- File content will be dynamically loaded here (image or other file type) -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for PDF preview with pagination -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">PDF Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- PDF carousel -->

                    <div id="pdfCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" id="pdfCarouselContent"></div>

                        <!-- Custom Previous Button -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#pdfCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>

                        <!-- Custom Next Button -->
                        <button class="carousel-control-next" type="button" data-bs-target="#pdfCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('employee.footer');
    <script>
        const employeeId = {{ Auth::user()->EmployeeID }};
        const repo_employeeId = {{ Auth::user()->EmployeeID }};
        const deptQueryUrl = "{{ route('employee.deptqueriesub') }}";
        const queryactionUrl = "{{ route("employee.query.action") }}";
        const getqueriesUrl = "{{ route("employee.queries.repo") }}";
        $(".code-switcher").click(function() {
        	$("#reportingsection").toggle();
        	$("#hodreviwersection").toggle();
        });
    </script>
    <script>
        function getTeamQueryLists() {
            var isHodView = $("#hod-view").is(":checked");
            var valueToSend = isHodView ? "1" : "0";
            $.ajax({
                url: getqueriesUrl,
                method: "GET",
                data: { hod_view: valueToSend },
                beforeSend: function () {
                   startLoader();
                },
                success: function (response) {
                    console.log(response);
                    if (response.length > 0) {
                        if ($.fn.DataTable.isDataTable("#teamQueryTable")) {
                            $("#teamQueryTable").DataTable().clear().destroy(); 
                        }
                        $("#teamQueryTableBody").empty(); 

                        $.each(response, function (index, query) {
                            var actionButton = "";
                            let queryDate = query.QueryDT ? new Date(query.QueryDT) : null;
                            let formattedDate = queryDate ? queryDate.toLocaleDateString("en-GB", { day: "2-digit", month: "2-digit", year: "numeric" }) : "N/A";

                            var showActionButton = [
                                query.Level_1ID,
                                query.Level_1QFwdEmpId,
                                query.Level_1QFwdEmpId2,
                                query.Level_1QFwdEmpId3,
                                query.Level_2ID,
                                query.Level_2QFwdEmpId,
                                query.Level_2QFwdEmpId2,
                                query.Level_2QFwdEmpId3,
                                query.Level_3ID,
                                query.Level_3QFwdEmpId,
                                query.Level_3QFwdEmpId2,
                                query.Level_3QFwdEmpId3,
                            ].includes(employeeId);

                            if (showActionButton) {
                                actionButton = `<button class="btn btn-primary take-action-btn" data-query-id="${query.QueryId}" data-department-id="${query.QToDepartmentId}">Action</button>`;
                            }

                            var statusMap = {
                                0: "<b class='success'>Open</b>",
                                1: "<b class='warning'>In Progress</b>",
                                2: "<b class='info'>Reply</b>",
                                3: "<b class='default'>Closed</b>",
                                4: "<b class='danger'>Forward</b>",
                            };

                            var row = `
                                    <tr>
                                        <td>${index + 1}.</td>
                                        <td>${(employeeId == query.HodId || employeeId == query.RepMgrId) && query.HideYesNo == "Y" ? "-" : `<strong></strong> ${query.Fname} ${query.Lname} ${query.Sname}<br>`}</td>
                                        <td>${formattedDate}</td>
                                        <td>
                                            <strong>Subject:</strong> ${query.QuerySubject}<br>
                                            <strong>Subject Details:</strong> ${query.QueryValue}<br>
                                            <strong>Query to:</strong> ${query.department_name}<br>
                                        </td>
                                        <td>${statusMap[query.QStatus] || "N/A"}</td>
                                        <td>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#viewqueryModal" class="viewquery"
                                                data-employee-id="${query.EmployeeID}"
                                                data-query-subject="${query.QueryValue}"
                                                data-query-depsubject="${query.DeptQSubject}"
                                                data-query-dt="${query.QueryDT}"
                                                data-level-1-status="${query.Level_1QStatus}"
                                                data-level-1-reply="${query.Level_1ReplyAns}"
                                                data-level-1-date="${query.Level_1QToDT}"
                                                data-level-2-status="${query.Level_2QStatus}"
                                                data-level-2-reply="${query.Level_2ReplyAns}"
                                                data-level-2-date="${query.Level_2QToDT}"
                                                data-level-3-status="${query.Level_3QStatus}"
                                                data-level-3-date="${query.Level_3QToDT}"
                                                data-level-3-reply="${query.Level_3ReplyAns}"
                                                data-department-name="${query.department_name}">View</a>
                                        </td>
                                    </tr>
                                `;

                            $("#teamQueryTableBody").append(row);
                        });

                        $("#teamQueryTable").DataTable({
                            responsive: true,
                            paging: true,
                            searching: true,
                            ordering: true,
                            autoWidth: false,
                            lengthMenu: [
                                [5, 10, 25, 50, -1],
                                [5, 10, 25, 50, "All"],
                            ],
                        });

                        $(".take-action-btn").on("click", function () {
                            var queryId = $(this).data("query-id");
                            var query = response.find((q) => q.QueryId == queryId);

                            if (query.Level_1QStatus === 4 || query.Level_2QStatus === 4 || query.Level_3QStatus === 4 || query.Mngmt_QStatus === 4) {
                                $("#status").val("");
                            } else {
                                if (query.Level_1QStatus) {
                                    $("#status").val(query.Level_1QStatus);
                                } else if (query.Level_2QStatus) {
                                    $("#status").val(query.Level_2QStatus);
                                } else if (query.Level_3QStatus) {
                                    $("#status").val(query.Level_3QStatus);
                                } else if (query.Mngmt_QStatus) {
                                    $("#status").val(query.Mngmt_QStatus);
                                }
                            }

                            $("#querySubject").val(query.QuerySubject);
                            $("#querySubjectValue").val(query.QueryValue);
                            $("#queryName").val(query.Fname + " " + query.Sname + " " + query.Lname);
                            $("#queryDepartment").val(query.department_name);

                            toggleForwardSection($("#status").val());
                            if (query.Level_1QStatus === 3) {
                                $("#reply").val(query.Level_1ReplyAns).prop("readonly", true);
                            } else if (query.Level_2QStatus === 3) {
                                $("#reply").val(query.Level_2ReplyAns).prop("readonly", true);
                            } else if (query.Level_3QStatus === 3) {
                                $("#reply").val(query.Level_3ReplyAns).prop("readonly", true);
                            } else {
                                $("#reply").prop("readonly", false);
                            }

                            $("#queryActionForm").data("query-id", queryId);
                            $("#actionModal").modal("show");
                        });
                    } else {
                        $("#noEmployeeQueriesMessage").show();
                        $("#employeeQueryTab").hide();
                        $("#employeeQuerySection").hide();
                    }
                },
                error: function () {
                    console.log("Error fetching employee-specific queries.");
                },
                complete: function () {
                    endLoader();
                }
            });
        }
        function startLoader() {
             let loaderHtml = `<div id="loader" style="position:fixed;top:50%;left:50%;transform:translate(-50%, -50%);display:flex;align-items:center;justify-content:center;z-index:9999;"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>`;
            $("body").append(loaderHtml);
        }
        function endLoader() {
            $("#loader").remove();
        }
        $(document).ready(function () {
            getTeamQueryLists();
            $("#hod-view").on("change", function () {
                getTeamQueryLists();
            });
        });
    </script>
    <script src="{{ asset('../js/dynamicjs/team.js/') }}" defer></script>
</body>
