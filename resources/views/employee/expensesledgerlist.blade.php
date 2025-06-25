@include('employee.header')

<body class="mini-sidebar">
  @include('employee.sidebar')

  <div class="loader" style="display: none;">
    <div class="spinner" style="display: none;">
      <img src="./SplashDash_files/loader.gif" alt="">
    </div>
  </div>
  <!-- Main Body -->
  <div class="page-wrapper">
    <!-- Header Start -->
    @include('employee.head')
    <!-- Sidebar Start -->
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
                  <li class="breadcrumb-link active">Ledger List</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-3 mb-2">
            <div class="card mb-1 p-3" style="text-align: center;">
              <div class="card-body d-flex align-items-center p-0">
                <div class="flex-grow-1 top-h-menu">
                  <p class="mb-0"><b>Total Uploads </b> </p>
                  <b style="font-size:15px;">{{$pdfCount}}</b>

                </div>
              </div>
            </div>
          </div>
          <div class="col-3 mb-2">
            <div class="card mb-1 p-3" style="text-align: center;">
              <div class="card-body d-flex align-items-center p-0">
                <div class="flex-grow-1 top-h-menu">
                  <p class="mb-0"><b>Total Employee Active </b> </p>
                      <b class="text-danger" style="font-size:15px;">{{ $activeCount - $separationCount }}</b>

                </div>
              </div>
            </div>
          </div>
          <div class="col-3 mb-2">
            <div class="card mb-1 p-3" style="text-align: center;">
              <div class="card-body d-flex align-items-center p-0">
                <div class="flex-grow-1 top-h-menu">
                  <p class="mb-0"><b>Active Employees (Resigned)</b> </p>
                  <b class="text-danger" style="font-size:15px;">{{$separationCount}}</b>

                </div>
              </div>
            </div>
          </div>
          <div class="col-3 mb-2">
            <div class="card mb-1 p-3" style="text-align: center;">
              <div class="card-body d-flex align-items-center p-0">
                <div class="flex-grow-1 top-h-menu">
                  <p class="mb-0"><b>Total Employee Deactive </b> </p>
                  <b class="text-primary" style="font-size:15px;">{{$inactiveCount}}</b>

                </div>
              </div>
            </div>
          </div>
          <div class="col-3 mb-2">
            <div class="card mb-1 p-3" style="text-align: center;">
              <div class="card-body d-flex align-items-center p-0">
                <div class="flex-grow-1 top-h-menu">
                  <p class="mb-0"><b>Confirmations Received</b> </p>
                  <b class="text-success" style="font-size:15px;">{{$confirmedCount}}</b>
                </div>
              </div>
            </div>
          </div>
          <div class="col-3 mb-2">
            <div class="card mb-1 p-3" style="text-align: center;">
              <div class="card-body d-flex align-items-center p-0">
                <div class="flex-grow-1 top-h-menu">
                  <p class="mb-0"><b>Queries Raised</b> </p>
                  <b class="text-warning" style="font-size:15px;">{{$ledgerQueryCount}}</b>
                </div>
              </div>
            </div>
          </div>
          <div class="col-3 mb-2">
            <div class="card mb-1 p-3" style="text-align: center;">
              <div class="card-body d-flex align-items-center p-0">
                <div class="flex-grow-1 top-h-menu">
                  <p class="mb-0"><b>Confirmations Pending </b></p>
                  <b class="text-danger" style="font-size:15px;">{{$notConfirmedCount}}</b>
                </div>
              </div>
            </div>
          </div>
          <div class="mfh-machine-profile">
            <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="myTab1" role="tablist" style="background-color:#c5d9db !important ;border-radius: 10px 10px 0px 0px;">
              <li class="nav-item">
                <a style="color: #0e0e0e;" class="nav-link active " id="pending_tab" data-bs-toggle="tab" href="#pendingTab" role="tab" aria-controls="pendingTab" aria-selected="false">Confirmations Pending</a>
              </li>
              <li class="nav-item">
                <a style="color: #0e0e0e;" class="nav-link " id="confirm_tab" data-bs-toggle="tab" href="#confirmTab" role="tab" aria-controls="confirmTab" aria-selected="false">Confirmations Received</a>
              </li>
              <li class="nav-item">
                <a style="color: #0e0e0e;" class="nav-link " id="query_tab" data-bs-toggle="tab" href="#queryTab" role="tab" aria-controls="queryTab" aria-selected="false">Queries Raised</a>
              </li>
            </ul>
            <div class="tab-content ad-content2" id="myTabContent2">
              <div class="tab-pane fade show active " id="pendingTab" role="tabpanel">
                <div class="card chart-card">
                  <div class="card-header">
                    <select id="departmentSelect" name="department" style="float: left;width:150px;font-size:11px;" class="form-select form-select-sm me-3" aria-label="Select department">
                      <option selected="" value="">All Department</option>
                      @foreach($departments as $deptId => $deptName)
                      <option value="{{ $deptName }}">{{ $deptName }}</option>
                      @endforeach
                    </select>
                    <input type="text" id="searchInput" class=" form-select-sm me-3" style="float: left;width:150px;font-size:11px;" placeholder="Search...">

                    <div class="flex-shrink-0 float-end" style="font-size:16px;">
                    <a class="me-2 export-link" data-type="pending" data-format="pdf" href="#">
                      <i class="las la-file-pdf"></i>
                    </a>
                    <a class="me-2 export-link" data-type="pending" data-format="excel" href="#">
                      <i class="las la-file-excel"></i>
                    </a>
                    <a class="me-2 export-link" data-type="pending" data-format="csv" href="#">
                      <i class="las la-file-csv"></i>
                    </a>
                  </div>

                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div style="max-height: 300px; overflow-y: auto; width: 100%;"> {{-- Scrollable container --}}

                        <table class="table table-sm table-bordered mb-0" id="notconfirm">
                          <thead style="background-color:#cfdce1; position: sticky; top: 0; z-index: 1;">
                            <tr>
                              <th>SN</th>
                              <th>EC</th>
                              <th>Employee Name</th>
                              <th>Department</th>
                              <th>Email</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($notConfirmedEmployees as $index => $emp)
                            <tr>
                              <td>{{ $index + 1 }}</td> {{-- Serial Number --}}
                              <td>{{ $emp->EmpCode }}</td> {{-- EC --}}
                              <td>{{ $emp->full_name }}</td> {{-- Full Name --}}
                              <td class="department-cell">{{ $emp->department_name }}</td> {{-- Department --}}
                              <td>{{ $emp->EmailId_Vnr }}</td> {{-- Email --}}
                              <td><span class="text-warning">Pending</span></td> {{-- Always Pending --}}
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade show " id="confirmTab" role="tabpanel">
                <div class="card chart-card">
                  <div class="card-header">
                    <select id="departmentSelectConfirm" name="department" style="float: left;width:150px;font-size:11px;" class="form-select form-select-sm me-3" aria-label="Select department">
                      <option selected="" value="">All Department</option>
                      @foreach($departmentsConfirm as $deptId => $deptName)
                      <option value="{{ $deptName }}">{{ $deptName }}</option>
                      @endforeach
                    </select>
                    <input type="text" id="searchInputConfirm" class=" form-select-sm me-3" style="float: left;width:150px;font-size:11px;" placeholder="Search...">

                     
                    <div class="flex-shrink-0 float-end" style="font-size:16px;">
                      <a class="me-2 export-link" data-type="confirmed" data-format="pdf" href="#">
                        <i class="las la-file-pdf"></i>
                      </a>
                      <a class="me-2 export-link" data-type="confirmed" data-format="excel" href="#">
                        <i class="las la-file-excel"></i>
                      </a>
                      <a class="me-2 export-link" data-type="confirmed" data-format="csv" href="#">
                        <i class="las la-file-csv"></i>
                      </a>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div style="max-height: 300px; overflow-y: auto; width: 100%;"> {{-- Scrollable container --}}

                        <table class="table table-sm table-bordered mb-0" id="confirm">
                          <thead style="background-color:#cfdce1; position: sticky; top: 0; z-index: 1;">
                            <tr>
                              <th>SN</th>
                              <th>EC</th>
                              <th>Employee Name</th>
                              <th>Department</th>
                              <th>Email</th>
                              <th>Status</th>
                              <th>Action</th>

                            </tr>
                          </thead>
                          <tbody>
                            @foreach($ConfirmedEmployees as $index => $emp)
                            <tr>
                              <td>{{ $index + 1 }}</td> {{-- Serial Number --}}
                              <td>{{ $emp->EmpCode }}</td> {{-- EC --}}
                              <td>{{ $emp->full_name }}</td> {{-- Full Name --}}
                              <td class="department-cell-confirm">{{ $emp->department_name }}</td> {{-- Department --}}
                              <td>{{ $emp->EmailId_Vnr }}</td> {{-- Email --}}
                              <td><span class="text-success">Confirm</span></td> {{-- Always Pending --}}
                              <td>
                              <a href="javascript:void(0);" onclick="loadLedgerConfirmation({{ $emp->EmployeeID }})">
                                <i class="fas fa-eye" data-bs-toggle="modal" data-bs-target="#ledgerMissingModal" style="cursor: pointer;"></i>
                              </a>|
                               <a href="{{ route('ledger.confirmation.print', $emp->EmployeeID) }}" target="_blank" title="Print Ledger Confirmation">
                                    <i class="ri-printer-line ms-2" style="cursor: pointer;"></i>
                                </a>
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade show " id="queryTab" role="tabpanel">
                <div class="card chart-card">
                  <div class="card-header">
                    <select id="departmentSelectquery" name="department" style="float: left;width:150px;font-size:11px;" class="form-select form-select-sm me-3" aria-label="Select department">
                      <option selected="" value="">All Department</option>
                      @foreach($departmentsQueryraised as $deptId => $deptName)
                      <option value="{{ $deptName }}">{{ $deptName }}</option>
                      @endforeach
                    </select>
                    <input type="text" id="searchInputQuery" class=" form-select-sm me-3" style="float: left;width:150px;font-size:11px;" placeholder="Search...">


                    <div class="flex-shrink-0 float-end" style="font-size:16px;">
                      <a class="me-2 export-link" data-type="queried" data-format="pdf" href="#">
                        <i class="las la-file-pdf"></i>
                      </a>
                      <a class="me-2 export-link" data-type="queried" data-format="excel" href="#">
                        <i class="las la-file-excel"></i>
                      </a>
                      <a class="me-2 export-link" data-type="queried" data-format="csv" href="#">
                        <i class="las la-file-csv"></i>
                      </a>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <table class="table" id="query">
                        <thead style="background-color:#cfdce1;">
                          <tr>
                            <th>SN</th>
                            <th>EC</th>
                            <th>Employee Name</th>
                            <th>Department</th>
                            <th>Email</th>
                            <td>Date</td>
                            <th>Status</th>
                            <th>Details</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($QueryRaisedEmployees as $index => $emp)
                          @php
                              $statusLabels = [
                                  0 => ['label' => 'Open', 'class' => 'text-primary'],
                                  1 => ['label' => 'In Process', 'class' => 'text-warning'],
                                  2 => ['label' => 'Reply', 'class' => 'text-info'],
                                  3 => ['label' => 'Closed', 'class' => 'text-success'],
                                  4 => ['label' => 'Escalated', 'class' => 'text-danger'],
                              ];

                              $statusInfo = $statusLabels[$emp->status] ?? ['label' => 'Unknown', 'class' => 'text-muted'];
                              $formattedDate = \Carbon\Carbon::parse($emp->QueryRaisedAt)->format('d-m-Y');
                          @endphp
                          <tr>
                            <td>{{ $index + 1 }}</td> {{-- Serial Number --}}
                            <td>{{ $emp->EmpCode }}</td> {{-- EC --}}
                            <td>{{ $emp->full_name }}</td> {{-- Full Name --}}
                            <td class="department-cell-query">{{ $emp->department_name }}</td> {{-- Department --}}
                            <td>{{ $emp->EmailId_Vnr }}</td> {{-- Email --}}
                            <td><span class="{{ $statusInfo['class'] }}">{{ $statusInfo['label'] }}</span></td>
                            <td>{{ $formattedDate }}</td>
                            <td>
                              <a href="#" 
                                data-bs-toggle="modal" 
                                data-bs-target="#querydetails" 
                                data-employee-id="{{ $emp->EmployeeID }}" 
                                class="open-query-details">
                                <i class="fas fa-eye me-2" style="cursor: pointer;"></i>
                              </a>
                            </td>

                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Revanue Status Start -->


        @include('employee.footerbottom')

      </div>
    </div>
  </div>

 <!-- Ledger Modal -->
