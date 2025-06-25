@include('employee.header')

<body class="mini-sidebar">
    @include('employee.sidebar')
    <div class="loader" style="display: none;">
        <div class="spinner" style="display: none;">
            <img src="{{ asset('SplashDash_files/loader.gif') }}" alt="">
        </div>
    </div>
    <div class="page-wrapper">
        @include('employee.head')
        <div class="main-content">
            <div class="row">
                <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-title-wrapper">
                        <div class="breadcrumb-list">
                            <ul>
                                <li class="breadcrumb-link">
                                    <a href="{{ route('dashboard') }}"><i class="fas fa-home mr-2"></i>Home</a>
                                </li>
                                <li class="breadcrumb-link active">Ledger Download</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-7">
                    <div id="pdfViewer" style="position: relative; width: 100%; height: calc(100vh - 100px);">
                        <div id="downloadLoading" style="text-align: center; padding: 20px;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p>Loading ledger...</p>
                        </div>
                        <div id="downloadError" style="display: none;" class="alert alert-danger">
                            Ledger not available for this employee
                        </div>
                        <div id="pdfContainer" style="width: 100%; height: 100%; overflow: auto; display: none;">
                            <div id="viewer" class="pdfViewer"></div>
                        </div>
                        <div id="pdfFallback" style="display: none; text-align: center; padding: 20px;">
                            <p>Unable to display PDF in browser. <a id="pdfLink" href="#" target="_blank">View PDF</a></p>
                        </div>
                        <div style="position: absolute; top: 0; left: 0; height: 100%; width: 100%; background: transparent; z-index: 10;"
                            oncontextmenu="return false" oncopy="return false"></div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="card chart-card">
                        <div class="card-body">
                            <div class="row">
                                <h4 class="mt-2 mb-2">Ledger Confirmation</h4>
                                <div id="confirmationSection">
                                    <!-- Dynamic content will be inserted here -->
                                </div>
                                <div id="messageBox" class="alert mt-3" style="display: none;"></div>
                                <a class="btn btn-primary m-3" id="download_pdf" style="display: none;"><i class="fas fa-download mr-2"></i>Download PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('employee.footerbottom')
        </div>
    </div>
    @include('employee.footer')
</body>

<script src="{{ asset('pdfjs/pdf.min.js') }}"></script>
<script src="{{ asset('pdfjs/pdf_viewer.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('pdfjs/pdf_viewer.min.css') }}">
<script src="https://cdn.jsdelivr.net/npm/@fingerprintjs/fingerprintjs@3/dist/fp.min.js"></script>

