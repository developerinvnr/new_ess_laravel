// document.querySelector('#currentYear').textContent = new Date().getFullYear();

// Helper function to set the value and hide the row if the value is 0 or empty
document.addEventListener("DOMContentLoaded", function () {
    // Get the select element
    const monthSelect = document.getElementById("monthSelect");
    console.log(monthSelect);
    const selectedMonthElement = document.getElementById("selectedMonth");
    function formatNumber(value) {
        // Ensure the value is converted to a valid number
        const number = parseFloat(value || 0); // Default to 0 if value is null/undefined/falsey
    
        // Format the number in INR format
        return new Intl.NumberFormat('en-IN', { 
            maximumFractionDigits: 2,
            minimumFractionDigits: number % 1 === 0 ? 0 : 2 // Show decimals only if not an integer
        }).format(number);
    }
    
      // Remove months that have "no-data"
  function removeNoDataMonths() {
    const options = [...monthSelect.getElementsByTagName("option")];

    options.forEach(option => {
        if (option.dataset.status === "no-data") {
            option.remove(); // Remove from the dropdown
        }
    });
}
    
    // Existing function to update the payslip data when a month is selected
    window.showPayslipDetails = function (payslipId) {
        if (event) event.preventDefault();  // Prevent default scroll behavior


        // Get the payslip data
        const payslipData = window.payslipData;  // Assuming this is globally available
    
        // If payslipData is not an array, convert it to one
        const payslipArray = Array.isArray(payslipData) ? payslipData : Object.values(payslipData);
    
        // Find the selected payslip by ID
        const selectedPayslip = payslipArray.find(p => Number(p.MonthlyPaySlipId) === Number(payslipId));
        console.log(selectedPayslip);  // Log to see the result
    
        // If a payslip is found, update the table content
        if (selectedPayslip) {
            if (parseInt(selectedPayslip.Year) >= 2025) {
                console.log('Year is 2025 or later');
                var gradename = selectedPayslip.grade_name;
                var designation = selectedPayslip.designation_name;
                var hq = selectedPayslip.city_village_name;
            } else {
                console.log('Year is before 2025');
                var gradename = selectedPayslip.GradeValue;
                var designation = selectedPayslip.DesigName;
                var hq = selectedPayslip.HqName;
            }

            // Update various fields with the selected payslip data
            document.getElementById("totalDays").innerText = formatNumber(selectedPayslip.TotalDay || 0);
            document.getElementById("paiddays").innerText = formatNumber(selectedPayslip.PaidDay || 0);

                document.getElementById("grade").innerText = gradename || '-';
                document.getElementById("designation").innerText = designation 
                ? designation.charAt(0).toUpperCase() + designation.slice(1).toLowerCase() 
                : '-';
                document.getElementById("headQ").innerText = hq || '-';
                document.getElementById("hq").innerText = hq || '-';

        
               // Earnings
                setPayslipData("basicEarnings", formatNumber(selectedPayslip.Basic || 0));
                setPayslipData("hra", formatNumber(selectedPayslip.Hra || 0));
                setPayslipData("bonus", formatNumber(selectedPayslip.Bonus_Month || 0));
                setPayslipData("childeduAllowance", formatNumber(selectedPayslip.YCea || 0));
                setPayslipData("specialAllowance", formatNumber(selectedPayslip.Special || 0));
                setPayslipData("communicationAllowance", formatNumber(selectedPayslip.Communication_Allow || 0));
                setPayslipData("carAllowance", formatNumber(selectedPayslip.Car_Allow || 0));
                setPayslipData("leavetravelallowance", formatNumber(selectedPayslip.YLta || 0));
                setPayslipData("deputationAllow", formatNumber(selectedPayslip.Deputation_Allow || 0));
                setPayslipData("conveyanceAllowance", formatNumber(selectedPayslip.Convance || 0));
                setPayslipData("transportAllowance", formatNumber(selectedPayslip.TA || 0));
                setPayslipData("da", formatNumber(selectedPayslip.DA || 0));
                setPayslipData("leaveEncash", formatNumber(selectedPayslip.LeaveEncash || 0));
                setPayslipData("arrears", formatNumber(selectedPayslip.Arreares || 0));
                setPayslipData("incentive", formatNumber(selectedPayslip.Incentive || 0));
                setPayslipData("variableAdjustment", formatNumber(selectedPayslip.VariableAdjustment || 0));
                setPayslipData("performancePay", formatNumber(selectedPayslip.PerformancePay || 0));
                setPayslipData("performancePay_Yearly", formatNumber(selectedPayslip.PP_year || 0));
                setPayslipData("nps", formatNumber(selectedPayslip.NPS || 0));
                setPayslipData("noticePay", formatNumber(selectedPayslip.NoticePay || 0));
                setPayslipData("performanceIncentive", formatNumber(selectedPayslip.PP_Inc || 0));
                setPayslipData("cityCompensatoryAllowance", formatNumber(selectedPayslip.CCA || 0));
                setPayslipData("relocationAllowance", formatNumber(selectedPayslip.RA || 0));
                setPayslipData("variableReimbursement", formatNumber(selectedPayslip.VarRemburmnt || 0));
               // setPayslipData("carAllowance", formatNumber(selectedPayslip.Car_Allow || 0));
                setPayslipData("arrearCarAllowance", formatNumber(selectedPayslip.Car_Allowance_Arr || 0));
                setPayslipData("arrearBasic", formatNumber(selectedPayslip.Arr_Basic || 0));
                setPayslipData("arrearHra", formatNumber(selectedPayslip.Arr_Hra || 0));
                setPayslipData("arrearSpecialAllowance", formatNumber(selectedPayslip.Arr_Spl || 0));
                setPayslipData("arrearConveyance", formatNumber(selectedPayslip.Arr_Conv || 0));
                setPayslipData("arrearBonus", formatNumber(selectedPayslip.Arr_Bonus || 0));
                setPayslipData("bonusAdjustment", formatNumber(selectedPayslip.Bonus_Adjustment || 0));
                setPayslipData("arrearLtaReimbursement", formatNumber(selectedPayslip.Arr_LTARemb || 0));
                setPayslipData("arrearRelocationAllowance", formatNumber(selectedPayslip.Arr_RA || 0));
                setPayslipData("arrearPerformancePay", formatNumber(selectedPayslip.Arr_PP || 0));
                setPayslipData("arrearLvEncash", formatNumber(selectedPayslip.Arr_LvEnCash || 0));
                setPayslipData("arrcommallow", formatNumber(selectedPayslip.Arr_Communication_Allow || 0));


            // Deductions
            setPayslipData("tds", formatNumber(selectedPayslip.TDS || 0));
            setPayslipData("esic", formatNumber(selectedPayslip.ESCI_Employee || 0));
            setPayslipData("npsContribution", formatNumber(selectedPayslip.NPS_Value || 0));
            setPayslipData("arrearPf", formatNumber(selectedPayslip.Arr_Pf || 0));
            setPayslipData("arrearEsic", formatNumber(selectedPayslip.Arr_Esic || 0));
            setPayslipData("voluntaryContribution", formatNumber(selectedPayslip.VolContrib || 0));
            setPayslipData("deductionAdjustment", formatNumber(selectedPayslip.DeductAdjmt || 0));
            setPayslipData("recoveryConveyanceAllowance", formatNumber(selectedPayslip.RecConAllow || 0));
            setPayslipData("relocationAllowanceRecovery", formatNumber(selectedPayslip.RA_Recover || 0));
            setPayslipData("recoverySpecialAllowance", formatNumber(selectedPayslip.RecSplAllow || 0));
            setPayslipData("providentFund", formatNumber(selectedPayslip.Tot_Pf_Employee || 0));
            setPayslipData("IDCardRecovery", formatNumber(selectedPayslip.IDCard_Recovery || 0));

        
            // Initialize total earnings and total deductions variables
            let totalEarnings = 0;
            let totalDeductions = 0;

            // Earnings calculation
            totalEarnings += parseFloat(selectedPayslip.Basic || 0);
            totalEarnings += parseFloat(selectedPayslip.Hra || 0);
            totalEarnings += parseFloat(selectedPayslip.Bonus_Month || 0);
            totalEarnings += parseFloat(selectedPayslip.YCea || 0);
            totalEarnings += parseFloat(selectedPayslip.Special || 0);
            totalEarnings += parseFloat(selectedPayslip.YLta || 0);
            totalEarnings += parseFloat(selectedPayslip.Communication_Allow || 0);
            totalEarnings += parseFloat(selectedPayslip.Car_Allow || 0);
            totalEarnings += parseFloat(selectedPayslip.Convance || 0);
            totalEarnings += parseFloat(selectedPayslip.TA || 0);
            totalEarnings += parseFloat(selectedPayslip.DA || 0);
            totalEarnings += parseFloat(selectedPayslip.LeaveEncash || 0);
            totalEarnings += parseFloat(selectedPayslip.Arreares || 0);
            totalEarnings += parseFloat(selectedPayslip.Incentive || 0);
            totalEarnings += parseFloat(selectedPayslip.VariableAdjustment || 0);
            totalEarnings += parseFloat(selectedPayslip.PP_year || 0);
            totalEarnings += parseFloat(selectedPayslip.PerformancePay || 0);
            totalEarnings += parseFloat(selectedPayslip.NPS || 0);
            totalEarnings += parseFloat(selectedPayslip.NoticePay || 0);
            totalEarnings += parseFloat(selectedPayslip.PP_Inc || 0);
            totalEarnings += parseFloat(selectedPayslip.CCA || 0);
            totalEarnings += parseFloat(selectedPayslip.RA || 0);
            totalEarnings += parseFloat(selectedPayslip.VarRemburmnt || 0);
           // totalEarnings += parseFloat(selectedPayslip.Car_Allowance || 0);
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
            totalEarnings += parseFloat(selectedPayslip.Deputation_Allow || 0);
            totalEarnings += parseFloat(selectedPayslip.Arr_Communication_Allow || 0);


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
            totalDeductions += parseFloat(selectedPayslip.IDCard_Recovery || 0);


            // Update total earnings and total deductions
            document.getElementById("totalEarnings").innerText = formatNumber(totalEarnings);  
            document.getElementById("totalDeductions").innerText = formatNumber(totalDeductions);

            // Calculate net pay and update
            let netPay = totalEarnings - totalDeductions;
            document.getElementById("netPay").innerText = formatNumber(netPay);

            const netPayText = document.getElementById("netPay").innerText; // Fetch the Net Pay value as text
            const netPayAmount = parseFloat(netPayText.replace(/,/g, '')); // Remove commas and convert to a number
            const netPayInWords = numberToWords(netPayAmount);  // Convert the number to words
            console.log(netPayInWords);
        
            // Update the 'In Words' span with the converted value
           document.getElementById("netPayWords").innerText = netPayInWords + ' Rupees Only';
                }
    };
    function selectPreviousMonth() {
        const monthSelect = document.getElementById('monthSelect'); // Get the month select element
        const selectedMonthElement = document.getElementById('selectedMonth'); // Ensure this element exists to update the month name
    
        // Get all month options that are valid (not empty or with "no-data" status)
        const options = [...monthSelect.getElementsByTagName("option")]
                        .filter(opt => opt.value !== "" && opt.dataset.status !== "no-data");
    
        if (options.length > 0) {
            // Find the most recent available month (the last option in the filtered list)
            const lastAvailableOption = options[options.length - 1]; 

            // Update the select value to the last available option's value (MonthlyPaySlipId)
            monthSelect.value = lastAvailableOption.value;

            // Optionally, update the displayed month text somewhere on your page (if applicable)
            if (selectedMonthElement) {
                selectedMonthElement.innerText = lastAvailableOption.text; // Show the month abbreviation and year
            }

            // Trigger the function to load payslip details for the selected month
            window.showPayslipDetails(Number(lastAvailableOption.value)); // Pass the numeric value for the selected month
        }
    }
    
    removeNoDataMonths();
    // Call the function to select the previous month on page load
    selectPreviousMonth();

    // Bind the change event to the select element
    monthSelect.addEventListener("change", function () {
        const payslipId = this.value; // Get the selected value (MonthlyPaySlipId)
        if (!payslipId) return;  // Do nothing if no month is selected
       // Get all month options
       const monthOptions = monthSelect.getElementsByTagName("option");

       // Find the selected option based on the payslipId (it matches the value, not index)
       for (let i = 0; i < monthOptions.length; i++) {
           if (monthOptions[i].value === payslipId) {
               selectedMonthElement.innerText = monthOptions[i].text;
               break;
           }
       }
        // Call the existing function with the selected payslipId
        window.showPayslipDetails(Number(payslipId));
    });
});


function setPayslipData(elementId, value) {
    const element = document.getElementById(elementId);
    if (value === '0'|| value === '0.00' || value === null || value === '') {
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
    const netPayText = document.getElementById("netPay").innerText; // Fetch the Net Pay value as text
    const netPayAmount = parseFloat(netPayText.replace(/,/g, '')); // Remove commas and convert to a number
    const netPayInWords = numberToWords(netPayAmount);  // Convert the number to words
    console.log(netPayInWords);

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
