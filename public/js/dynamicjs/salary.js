// Insert current year directly into the span element
document.querySelector('#currentYear').textContent = new Date().getFullYear();


    // document.addEventListener("DOMContentLoaded", function () {
    //     // Get the select element
    //     const monthSelect = document.getElementById("monthSelect");
    //     console.log(monthSelect);
    
    //     // Function to automatically select the previous month
    //     function selectPreviousMonth() {
    //         const currentDate = new Date();
    //         let currentMonthIndex = currentDate.getMonth(); // 0 for January, 1 for February, ...
    
    //         // Find the previous month's index
    //         const previousMonthIndex = currentMonthIndex === 0 ? 11 : currentMonthIndex - 1; // December is index 11
    
    //         // Get all month options
    //         const monthOptions = monthSelect.getElementsByTagName("option");
    
    //         // Set the value of the select element to the previous month
    //         monthSelect.value = monthOptions[previousMonthIndex + 1].value;  // Add 1 because options are 1-indexed for months
    
    //         // Call the function to load the payslip details for the selected month
    //         window.showPayslipDetails(Number(monthSelect.value));
    //     }
    
    //     // Call the function to select the previous month on page load
    //     selectPreviousMonth();
    
    //     // Bind the change event to the select element
    //     monthSelect.addEventListener("change", function () {
    //         const payslipId = this.value; // Get the selected value (MonthlyPaySlipId)
    //         if (!payslipId) return;  // Do nothing if no month is selected
    
    //         // Call the existing function with the selected payslipId
    //         window.showPayslipDetails(Number(payslipId));
    //     });
    
    //     // Existing function to update the payslip data when a month is selected
    //     window.showPayslipDetails = function (payslipId) {
    //         if (event) event.preventDefault();  // Prevent default scroll behavior
    
    //         // Find the selected payslip data from the global payslipData array
    //         const payslip = window.payslipData;  // `payslipData` is injected via @json()
    
    //         // Find the selected payslip by ID
    //         const selectedPayslip = payslip.find(p => Number(p.MonthlyPaySlipId) === payslipId);
    //         console.log(selectedPayslip);
    
    //         // If a payslip is found, update the table content
    //         if (selectedPayslip) {
    
    //             // Update various fields with the selected payslip data
    //             document.getElementById("totalDays").innerText = selectedPayslip.TotalDay;
    //             document.getElementById("paidDays").innerText = selectedPayslip.PaidDay;
    //             document.getElementById("absentDays").innerText = selectedPayslip.Absent;
    //             // Earnings
    //             setPayslipData("basicEarnings", selectedPayslip.Basic);
    //             setPayslipData("hra", selectedPayslip.Hra);
    //             setPayslipData("bonus", selectedPayslip.Bonus_Month);
    //             setPayslipData("specialAllowance", selectedPayslip.Special);
    //             setPayslipData("conveyanceAllowance", selectedPayslip.Convance);
    //             setPayslipData("transportAllowance", selectedPayslip.TA);
    //             setPayslipData("da", selectedPayslip.DA);
    //             setPayslipData("leaveEncash", selectedPayslip.LeaveEncash);
    //             setPayslipData("arrears", selectedPayslip.Arreares);
    //             setPayslipData("incentive", selectedPayslip.Incentive);
    //             setPayslipData("variableAdjustment", selectedPayslip.VariableAdjustment);
    //             setPayslipData("performancePay", selectedPayslip.PerformancePay);
    //             setPayslipData("nps", selectedPayslip.NPS);
    //             setPayslipData("noticePay", selectedPayslip.NoticePay);
    //             setPayslipData("performanceIncentive", selectedPayslip.PP_Inc);
    //             setPayslipData("cityCompensatoryAllowance", selectedPayslip.CCA);
    //             setPayslipData("relocationAllowance", selectedPayslip.RA);
    //             setPayslipData("variableReimbursement", selectedPayslip.VarRemburmnt);
    //             setPayslipData("carAllowance", selectedPayslip.Car_Allowance);
    //             setPayslipData("arrearCarAllowance", selectedPayslip.Car_Allowance_Arr);
    //             setPayslipData("arrearBasic", selectedPayslip.Arr_Basic);
    //             setPayslipData("arrearHra", selectedPayslip.Arr_Hra);
    //             setPayslipData("arrearSpecialAllowance", selectedPayslip.Arr_Spl);
    //             setPayslipData("arrearConveyance", selectedPayslip.Arr_Conv);
    //             setPayslipData("arrearBonus", selectedPayslip.Arr_Bonus);
    //             setPayslipData("bonusAdjustment", selectedPayslip.Bonus_Adjustment);
    //             setPayslipData("arrearLtaReimbursement", selectedPayslip.Arr_LTARemb);
    //             setPayslipData("arrearRelocationAllowance", selectedPayslip.Arr_RA);
    //             setPayslipData("arrearPerformancePay", selectedPayslip.Arr_PP);
    //             setPayslipData("arrearLvEncash", selectedPayslip.Arr_LvEnCash);
    
    //             // Deductions
    //             setPayslipData("tds", selectedPayslip.TDS);
    //             setPayslipData("esic", selectedPayslip.ESCI_Employee);
    //             setPayslipData("npsContribution", selectedPayslip.NPS_Value);
    //             setPayslipData("arrearPf", selectedPayslip.Arr_Pf);
    //             setPayslipData("arrearEsic", selectedPayslip.Arr_Esic);
    //             setPayslipData("voluntaryContribution", selectedPayslip.VolContrib);
    //             setPayslipData("deductionAdjustment", selectedPayslip.DeductAdjmt);
    //             setPayslipData("recoveryConveyanceAllowance", selectedPayslip.RecConAllow);
    //             setPayslipData("relocationAllowanceRecovery", selectedPayslip.RA_Recover);
    //             setPayslipData("recoverySpecialAllowance", selectedPayslip.RecSplAllow);
    //             setPayslipData("providentFund", selectedPayslip.Tot_Pf_Employee);
    
    //             // Initialize total earnings and total deductions variables
    //             let totalEarnings = 0;
    //             let totalDeductions = 0;
    
    //             // Earnings calculation
    //             totalEarnings += parseFloat(selectedPayslip.Basic || 0);
    //             totalEarnings += parseFloat(selectedPayslip.Hra || 0);
    //             totalEarnings += parseFloat(selectedPayslip.Bonus_Month || 0);
    //             totalEarnings += parseFloat(selectedPayslip.Special || 0);
    //             totalEarnings += parseFloat(selectedPayslip.Convance || 0);
    //             totalEarnings += parseFloat(selectedPayslip.TA || 0);
    //             totalEarnings += parseFloat(selectedPayslip.DA || 0);
    //             totalEarnings += parseFloat(selectedPayslip.LeaveEncash || 0);
    //             totalEarnings += parseFloat(selectedPayslip.Arreares || 0);
    //             totalEarnings += parseFloat(selectedPayslip.Incentive || 0);
    //             totalEarnings += parseFloat(selectedPayslip.VariableAdjustment || 0);
    //             totalEarnings += parseFloat(selectedPayslip.PerformancePay || 0);
    //             totalEarnings += parseFloat(selectedPayslip.NPS || 0);
    //             totalEarnings += parseFloat(selectedPayslip.NoticePay || 0);
    //             totalEarnings += parseFloat(selectedPayslip.PP_Inc || 0);
    //             totalEarnings += parseFloat(selectedPayslip.CCA || 0);
    //             totalEarnings += parseFloat(selectedPayslip.RA || 0);
    //             totalEarnings += parseFloat(selectedPayslip.VarRemburmnt || 0);
    //             totalEarnings += parseFloat(selectedPayslip.Car_Allowance || 0);
    //             totalEarnings += parseFloat(selectedPayslip.Car_Allowance_Arr || 0);
    //             totalEarnings += parseFloat(selectedPayslip.Arr_Basic || 0);
    //             totalEarnings += parseFloat(selectedPayslip.Arr_Hra || 0);
    //             totalEarnings += parseFloat(selectedPayslip.Arr_Spl || 0);
    //             totalEarnings += parseFloat(selectedPayslip.Arr_Conv || 0);
    //             totalEarnings += parseFloat(selectedPayslip.Arr_Bonus || 0);
    //             totalEarnings += parseFloat(selectedPayslip.Bonus_Adjustment || 0);
    //             totalEarnings += parseFloat(selectedPayslip.Arr_LTARemb || 0);
    //             totalEarnings += parseFloat(selectedPayslip.Arr_RA || 0);
    //             totalEarnings += parseFloat(selectedPayslip.Arr_PP || 0);
    //             totalEarnings += parseFloat(selectedPayslip.Arr_LvEnCash || 0);
    
    //             // Deductions calculation
    //             totalDeductions += parseFloat(selectedPayslip.TDS || 0);
    //             totalDeductions += parseFloat(selectedPayslip.ESCI_Employee || 0);
    //             totalDeductions += parseFloat(selectedPayslip.NPS_Value || 0);
    //             totalDeductions += parseFloat(selectedPayslip.Arr_Pf || 0);
    //             totalDeductions += parseFloat(selectedPayslip.Arr_Esic || 0);
    //             totalDeductions += parseFloat(selectedPayslip.VolContrib || 0);
    //             totalDeductions += parseFloat(selectedPayslip.DeductAdjmt || 0);
    //             totalDeductions += parseFloat(selectedPayslip.RecConAllow || 0);
    //             totalDeductions += parseFloat(selectedPayslip.RA_Recover || 0);
    //             totalDeductions += parseFloat(selectedPayslip.RecSplAllow || 0);
    //             totalDeductions += parseFloat(selectedPayslip.Tot_Pf_Employee || 0);
    
    //             // Update total earnings and total deductions
    //             document.getElementById("totalEarnings").innerText = totalEarnings.toFixed(2);  // Display total earnings
    //             document.getElementById("totalDeductions").innerText = totalDeductions.toFixed(2); // Display total deductions
    
    //             // Calculate net pay and update
    //             let netPay = totalEarnings - totalDeductions;
    //             document.getElementById("netPay").innerText = netPay.toFixed(2);
    //             const netPayWords = numberToWords(netPay);  // Assuming you have a numberToWords function
    
    //             document.getElementById("netPayWords").innerText = netPayWords;
    //         }
    //     };
    // });
    