<script>
    // Immediate debug to confirm script execution
    console.log('Inline script started at:', new Date().toISOString());

    (function() {
        // Check if pdfjsLib is available
        if (typeof pdfjsLib === 'undefined') {
            console.error('pdfjsLib is not defined. Ensure pdf.min.js is loaded.');
            document.getElementById('downloadError').textContent = 'PDF library failed to load. Please refresh the page or contact support.';
            document.getElementById('downloadError').style.display = 'block';
            document.getElementById('downloadLoading').style.display = 'none';
            return;
        }

        // Set PDF.js worker source
        pdfjsLib.GlobalWorkerOptions.workerSrc = "{{ asset('pdfjs/pdf.worker.min.js') }}";

        // Debug: Log PDF.js namespaces
        console.log('pdfjsLib:', pdfjsLib);
        console.log('pdfjsViewer:', window.pdfjsViewer);

        // DOM elements
        const pdfContainer = document.getElementById('pdfContainer');
        const viewer = document.getElementById('viewer');
        const errorDiv = document.getElementById('downloadError');
        const loadingDiv = document.getElementById('downloadLoading');
        const messageBox = document.getElementById('messageBox');
        const pdfFallback = document.getElementById('pdfFallback');
        const pdfLink = document.getElementById('pdfLink');
        const confirmationSection = document.getElementById('confirmationSection');
        const downloadButton = document.getElementById('download_pdf');

        if (!pdfContainer || !viewer || !errorDiv || !loadingDiv) {
            console.error('Critical DOM elements missing:', { pdfContainer, viewer, errorDiv, loadingDiv });
            errorDiv.textContent = 'Page setup error. Please refresh or contact support.';
            errorDiv.style.display = 'block';
            loadingDiv.style.display = 'none';
            return;
        }

        // Employee data
        const employeeId = '{{ $employeeId ?? "" }}';
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
        console.log('Employee ID:', employeeId, 'CSRF Token:', csrfToken);

        // Immediately show loading state
        loadingDiv.style.display = 'block';
        pdfContainer.style.display = 'none';
        errorDiv.style.display = 'none';
        pdfFallback.style.display = 'none';

        // Initialize PDF.js viewer
        let pdfViewer = null;

        // Load PDF and check confirmation status

        async function initializePage() {
    try {
        console.log('Fetching employee data...');
        const empDataResponse = await fetch('{{ route("ledger.getEmployeeData") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ employeeId })
        });

        if (!empDataResponse.ok) {
            throw new Error(`Employee data request failed: ${empDataResponse.status} ${empDataResponse.statusText}`);
        }

        const empData = await empDataResponse.json();
        console.log('Employee data response:', empData);

        if (!empData.success) {
            throw new Error(empData.message || 'Failed to load employee data');
        }

        // Store employee data globally
        window.employeeData = {
            companyId: empData.companyId,
            empCode: empData.empCode,
            vCode: empData.vCode || ''
        };
        console.log('Stored employee data:', window.employeeData);

        // Build PDF URL
        const year = '2024-25';
        const prefix = window.employeeData.vCode === 'V' ? '' : 'E';

        // Assuming you already fetched this info earlier:
        const hasConfirmed = empData.hasConfirmedEmployee; // Make sure this is set via API
        let pdfUrl = '';  // <-- Declare here to avoid undefined

        console.log('hasConfirmed', hasConfirmed);

        if (hasConfirmed) {
            pdfUrl = `/ledger-confirmation/view/${employeeId}`;
        } else {
            // Call the default PDF view without declaration
            pdfUrl = `/ledger/view/${window.employeeData.companyId}/${year}/${prefix}${window.employeeData.empCode}?employeeId=${employeeId}&t=${Date.now()}`;
        }
        // const pdfUrl = `/ledger/view/${window.employeeData.companyId}/${year}/${prefix}${window.employeeData.empCode}?employeeId=${employeeId}&t=${Date.now()}`;
        console.log('PDF URL:', pdfUrl);

        // Test PDF URL accessibility
        console.log('Testing PDF URL accessibility...');
        const testResponse = await fetch(pdfUrl, { method: 'HEAD' });
        if (!testResponse.ok) {
            throw new Error(`PDF URL inaccessible: ${testResponse.status} ${testResponse.statusText}`);
        }
        console.log('PDF URL test response headers:', [...testResponse.headers]);

        // Initialize PDF.js viewer
        console.log('Initializing PDF.js viewer...');
        const EventBus = window.pdfjsViewer?.EventBus;
        if (!EventBus) {
            throw new Error('EventBus not found in pdfjsViewer. Ensure pdf_viewer.min.js is loaded correctly.');
        }
        const eventBus = new EventBus();
        console.log('EventBus created:', eventBus);

        pdfViewer = new pdfjsViewer.PDFViewer({
            container: pdfContainer,
            viewer: viewer,
            eventBus: eventBus,
            textLayerMode: 0, // Disable text layer
            annotationLayerMode: 0 // Disable annotations
        });
        console.log('PDFViewer initialized:', pdfViewer);

        // Load PDF with timeout
        console.log('Loading PDF from:', pdfUrl);
        const loadingTask = pdfjsLib.getDocument({
            url: pdfUrl,
            disableAutoFetch: true,
            disableStream: true
            // Removed withCredentials to avoid CORB unless required
        });

        // Add timeout to prevent hanging
        const timeoutPromise = new Promise((_, reject) =>
            setTimeout(() => reject(new Error('PDF loading timed out after 15 seconds')), 15000)
        );

        try {
            const pdfDocument = await Promise.race([loadingTask.promise, timeoutPromise]);
            console.log('PDF document loaded:', pdfDocument);

            pdfViewer.setDocument(pdfDocument);
            pdfViewer.currentScaleValue = '1.0'; // Changed to page-fit for better scaling
            console.log('PDF viewer set with scale: page-fit');

            // Hide loading and show PDF
            loadingDiv.style.display = 'none';
            pdfContainer.style.display = 'block';
            console.log('PDF container displayed');
        } catch (pdfError) {
            console.error('PDF loading error:', pdfError);
            throw new Error(`Failed to load PDF: ${pdfError.message}. This may be due to CORS restrictions.`);
        }

        // Customize toolbar
        customizeToolbar();

        // Set download button and fallback link
        pdfLink.href = pdfUrl;
        // downloadButton.href = `/ledger/download/${window.employeeData.companyId}/${year}/${prefix}${window.employeeData.empCode}?employeeId=${employeeId}`;
        // console.log('Download button href set:', downloadButton.href);
        downloadButton.href = `/ledger-confirmation/print/${employeeId}`;

        console.log('Download button href set:', downloadButton.href);

        // Check confirmation status
        console.log('Checking confirmation status...');
        await checkConfirmationStatus();

    } catch (error) {
        console.error('Initialization error:', error.message, error.stack);
        loadingDiv.style.display = 'none';
        errorDiv.textContent = error.message.includes('CORS') 
            ? 'Failed to load PDF due to CORS restrictions. Please contact support or try downloading directly.'
            : error.message || 'Failed to load ledger';
        errorDiv.style.display = 'block';
        pdfFallback.style.display = 'block';
        pdfLink.href = pdfUrl;
    }
}

        // async function initializePage() {
        //     try {
        //         console.log('Fetching employee data...');
        //         const empDataResponse = await fetch('{{ route("ledger.getEmployeeData") }}', {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'X-CSRF-TOKEN': csrfToken
        //             },
        //             body: JSON.stringify({ employeeId })
        //         });

        //         if (!empDataResponse.ok) {
        //             throw new Error(`Employee data request failed: ${empDataResponse.status} ${empDataResponse.statusText}`);
        //         }

        //         const empData = await empDataResponse.json();
        //         console.log('Employee data response:', empData);

        //         if (!empData.success) {
        //             throw new Error(empData.message || 'Failed to load employee data');
        //         }

        //         // Store employee data globally
        //         window.employeeData = {
        //             companyId: empData.companyId,
        //             empCode: empData.empCode,
        //             vCode: empData.vCode || ''
        //         };
        //         console.log('Stored employee data:', window.employeeData);

        //         // Build PDF URL
        //         const year = '2024-25';
        //         const prefix = window.employeeData.vCode === 'V' ? '' : 'E';
        //         // Assuming you already fetched this info earlier:
        //         const hasConfirmed = empData.hasConfirmedEmployee; // Make sure this is set via API

        //         let pdfUrl = '';
        //         console.log('hasConfirmed',hasConfirmed);

        //         if (hasConfirmed) {
        //             pdfUrl = `/ledger-confirmation/view/${employeeId}`;

        //         } else {
        //             // Call the default PDF view without declaration
        //             pdfUrl = `/ledger/view/${window.employeeData.companyId}/${year}/${prefix}${window.employeeData.empCode}?employeeId=${employeeId}&t=${Date.now()}`;
        //         }
        //         // const pdfUrl = `/ledger/view/${window.employeeData.companyId}/${year}/${prefix}${window.employeeData.empCode}?employeeId=${employeeId}&t=${Date.now()}`;
        //         console.log('PDF URL:', pdfUrl);

        //         // Test PDF URL accessibility
        //         console.log('Testing PDF URL accessibility...');
        //         const testResponse = await fetch(pdfUrl, { method: 'HEAD' });
        //         if (!testResponse.ok) {
        //             throw new Error(`PDF URL inaccessible: ${testResponse.status} ${testResponse.statusText}`);
        //         }
        //         console.log('PDF URL test response headers:', [...testResponse.headers]);

        //         // Initialize PDF.js viewer
        //         console.log('Initializing PDF.js viewer...');
        //         const EventBus = window.pdfjsViewer?.EventBus;
        //         if (!EventBus) {
        //             throw new Error('EventBus not found in pdfjsViewer. Ensure pdf_viewer.min.js is loaded correctly.');
        //         }
        //         const eventBus = new EventBus();
        //         console.log('EventBus created:', eventBus);

        //         pdfViewer = new pdfjsViewer.PDFViewer({
        //             container: pdfContainer,
        //             viewer: viewer,
        //             eventBus: eventBus,
        //             textLayerMode: 0, // Disable text layer
        //             annotationLayerMode: 0 // Disable annotations
        //         });
        //         console.log('PDFViewer initialized:', pdfViewer);

        //         // Load PDF with timeout
        //         console.log('Loading PDF from:', pdfUrl);
        //         const loadingTask = pdfjsLib.getDocument({
        //             url: pdfUrl,
        //             disableAutoFetch: true,
        //             disableStream: true
        //             // Removed withCredentials to avoid CORB unless required
        //         });

        //         // Add timeout to prevent hanging
        //         const timeoutPromise = new Promise((_, reject) =>
        //             setTimeout(() => reject(new Error('PDF loading timed out after 15 seconds')), 15000)
        //         );

        //         try {
        //             const pdfDocument = await Promise.race([loadingTask.promise, timeoutPromise]);
        //             console.log('PDF document loaded:', pdfDocument);

        //             pdfViewer.setDocument(pdfDocument);
        //             pdfViewer.currentScaleValue = '1.0'; // Changed to page-fit for better scaling
        //             console.log('PDF viewer set with scale: page-fit');

        //             // Hide loading and show PDF
        //             loadingDiv.style.display = 'none';
        //             pdfContainer.style.display = 'block';
        //             console.log('PDF container displayed');
        //         } catch (pdfError) {
        //             console.error('PDF loading error:', pdfError);
        //             throw new Error(`Failed to load PDF: ${pdfError.message}. This may be due to CORS restrictions.`);
        //         }

        //         // Customize toolbar
        //         customizeToolbar();

        //         // Set download button and fallback link
        //         pdfLink.href = pdfUrl;
        //         // downloadButton.href = `/ledger/download/${window.employeeData.companyId}/${year}/${prefix}${window.employeeData.empCode}?employeeId=${employeeId}`;
        //         // console.log('Download button href set:', downloadButton.href);
        //         downloadButton.href = `/ledger-confirmation/print/${employeeId}`;

        //         console.log('Download button href set:', downloadButton.href);

        //         // Check confirmation status
        //         console.log('Checking confirmation status...');
        //         await checkConfirmationStatus();

        //     } catch (error) {
        //         console.error('Initialization error:', error.message, error.stack);
        //         loadingDiv.style.display = 'none';
        //         errorDiv.textContent = error.message.includes('CORS') 
        //             ? 'Failed to load PDF due to CORS restrictions. Please contact support or try downloading directly.'
        //             : error.message || 'Failed to load ledger';
        //         errorDiv.style.display = 'block';
        //         pdfFallback.style.display = 'block';
        //         pdfLink.href = pdfUrl;
        //     }
        // }

        // Customize PDF.js toolbar
        function customizeToolbar() {
            console.log('Customizing toolbar...');
            const toolbar = document.querySelector('#viewer .toolbar');
            if (toolbar) {
                toolbar.style.display = 'none';
                console.log('Toolbar hidden');
            } else {
                setTimeout(customizeToolbar, 500);
                console.log('Toolbar not found, retrying...');
            }
        }

        // Check confirmation status
        async function checkConfirmationStatus() {
            try {
                console.log('Fetching confirmation status...');
                const res = await fetch('{{ route("ledger.checkConfirmation") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        employeeId,
                        year: '2024-25'
                    })
                });

                if (!res.ok) {
                    throw new Error(`Confirmation request failed: ${res.status} ${res.statusText}`);
                }

                const data = await res.json();
                console.log('Confirmation status:', data);
                if (data.alreadyConfirmed) {
                    showConfirmedUI(data.confirmationDate,data.fullName);
                    downloadButton.style.display = 'block';
                } else if (data.hasQuery) {
                    showQuerySubmittedUI(data);
                } else {
                    showConfirmationForm(data);
                }
            } catch (error) {
                console.error('Confirmation check failed:', error);
                showConfirmationForm();
            }
        }

        function showQuerySubmittedUI(data) {
            console.log('Showing query submitted UI:', data);
            let html = `
                <div class="alert alert-warning">
                    <i class="fas fa-question-circle"></i> 
                    You submitted a query regarding this ledger on ${new Date(data.queryDate).toLocaleDateString()}
                </div>
                <div class="query-history mb-3" style="max-height: 300px; overflow-y: auto;">
            `;

            let hasReply = false;
            console.log(data.queryHistory);
            data.queryHistory.forEach(item => {
                const alignClass = item.type === 'question' ? 'float-right' : 'float-left';
                const bgClass = item.type === 'question' ? 'bg-light' : 'bg-primary text-black';
                console.log(alignClass);

                html += `
                    <div class="mb-2 ${alignClass}">
                        <div class="d-inline-block p-2 rounded ${bgClass}">
                            <b>Status : </b>${item.status}<br>
                            ${item.text}
                            <div class="small text-muted">${new Date(item.date).toLocaleString()}</div>
                        </div>
                    </div>
                `;
                if (item.type === 'answer') hasReply = true;
            });

            html += `</div>`;

            
            if (data.canAddNewQuery && hasReply) {
                html += `
                    <div class="form-group">
                          <div class="form-check mb-3">
                            <input style="float:left;" class="me-2" type="radio" name="confirmationOption" id="confirmRadio" value="confirm">
                            <label style="width:90%;line-height:25px;margin-left:5px;float:left;" class="form-check-label" for="confirmRadio">
                               I, <b>${data.fullName}</b>, have reviewed the attached ledger and confirm that it reflects the
                                 correct record of my payroll, claims, 
                                advances, and settlements. I confirm the same electronically via the <b>Peepal</b> portal.
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input style="float:left;" class="me-2" type="radio" name="confirmationOption" id="queryRadio" value="query">
                            <label style="width:90%;line-height:30px;margin-left:5px;float:left;" class="form-check-label" for="queryRadio">
                                I have a query regarding the ledger shared with me.
                            </label>
                        </div>
                        <div id="querySection">
                            <textarea class="form-control" id="queryText" style="display: none;"
                                      placeholder="Add your follow-up query..." rows="3"></textarea>
                            <button class="btn btn-primary mt-3" id="submitFollowup">
                                <i class="fas fa-paper-plane mr-2"></i> Submit
                            </button>
                        </div>
                    </div>
                `;
            } 
            
            
            else if (data.canAddNewQuery) {
                html += `
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        Your query has been submitted. Please wait for a response.
                    </div>
                `;
            }

            confirmationSection.innerHTML = html;

            if (data.canAddNewQuery && hasReply) {
                document.getElementById('submitFollowup').addEventListener('click', submitConfirmation);
            }
             document.querySelectorAll('input[name="confirmationOption"]').forEach(input => {
                input.addEventListener('change', () => {
                    document.getElementById('queryText').style.display =
                        document.getElementById('queryRadio').checked ? 'block' : 'none';
                });
            });
        }

        async function submitFollowupQuery() {
            const queryText = document.getElementById('queryText').value.trim();
            const submitBtn = document.getElementById('submitFollowup');
            const isQuerySelected = document.getElementById('queryRadio').checked;

            if (isQuerySelected && !queryText) {
                showMessage('Please enter your follow-up query', 'danger');
                return;
            }

            const originalHtml = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Processing...';

            try {
                console.log('Submitting follow-up query:', queryText);
                const res = await fetch('{{ route("ledger.submitQueryFollowup") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        employeeId,
                        companyId: window.employeeData?.companyId,
                        year: '2024-25',
                        empCode: window.employeeData?.vCode === 'V' ? '' + window.employeeData?.empCode : 'E' + window.employeeData?.empCode,
                        queryText
                    })
                });

                if (!res.ok) {
                    throw new Error(`Follow-up query failed: ${res.status} ${res.statusText}`);
                }

                const data = await res.json();
                console.log('Follow-up query response:', data);
                if (!res.ok) throw new Error(data.message || 'Submission failed');

                showMessage('Follow-up query submitted successfully', 'success');
                await checkConfirmationStatus();
            } catch (error) {
                console.error('Follow-up query error:', error);
                showMessage(error.message, 'danger');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
            }
        }

        function showConfirmedUI(confirmationDate,fullName) {
            console.log(fullName);
            console.log('Showing confirmed UI:', confirmationDate);
            confirmationSection.innerHTML = `
                <div class="alert alert-success">
                                I, <b>${fullName}</b>, have reviewed the attached ledger and confirm that it reflects the
                                 correct record of my payroll, claims, 
                                advances, and settlements. I confirm the same electronically via the <b>Peepal</b> portal.
                                <br>
                                <br><i class="fas fa-check-circle"></i> 
                                You confirmed this ledger on ${new Date(confirmationDate).toLocaleDateString('en-GB').slice(0, 12)}
                </div>
            `;
            downloadButton.style.display = 'block';
        }

        function showConfirmationForm(data) {
            console.log('Showing confirmation form fullName',data);
            confirmationSection.innerHTML = `
                <div class="confirmation-form">
                    <div class="alert alert-info">
                        <strong>Please select one of the following options:</strong>
                    </div>
                    <div class="form-group">
                        <div class="form-check mb-1" style="float:left;width:100%;">
                            <input style="float:left;" type="radio" name="confirmationOption" id="confirmRadio" value="confirm">
                            <label style="width:90%;line-height:30px;margin-left:5px;float:left;" class="form-check-label" for="confirmRadio">
                                I, <b>${data.fullName}</b>, have reviewed the attached ledger and confirm that it reflects the
                                 correct record of my payroll, claims, 
                                advances, and settlements. I confirm the same electronically via the <b>Peepal</b> portal.
                            </label>
                        </div>
                        <div class="form-check mb-1" style="float:left;width:100%;">
                            <input style="float:left;"type="radio" name="confirmationOption" id="queryRadio" value="query">
                            <label style="width:90%;line-height:30px;margin-left:5px;float:left;" class="form-check-label" for="queryRadio">
                                I have a query regarding the ledger shared with me.
                            </label>
                        </div>
                        <div id="querySection" style="display: none; margin-top: 10px;">
                            <textarea class="form-control" id="queryText" placeholder="Please describe your query in detail..." rows="3"></textarea>
                        </div>
                        <button class="btn btn-primary mt-3" id="submitConfirmation">
                            <i class="fas fa-check-circle mr-2"></i> Submit
                        </button>
                    </div>
                </div>
            `;

            document.querySelectorAll('input[name="confirmationOption"]').forEach(input => {
                input.addEventListener('change', () => {
                    document.getElementById('querySection').style.display =
                        document.getElementById('queryRadio').checked ? 'block' : 'none';
                });
            });

            document.getElementById('submitConfirmation').addEventListener('click', submitConfirmation);
        }
        async function submitConfirmation(event) {
            const confirmationType = document.querySelector('input[name="confirmationOption"]:checked')?.value;
            const queryText = confirmationType === 'query' ? document.getElementById('queryText').value.trim() : '';

            // Detect which button was clicked (either submitFollowup or submitConfirmation)
            const submitBtn = event.target;

            if (!confirmationType) {
                showMessage('Please select an option', 'danger');
                return;
            }

            if (confirmationType === 'query' && !queryText) {
                showMessage('Please enter your query details', 'danger');
                return;
            }

            const originalHtml = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Processing...';
            // Load FingerprintJS agent
                    const fp = await FingerprintJS.load();
                    const result = await fp.get();
                    console.log(result);
                    const fingerprint = result.visitorId;
            try {
                console.log('Submitting confirmation:', confirmationType, queryText);

                const res = await fetch('{{ route("ledger.submitConfirmation") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        employeeId,
                        companyId: window.employeeData?.companyId,
                        year: '2024-25',
                        empCode: window.employeeData?.vCode === 'V' ? '' + window.employeeData?.empCode : 'E' + window.employeeData?.empCode,
                        confirmation: confirmationType,
                        queryText,
                        fingerprint:result
                    })
                });

                if (!res.ok) {
                    throw new Error(`Confirmation submission failed: ${res.status} ${res.statusText}`);
                }

                const data = await res.json();
                console.log('Confirmation response:', data);
                if (!res.ok) throw new Error(data.message || 'Submission failed');

                showMessage(
                    confirmationType === 'confirm'
                        ? 'Confirmation submitted successfully'
                        : 'Query submitted/Updated successfully',
                    'success'
                );

                if (confirmationType === 'confirm') {
                    console.log('data',data);
                    showConfirmedUI(new Date(),data.fullName);
                    downloadButton.style.display = 'block';

                    // if (data.downloadUrl) {
                    //     const link = document.createElement('a');
                    //     link.href = data.downloadUrl;
                    //     link.download = `ledger_2024-25_${window.employeeData.vCode === 'V' ? '' : 'E'}${window.employeeData.empCode}.pdf`;
                    //     document.body.appendChild(link);
                    //     link.click();
                    //     document.body.removeChild(link);
                    // }
                      if (data.downloadUrl) {
                        const link = document.createElement('a');
                        link.href = data.downloadUrl;
                        link.download = `ledger_confirmation_${data.fullName.replace(/\s+/g, '_')}.pdf`;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    }
                } else {
                    // Reload the page after query insert/update
                    setTimeout(() => location.reload(), 1000);
                }
            } catch (error) {
                console.error('Confirmation error:', error);
                showMessage(error.message, 'danger');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
            }
        }

        // async function submitConfirmation() {
        //     const confirmationType = document.querySelector('input[name="confirmationOption"]:checked')?.value;
        //     const queryText = confirmationType === 'query' ? document.getElementById('queryText').value.trim() : '';
        //     const submitBtn = document.getElementById('submitConfirmation');

        //     if (!confirmationType) {
        //         showMessage('Please select an option', 'danger');
        //         return;
        //     }

        //     if (confirmationType === 'query' && !queryText) {
        //         showMessage('Please enter your query details', 'danger');
        //         return;
        //     }

        //     const originalHtml = submitBtn.innerHTML;
        //     submitBtn.disabled = true;
        //     submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Processing...';

        //     try {
        //         console.log('Submitting confirmation:', confirmationType, queryText);
        //         const res = await fetch('{{ route("ledger.submitConfirmation") }}', {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'X-CSRF-TOKEN': csrfToken
        //             },
        //             body: JSON.stringify({
        //                 employeeId,
        //                 companyId: window.employeeData?.companyId,
        //                 year: '2024-25',
        //                 empCode: window.employeeData?.vCode === 'V' ? '' + window.employeeData?.empCode : 'E' + window.employeeData?.empCode,
        //                 confirmation: confirmationType,
        //                 queryText
        //             })
        //         });

        //         if (!res.ok) {
        //             throw new Error(`Confirmation submission failed: ${res.status} ${res.statusText}`);
        //         }

        //         const data = await res.json();
        //         console.log('Confirmation response:', data);
        //         if (!res.ok) throw new Error(data.message || 'Submission failed');

        //         showMessage(
        //             confirmationType === 'confirm' ? 'Confirmation submitted successfully' : 'Query submitted/Updated successfully',
        //             'success'
        //         );

        //         if (confirmationType === 'confirm') {
        //             showConfirmedUI(new Date());
        //             downloadButton.style.display = 'block';

        //             if (data.downloadUrl) {
        //                 const link = document.createElement('a');
        //                 link.href = data.downloadUrl;
        //                 link.download = `ledger_2024-25_${window.employeeData.vCode === 'V' ? '' : 'E'}${window.employeeData.empCode}.pdf`;
        //                 document.body.appendChild(link);
        //                 link.click();
        //                 document.body.removeChild(link);
        //             }
        //         }
        //         else {
        //             // Reload the page after query insert/update
        //             setTimeout(() => location.reload(), 1000); // Optional delay
        //         }
        //     } catch (error) {
        //         console.error('Confirmation error:', error);
        //         showMessage(error.message, 'danger');
        //     } finally {
        //         submitBtn.disabled = false;
        //         submitBtn.innerHTML = originalHtml;
        //     }
        // }

        function showMessage(text, type) {
            messageBox.textContent = text;
            messageBox.className = `alert alert-${type}`;
            messageBox.style.display = 'block';
            setTimeout(() => messageBox.style.display = 'none', 5000);
        }

        // Download button handler new
      const baseDownloadUrl = "{{ url('/ledger-confirmation/print') }}";

        downloadButton.addEventListener('click', function(e) {
            e.preventDefault();

            if (!window.employeeData) {
                alert('Employee data not loaded');
                return;
            }
            const url = `${baseDownloadUrl}/${employeeId}`;

            console.log('Opening PDF URL:', url);

            // Open the PDF route in a new tab/window to display it inline
            window.open(url, '_blank');
        });
 

        // // Download button handler old
        // downloadButton.addEventListener('click', function(e) {
        //     e.preventDefault();

        //     if (!window.employeeData) {
        //         showMessage('Employee data not loaded', 'danger');
        //         return;
        //     }

        //     const year = '2024-25';
        //     const prefix = window.employeeData.vCode === 'V' ? '' : 'E';
        //     const pdfPath = `/ledger/download/${window.employeeData.companyId}/${year}/${prefix}${window.employeeData.empCode}?employeeId=${employeeId}`;
        //     console.log('Downloading PDF:', pdfPath);

        //     const link = document.createElement('a');
        //     link.href = pdfPath;
        //     link.download = `ledger_${year}_${prefix}${window.employeeData.empCode}.pdf`;

        //     const btn = e.currentTarget;
        //     const originalHtml = btn.innerHTML;
        //     btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Downloading...';
        //     btn.disabled = true;

        //     link.onclick = () => {
        //         setTimeout(() => {
        //             btn.innerHTML = originalHtml;
        //             btn.disabled = false;
        //         }, 2000);
        //     };

        //     document.body.appendChild(link);
        //     link.click();
        //     document.body.removeChild(link);
        // });

        // Security measures
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('keydown', e => {
            if (e.ctrlKey && ['s', 'p', 'c'].includes(e.key.toLowerCase())) e.preventDefault();
        });

        // Initialize the page
        console.log('Starting page initialization...');
        initializePage();
    })();
