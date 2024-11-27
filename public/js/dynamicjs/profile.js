function printPayslip(monthlyPaySlipId, month, year, payslipData) {
    // Parse the passed JSON data into an object
    const payslip = JSON.parse(payslipData);

    // Get the Month Name from the numeric month
    const monthName = new Date(year, month - 1).toLocaleString('default', { month: 'long' }); // e.g., "January"
    const monthYear = `${monthName} ${year}`; // e.g., "January 2024"

    // Open a new window for printing
    const printWindow = window.open('', '', 'height=500,width=800');
    printWindow.document.write('<html><head><title>Print Payslip - ' + monthYear + '</title>');

    // Add some styles for printing
    printWindow.document.write(`
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .table { border-collapse: collapse; width: 100%; }
            .table th, .table td { padding: 8px; border: 1px solid #000; text-align: left; }
            .table th { background-color: #f2f2f2; }
            .payslip-header { margin-bottom: 20px; }
            .payslip-header h4 { margin: 0; font-size: 20px; }
            .payslip-header p { margin: 5px 0; }
            @media print {
                .fa-file-pdf { display: none; }
            }
        </style>
    `);

    printWindow.document.write('</head><body>');

    // Add company details
    printWindow.document.write(`
        <div class="payslip-header">
            <h4>${payslip.CompanyName ?? 'N/A'}</h4>
            <p>${payslip.AdminOffice_Address ?? 'N/A'}</p>
            <p><i class="fa fa-phone-alt"></i> ${payslip.PhoneNo1 ?? 'N/A'} <i class="fa fa-envelope"></i> ${payslip.EmailId1 ?? 'N/A'}</p>
        </div>
    `);

    // Add employee details
    printWindow.document.write(`
        <table class="table">
            <tbody>
                <tr><td><b>Employee Code:</b></td><td>${payslip.EmpCode ?? 'N/A'}</td></tr>
                <tr><td><b>Name:</b></td><td>${payslip.Fname ?? ''} ${payslip.Sname ?? ''} ${payslip.Lname ?? ''}</td></tr>
                <tr><td><b>Month:</b></td><td>${monthYear}</td></tr>
                <tr><td><b>Designation:</b></td><td>${payslip.DesigName ?? 'N/A'}</td></tr>
                <tr><td><b>Grade:</b></td><td>${payslip.GradeValue ?? 'N/A'}</td></tr>
                <tr><td><b>Gender:</b></td><td>${payslip.Gender ?? 'N/A'}</td></tr>
            </tbody>
        </table>
    `);

    // Earnings & Deductions table
    printWindow.document.write(`
        <table class="table">
            <thead>
                <tr style="background-color:#c5d3c1; text-align: center;">
                    <th colspan="2"><b>Earnings</b></th>
                    <th></th>  <!-- Empty column for vertical line -->
                    <th colspan="2"><b>Deductions</b></th>
                </tr>
                <tr style="background-color:#f1f1f1;">
                    <th><b>Components</b></th>
                    <th><b>Amount</b></th>
                    <th></th>
                    <th><b>Components</b></th>
                    <th><b>Amount</b></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>BASIC:</td>
                    <td>${payslip.Basic ?? 'N/A'}</td>
                    <td></td>
                    <td>PROVIDENT FUND:</td>
                    <td>${payslip.Tot_Pf ?? 'N/A'}</td>
                </tr>
                <tr>
                    <td>HOUSE RENT ALLOWANCE:</td>
                    <td>${payslip.Hra ?? 'N/A'}</td>
                    <td></td>
                    <td>ESIC:</td>
                    <td>${payslip.EsicNo ?? 'N/A'}</td>
                </tr>
                <tr style="background-color:#c5d3c1;">
                    <td><b>Total Earnings:</b></td>
                    <td><b>${payslip.Tot_Gross ?? 'N/A'}</b></td>
                    <td></td>
                    <td><b>Total Deductions:</b></td>
                    <td><b>${payslip.Tot_Deduct ?? 'N/A'}</b></td>
                </tr>
                <tr>
                    <td colspan="4"><b style="color:#B70000;">Net Pay:</b> Rs. <span>${payslip.Tot_NetAmount ?? 'N/A'}</span>/-</td>
                </tr>
            </tbody>
        </table>
    `);

    printWindow.document.write('</body></html>');
    printWindow.document.close();

    // Trigger print
    printWindow.print();
}