// Helper function to set the value and hide the row if the value is 0 or empty
document.addEventListener("DOMContentLoaded", function () {
    // Get the select element
    const monthSelect = document.getElementById("monthSelect");
    console.log(monthSelect);


    // Existing function to update the payslip data when a month is selected
    window.showPayslipDetails = function (payslipId) {
        if (event) event.preventDefault();  // Prevent default scroll behavior

        // Find the selected payslip data from the global payslipData array
        const payslip = window.payslipData;  // `payslipData` is injected via @json()

        // Find the selected payslip by ID
        const selectedPayslip = payslip.find(p => Number(p.MonthlyPaySlipId) === payslipId);

        // If a payslip is found, update the table content
        if (selectedPayslip) {

            // Update various fields with the selected payslip data
            document.getElementById("totalDays").innerText = selectedPayslip.TotalDay;
            document.getElementById("paidDays").innerText = selectedPayslip.PaidDay;
            document.getElementById("absentDays").innerText = selectedPayslip.Absent;
            // Earnings
            setPayslipData("basicEarnings", selectedPayslip.Basic);
            setPayslipData("hra", selectedPayslip.Hra);
            setPayslipData("bonus", selectedPayslip.Bonus_Month);
            setPayslipData("specialAllowance", selectedPayslip.Special);
            setPayslipData("conveyanceAllowance", selectedPayslip.Convance);
            setPayslipData("transportAllowance", selectedPayslip.TA);
            setPayslipData("da", selectedPayslip.DA);
            setPayslipData("leaveEncash", selectedPayslip.LeaveEncash);
            setPayslipData("arrears", selectedPayslip.Arreares);
            setPayslipData("incentive", selectedPayslip.Incentive);
            setPayslipData("variableAdjustment", selectedPayslip.VariableAdjustment);
            setPayslipData("performancePay", selectedPayslip.PerformancePay);
            setPayslipData("nps", selectedPayslip.NPS);
            setPayslipData("noticePay", selectedPayslip.NoticePay);
            setPayslipData("performanceIncentive", selectedPayslip.PP_Inc);
            setPayslipData("cityCompensatoryAllowance", selectedPayslip.CCA);
            setPayslipData("relocationAllowance", selectedPayslip.RA);
            setPayslipData("variableReimbursement", selectedPayslip.VarRemburmnt);
            setPayslipData("carAllowance", selectedPayslip.Car_Allowance);
            setPayslipData("arrearCarAllowance", selectedPayslip.Car_Allowance_Arr);
            setPayslipData("arrearBasic", selectedPayslip.Arr_Basic);
            setPayslipData("arrearHra", selectedPayslip.Arr_Hra);
            setPayslipData("arrearSpecialAllowance", selectedPayslip.Arr_Spl);
            setPayslipData("arrearConveyance", selectedPayslip.Arr_Conv);
            setPayslipData("arrearBonus", selectedPayslip.Arr_Bonus);
            setPayslipData("bonusAdjustment", selectedPayslip.Bonus_Adjustment);
            setPayslipData("arrearLtaReimbursement", selectedPayslip.Arr_LTARemb);
            setPayslipData("arrearRelocationAllowance", selectedPayslip.Arr_RA);
            setPayslipData("arrearPerformancePay", selectedPayslip.Arr_PP);
            setPayslipData("arrearLvEncash", selectedPayslip.Arr_LvEnCash);

            // Deductions
            setPayslipData("tds", selectedPayslip.TDS);
            setPayslipData("esic", selectedPayslip.ESCI_Employee);
            setPayslipData("npsContribution", selectedPayslip.NPS_Value);
            setPayslipData("arrearPf", selectedPayslip.Arr_Pf);
            setPayslipData("arrearEsic", selectedPayslip.Arr_Esic);
            setPayslipData("voluntaryContribution", selectedPayslip.VolContrib);
            setPayslipData("deductionAdjustment", selectedPayslip.DeductAdjmt);
            setPayslipData("recoveryConveyanceAllowance", selectedPayslip.RecConAllow);
            setPayslipData("relocationAllowanceRecovery", selectedPayslip.RA_Recover);
            setPayslipData("recoverySpecialAllowance", selectedPayslip.RecSplAllow);
            setPayslipData("providentFund", selectedPayslip.Tot_Pf_Employee);

            // Initialize total earnings and total deductions variables
            let totalEarnings = 0;
            let totalDeductions = 0;

            // Earnings calculation
            totalEarnings += parseFloat(selectedPayslip.Basic || 0);
            totalEarnings += parseFloat(selectedPayslip.Hra || 0);
            totalEarnings += parseFloat(selectedPayslip.Bonus_Month || 0);
            totalEarnings += parseFloat(selectedPayslip.Special || 0);
            totalEarnings += parseFloat(selectedPayslip.Convance || 0);
            totalEarnings += parseFloat(selectedPayslip.TA || 0);
            totalEarnings += parseFloat(selectedPayslip.DA || 0);
            totalEarnings += parseFloat(selectedPayslip.LeaveEncash || 0);
            totalEarnings += parseFloat(selectedPayslip.Arreares || 0);
            totalEarnings += parseFloat(selectedPayslip.Incentive || 0);
            totalEarnings += parseFloat(selectedPayslip.VariableAdjustment || 0);
            totalEarnings += parseFloat(selectedPayslip.PerformancePay || 0);
            totalEarnings += parseFloat(selectedPayslip.NPS || 0);
            totalEarnings += parseFloat(selectedPayslip.NoticePay || 0);
            totalEarnings += parseFloat(selectedPayslip.PP_Inc || 0);
            totalEarnings += parseFloat(selectedPayslip.CCA || 0);
            totalEarnings += parseFloat(selectedPayslip.RA || 0);
            totalEarnings += parseFloat(selectedPayslip.VarRemburmnt || 0);
            totalEarnings += parseFloat(selectedPayslip.Car_Allowance || 0);
            totalEarnings += parseFloat(selectedPayslip.Car_Allowance_Arr || 0);
            totalEarnings += parseFloat(selectedPayslip.Arr_Basic || 0);
            totalEarnings += parseFloat(selectedPayslip.Arr_Hra || 0);
            totalEarnings += parseFloat(selectedPayslip.Arr_Spl || 0);
            totalEarnings += parseFloat(selectedPayslip.Arr_Conv || 0);
            totalEarnings += parseFloat(selectedPayslip.Arr_Bonus || 0);
            totalEarnings += parseFloat(selectedPayslip.Bonus_Adjustment || 0);
            totalEarnings += parseFloat(selectedPayslip.Arr_LTARemb || 0);
            totalEarnings += parseFloat(selectedPayslip.Arr_RA || 0);
            totalEarnings += parseFloat(selectedPayslip.Arr_PP || 0);
            totalEarnings += parseFloat(selectedPayslip.Arr_LvEnCash || 0);

            // Deductions calculation
            totalDeductions += parseFloat(selectedPayslip.TDS || 0);
            totalDeductions += parseFloat(selectedPayslip.ESCI_Employee || 0);
            totalDeductions += parseFloat(selectedPayslip.NPS_Value || 0);
            totalDeductions += parseFloat(selectedPayslip.Arr_Pf || 0);
            totalDeductions += parseFloat(selectedPayslip.Arr_Esic || 0);
            totalDeductions += parseFloat(selectedPayslip.VolContrib || 0);
            totalDeductions += parseFloat(selectedPayslip.DeductAdjmt || 0);
            totalDeductions += parseFloat(selectedPayslip.RecConAllow || 0);
            totalDeductions += parseFloat(selectedPayslip.RA_Recover || 0);
            totalDeductions += parseFloat(selectedPayslip.RecSplAllow || 0);
            totalDeductions += parseFloat(selectedPayslip.Tot_Pf_Employee || 0);

            // Update total earnings and total deductions
            document.getElementById("totalEarnings").innerText = totalEarnings.toFixed(2);  // Display total earnings
            document.getElementById("totalDeductions").innerText = totalDeductions.toFixed(2); // Display total deductions

            // Calculate net pay and update
            let netPay = totalEarnings - totalDeductions;
            document.getElementById("netPay").innerText = netPay.toFixed(2);
            const netPayWords = numberToWords(netPay);  // Assuming you have a numberToWords function

            document.getElementById("netPayWords").innerText = netPayWords;
        }
    };
      // Function to automatically select the previous month
      function selectPreviousMonth() {
        const currentDate = new Date();
        let currentMonthIndex = currentDate.getMonth(); // 0 for January, 1 for February, ...

        // Find the previous month's index
        const previousMonthIndex = currentMonthIndex === 0 ? 11 : currentMonthIndex - 1; // December is index 11

        // Get all month options
        const monthOptions = monthSelect.getElementsByTagName("option");

        // Set the value of the select element to the previous month
        monthSelect.value = monthOptions[previousMonthIndex + 1].value;  // Add 1 because options are 1-indexed for months

        // Call the function to load the payslip details for the selected month
        window.showPayslipDetails(Number(monthSelect.value));
    }

    // Call the function to select the previous month on page load
    selectPreviousMonth();

    // Bind the change event to the select element
    monthSelect.addEventListener("change", function () {
        const payslipId = this.value; // Get the selected value (MonthlyPaySlipId)
        if (!payslipId) return;  // Do nothing if no month is selected

        // Call the existing function with the selected payslipId
        window.showPayslipDetails(Number(payslipId));
    });
});