</script>

<style>
    #pdfViewer {
        position: relative;
        width: 100%;
        height: calc(100vh - 100px); /* Dynamic height for better fit */
        overflow: hidden;
    }

    #pdfContainer {
         width: 100%;
        height: 100%;
        overflow: auto;
        background: #525659;
    }

    
    .pdfViewer {
        width: 100%;
        height: auto;
        min-height: 100%; /* Ensure full height */
    }

    .pdfViewer .page {
    margin: 10px auto;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
    position: relative;
}
    .confirmation-form {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
        border: 1px solid #dee2e6;
    }

    .form-check-label {
        font-weight: normal;
        cursor: pointer;
    }

    #querySection {
        transition: all 0.3s ease;
    }

    #download_pdf {
        transition: all 0.3s ease;
        width: 200px;
    }

    .spinner-border {
        width: 2rem;
        height: 2rem;
    }

    #confirmationSection .alert {
        margin-bottom: 15px;
    }

    #pdfViewer > div[style*="z-index: 10"] {
        pointer-events: none; /* Prevent overlay from blocking scroll */
    }
    .float-left {
        float: left;
        clear: both; /* so each message starts on a new line */
        max-width: 75%;
        margin-bottom: 0.5rem;
        }

        .float-right {
                float: right;
                clear: both; /* so each message starts on a new line */
                max-width: 75%;
                margin-bottom: 0.5rem;
        }
        .bg-primary{
            background-color: #dfeeef !important;
        }
</style>