<div class="modal fade" id="ledgerMissingModal" tabindex="-1" aria-labelledby="ledgerMissingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title" id="ledgerMissingModalLabel">Employee Ledger Confirmation – FY 2024–25</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body" id="ledgerConfirmationContent">
        <div class="text-center">Loading...</div>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- <button class="btn btn-primary" onclick="printModalContent()">Print PDF</button> -->
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="querydetails" tabindex="-1" aria-labelledby="querydetailsLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ledger Query Details</h5>
        <span id="query-status-badge" class="badge bg-secondary ms-3"></span> <!-- 🟢 Status here -->
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="query-details-body">
        <!-- Query history will be loaded here -->
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      renderPdfToCanvas('/pdf/faq.pdf', 'pdfCanvasContainer');
    });

    function renderPdfToCanvas(pdfUrl, containerId) {
      const container = document.getElementById(containerId);
      container.innerHTML = ''; // Clear any previous render

      const loadingTask = pdfjsLib.getDocument(pdfUrl);
      loadingTask.promise.then(function(pdf) {
        const totalPages = pdf.numPages;

        // Render each page
        for (let pageNumber = 1; pageNumber <= totalPages; pageNumber++) {
          pdf.getPage(pageNumber).then(function(page) {
            const viewport = page.getViewport({
              scale: 1.5
            });
            const canvas = document.createElement('canvas');
            canvas.style.display = 'block';
            canvas.style.marginBottom = '10px';
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderContext = {
              canvasContext: context,
              viewport: viewport
            };

            container.appendChild(canvas);
            page.render(renderContext);
          });
        }
      }).catch(function(error) {
        container.innerHTML = '<p class="text-danger">Failed to load PDF.</p>';
        console.error('PDF loading error: ', error);
      });
    }
    function printModalContent() {
      const modalContent = document.querySelector('#ledgerMissingModal .modal-content');
      const printWindow = window.open('', '', 'height=800,width=1000');

      printWindow.document.write('<html><head><title>Ledger Confirmation</title>');
      printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');

      // Add print CSS here to hide modal-footer on printing
      printWindow.document.write(`
        <style>
          body { padding: 20px; }
          .fw-bold { font-weight: bold; }
          @media print {
            .modal-footer { display: none !important; }
          }
        </style>
      `);

      printWindow.document.write('</head><body>');
      printWindow.document.write(modalContent.innerHTML);
      printWindow.document.write('</body></html>');

      printWindow.document.close();
      printWindow.focus();

      setTimeout(() => {
        printWindow.print();
      }, 1000);
    }
    document.addEventListener('DOMContentLoaded', function () {
        const setups = [
            {
                inputId: 'searchInput',
                selectId: 'departmentSelect',
                tableId: 'notconfirm',
                deptClass: 'department-cell'
            },
            {
                inputId: 'searchInputConfirm',
                selectId: 'departmentSelectConfirm',
                tableId: 'confirm',
                deptClass: 'department-cell-confirm'
            },
            {
                inputId: 'searchInputQuery',
                selectId: 'departmentSelectquery',
                tableId: 'query',
                deptClass: 'department-cell-query'
            },
        ];

        setups.forEach(({ inputId, selectId, tableId, deptClass }) => {
            const input = document.getElementById(inputId);
            const select = document.getElementById(selectId);
            const table = document.getElementById(tableId);

            function filterRows() {
                const searchTerm = input.value.toLowerCase();
                const selectedDept = select.value.toLowerCase();
                const rows = table.querySelectorAll('tbody tr');
                let sn = 1;

                rows.forEach(row => {
                    const ec = row.cells[1]?.innerText.toLowerCase() || '';
                    const name = row.cells[2]?.innerText.toLowerCase() || '';
                    const deptCell = row.querySelector(`.${deptClass}`);
                    const deptName = deptCell ? deptCell.textContent.toLowerCase().trim() : '';

                    const matchesSearch = ec.includes(searchTerm) || name.includes(searchTerm);
                    const matchesDept = selectedDept === '' || deptName === selectedDept;

                    if (matchesSearch && matchesDept) {
                        row.style.display = '';
                        row.querySelector('td').textContent = sn++; // update serial
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            input.addEventListener('keyup', filterRows);
            select.addEventListener('change', filterRows);
        });
    });

    // document.getElementById('departmentSelect').addEventListener('change', function() {
    //   const selectedDept = this.value.toLowerCase();
    //   const rows = document.querySelectorAll('#notconfirm tbody tr');
    //   let sn = 1;

    //   rows.forEach(row => {
    //     const deptCell = row.querySelector('.department-cell');
    //     const deptName = deptCell ? deptCell.textContent.toLowerCase().trim() : '';

    //     if (selectedDept === '' || deptName === selectedDept) {
    //       row.style.display = '';
    //       // Update serial number (1st <td> in the row)
    //       row.querySelector('td').textContent = sn++;
    //     } else {
    //       row.style.display = 'none';
    //     }
    //   });
    // });
    // document.getElementById('departmentSelectConfirm').addEventListener('change', function() {
    //   const selectedDept = this.value.toLowerCase();
    //   const rows = document.querySelectorAll('#confirm tbody tr');
    //   let sn = 1;

    //   rows.forEach(row => {
    //     const deptCell = row.querySelector('.department-cell-confirm');
    //     const deptName = deptCell ? deptCell.textContent.toLowerCase().trim() : '';

    //     if (selectedDept === '' || deptName === selectedDept) {
    //       row.style.display = '';
    //       // Update serial number (1st <td> in the row)
    //       row.querySelector('td').textContent = sn++;
    //     } else {
    //       row.style.display = 'none';
    //     }
    //   });
    // });
    // document.getElementById('departmentSelectquery').addEventListener('change', function() {
    //   const selectedDept = this.value.toLowerCase();
    //   const rows = document.querySelectorAll('#query tbody tr');
    //   let sn = 1;

    //   rows.forEach(row => {
    //     const deptCell = row.querySelector('.department-cell-query');
    //     const deptName = deptCell ? deptCell.textContent.toLowerCase().trim() : '';

    //     if (selectedDept === '' || deptName === selectedDept) {
    //       row.style.display = '';
    //       // Update serial number (1st <td> in the row)
    //       row.querySelector('td').textContent = sn++;
    //     } else {
    //       row.style.display = 'none';
    //     }
    //   });
    // });
    document.querySelectorAll('.export-link').forEach(link => {
        link.addEventListener('click', function () {
            const type = this.getAttribute('data-type');     // pending / confirmed / queried
            const format = this.getAttribute('data-format'); // pdf / excel / csv

            // Table ID mapping based on type
            const tableIdMap = {
                pending: 'notconfirm',
                confirmed: 'confirm',
                queried: 'query'
            };

            const searchInputMap = {
                pending: 'searchInput',
                confirmed: 'searchInputConfirm',
                queried: 'searchInputQuery'
            };

            const tableId = tableIdMap[type];
            const table = document.getElementById(tableId);
            const searchInput = document.getElementById(searchInputMap[type]);
            const searchTerm = searchInput?.value.trim().toLowerCase() || '';

            const departmentSelect = document.querySelector(`#${tableId}`).closest('.card')?.querySelector('select[name="department"]');
            const department = departmentSelect ? departmentSelect.value : '';

            const selectedEmpCodes = [];

            table?.querySelectorAll('tbody tr').forEach(row => {
                if (row.style.display !== 'none') {
                    const ec = row.cells[1]?.innerText.trim();
                    if (ec) selectedEmpCodes.push(ec);
                }
            });

            const params = new URLSearchParams();
            params.set('department', department);
            if (searchTerm) params.set('search', searchTerm);
            selectedEmpCodes.forEach(code => params.append('empCodes[]', code));

            const url = `/ledger-confirmation/export/${type}/${format}?${params.toString()}`;
            window.location.href = url;
        });
    });

  // document.querySelectorAll('.export-link').forEach(link => {
  //     link.addEventListener('click', function () {
  //         const type = this.getAttribute('data-type');     // 'pending', 'confirmed', 'queried'
  //         const format = this.getAttribute('data-format'); // 'pdf', 'excel', 'csv'

  //         // 🟩 Map type to tab ID explicitly
  //         const tabIdMap = {
  //             'pending': 'pendingTab',
  //             'confirmed': 'confirmTab',
  //             'queried': 'queryTab'
  //         };

  //         const tabId = tabIdMap[type]; // Get actual tab DOM ID

  //         const departmentSelect = document.querySelector(`#${tabId} select[name="department"]`)
  //                                 || document.querySelector('select[name="department"]'); // fallback
  //         const department = departmentSelect ? departmentSelect.value : '';

  //         const url = `/ledger-confirmation/export/${type}/${format}?department=${encodeURIComponent(department)}`;
  //         window.location.href = url;
  //     });
  // });
  function loadLedgerConfirmation(employeeId) {
    const modalBody = document.getElementById('ledgerConfirmationContent');
    modalBody.innerHTML = '<div class="text-center">Loading...</div>';

    fetch(`/ledger-confirmation/details/${employeeId}`)
      .then(response => response.json())
      .then(data => {
        if (!data || !data.confirmed_at) {
          modalBody.innerHTML = `<div class="alert alert-danger">No confirmation found.</div>`;
          return;
        }

        const content = `
          <div class="p-3">
            <p><strong>Employee Name:</strong> ${data.full_name}</p>
            <p><strong>Employee Code:</strong> ${data.emp_code}</p>
            <p><strong>Department:</strong> ${data.department_name}</p>
            <p><strong>Ledger Period:</strong> 01-Apr-2024 to 31-Mar-2025</p>

            <div class="mt-4">
              <p class="fw-bold">Declaration:</p>
              <p>I, ${data.full_name}, have reviewed the attached ledger and confirm that it reflects the correct record of my payroll, claims, advances, and settlements. I confirm the same electronically via the ESS portal.</p>

              <p>☑️ Confirmed electronically</p>
              <p><b>IP Address/Device:</b> ${data.ip_address ?? 'N/A'}</p>

              <p class="mt-4"><small>Generated by Peepal on ${data.generated_at}</small><br>
              <em>*This document is system-generated and does not require a physical signature.*</em></p>
            </div>

            <!-- Confirmation Date Block at Last -->
            <div class="mt-4 p-3 border rounded bg-light">
              <label class="form-label fw-bold">Confirmation Date:</label>
              <div class="alert alert-success d-flex align-items-center" style="background-color: #d8f0e1; color: #1e4620;">
                <img src="https://img.icons8.com/emoji/20/000000/check-mark-emoji.png" alt="check" style="margin-right: 8px;">
                Confirmed on <strong class="ms-1">${data.confirmed_at}</strong>.
              </div>
            </div>
          </div>
        `;

        modalBody.innerHTML = content;
      })
      .catch(err => {
        console.error(err);
        modalBody.innerHTML = '<div class="alert alert-danger">Error loading confirmation data.</div>';
      });
  }
  // Example: Inside your modal open click event
  $('a[data-bs-target="#querydetails"]').on('click', function (e) {
      e.preventDefault();

      const employeeId = $(this).data('employee-id'); // Make sure data-employee-id is set
      console.log(employeeId);

      $.ajax({
          url: "{{ route('check.confirmation') }}",
          method: "POST",
          data: {
              employeeId: employeeId,
              year: {{ date('Y') }},
              _token: '{{ csrf_token() }}'
          },
          success: function (data) {
              console.log(data.queryHistory);

              // Set query status
              if (data.status) {
                  $('#query-status-badge').text(data.status);

                  // Optional: Change badge color
                  let colorClass = 'bg-secondary';
                  if (data.status === 'Approved' || data.status === 'Replied' || data.status === 'Closed') {
                      colorClass = 'bg-success';
                  } else if (data.status === 'Open') {
                      colorClass = 'bg-warning text-dark';
                  } else if (data.status === 'Escalated') {
                      colorClass = 'bg-danger';
                  }

                  $('#query-status-badge')
                      .removeClass()
                      .addClass('badge ms-3 ' + colorClass);
              }

              // Now render the queryHistory in the modal body
              let html = '';
              let hasReply = false;
              data.queryHistory.forEach(item => {
                  const alignClass = item.type === 'question' ? 'float-right' : 'float-left';
                  const bgClass = item.type === 'question' ? 'bg-light' : 'bg-primary text-white';
                  html += `
                        <div class="d-flex flex-column w-100 mb-2">
                            <div class="d-flex ${item.type === 'question' ? 'justify-content-end' : 'justify-content-start'}">
                                <div class="p-2 rounded shadow-sm ${bgClass}" style="max-width: 70%;">
                                    <b>Status:</b> ${item.status}<br>
                                    ${item.text}
                                    <div class="small text-muted">${new Date(item.date).toLocaleString()}</div>
                                </div>
                            </div>
                        </div>
                    `;
              });

              $('#query-details-body').html(html);
          }
      });
  });
  // document.addEventListener('DOMContentLoaded', function () {
  //     // Handle all three tables using common logic
  //     const setups = [
  //         { inputId: 'searchInput', tableId: 'notconfirm' },
  //         { inputId: 'searchInputConfirm', tableId: 'confirm' },
  //         { inputId: 'searchInputQuery', tableId: 'query' },
  //     ];

  //     setups.forEach(({ inputId, tableId }) => {
  //         const input = document.getElementById(inputId);
  //         const table = document.getElementById(tableId);
  //         const rows = table.querySelectorAll('tbody tr');

  //         input.addEventListener('keyup', function () {
  //             const searchTerm = this.value.toLowerCase();

  //             rows.forEach(row => {
  //                 const ec = row.cells[1]?.innerText.toLowerCase(); // EC = 2nd column (index 1)
  //                 const name = row.cells[2]?.innerText.toLowerCase(); // Name = 3rd column (index 2)

  //                 row.style.display =
  //                     ec.includes(searchTerm) || name.includes(searchTerm) ? '' : 'none';
  //             });
  //         });
  //     });
  // });


  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>


  @include('employee.footer');
 