function setPayslipData(elementId, value) {
    const element = document.getElementById(elementId);
    if (value === 0 || value === '0.00' || value === null || value === '') {
        element.closest('tr').style.display = 'none'; // Hide the entire row
    } else {
        element.closest('tr').style.display = ''; // Show the row
        element.innerText = value || 'N/A'; // Set the value or default to 'N/A'
    }
}
function numberToWords(num) {
    const words = {
        0: '', 1: 'one', 2: 'two', 3: 'three', 4: 'four', 5: 'five',
        6: 'six', 7: 'seven', 8: 'eight', 9: 'nine', 10: 'ten',
        11: 'eleven', 12: 'twelve', 13: 'thirteen', 14: 'fourteen',
        15: 'fifteen', 16: 'sixteen', 17: 'seventeen', 18: 'eighteen', 19: 'nineteen',
        20: 'twenty', 30: 'thirty', 40: 'forty', 50: 'fifty', 60: 'sixty',
        70: 'seventy', 80: 'eighty', 90: 'ninety', 100: 'hundred',
        1000: 'thousand', 100000: 'lakh', 10000000: 'crore'
    };

    if (num === 0) return '';

    let result = '';
    let highNo = num;
    let remainNo = 0;
    let value = 100;  // Starting with 100 (Hundred)
    let value1 = 1000; // Then Thousand

    // Loop to break the number into Indian system values (Hundred, Thousand, Lakh, Crore)
    while (num >= 100) {
        if ((value <= num) && (num < value1)) {
            result = words[value];
            highNo = Math.floor(num / value);  // Get the quotient for the current place value
            remainNo = num % value;  // Get the remainder
            break;
        }
        value = value1;
        value1 = value * 100;
    }

    // If the number is found in the words dictionary, return the word with the appropriate place value
    if (words[highNo]) {
        result = words[highNo] + ' ' + result + ' ' + numberToWords(remainNo);
    } else {
        // If the number is not directly in the dictionary, split it into tens and ones
        const unit = highNo % 10;
        const ten = Math.floor(highNo / 10) * 10;
        result = words[ten] + ' ' + words[unit] + ' ' + result + ' ' + numberToWords(remainNo);
    }

    // Capitalize the first letter of the result
    return capitalizeFirstLetter(result.trim());
}

function capitalizeFirstLetter(str) {
    if (!str) return str;
    return str.charAt(0).toUpperCase() + str.slice(1);
}

// Wait for the DOM to load before running the script
window.addEventListener('DOMContentLoaded', function () {
    const netPayAmount = parseFloat(document.getElementById("netPay").innerText);  // Fetch the Net Pay value
    const netPayInWords = numberToWords(netPayAmount);  // Convert the number to words

    // Update the 'In Words' span with the converted value
    document.getElementById("netPayWords").innerText = netPayInWords + ' Rupees Only';
});

function printPayslip() {
    // Get the payslip content
    var payslipContent = document.querySelector('.card-body.table-responsive').innerHTML;

    // Open a new window for printing
    var printWindow = window.open('', '', 'height=500,width=800');

    printWindow.document.write('<html><head><title>Print Payslip</title>');

    // Add CSS for printing inside the head tag
    printWindow.document.write(`
        <style>
            body { font-family: Arial, sans-serif; }
            .table { border-collapse: collapse; width: 100%; }
            .table th, .table td { padding: 8px; border: 1px solid #000; text-align: left; }
            .table th { background-color: #f2f2f2; }
            .payslip-logo { width: 100px; }
            @media print {
                .fa-print { display: none; } /* Hide the print button */
                body { font-size: 12px; }
                .header, .footer, .sidebar { display: none; }
            }
        </style>
    `);

    printWindow.document.write('</head><body>');

    // Write the payslip content into the new window
    printWindow.document.write('<h2>PaySlip</h2>');
    printWindow.document.write(payslipContent);  // Add the payslip content here

    printWindow.document.write('</body></html>');

    // Close the document to trigger rendering
    printWindow.document.close();

    // Wait for the content to load and then print
    printWindow.onload = function () {
        printWindow.print();
    };
}
$(document).ready(function () {
    $('#salaryTable').DataTable();
});
