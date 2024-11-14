  // Insert current year directly into the span element
  document.querySelector('#currentYear').textContent = new Date().getFullYear();

  document.addEventListener("DOMContentLoaded", function() {
    // Get the select element
    const monthSelect = document.getElementById("monthSelect");

    // Bind the change event to the select element
    monthSelect.addEventListener("change", function() {
        const payslipId = this.value; // Get the selected value (MonthlyPaySlipId)
        if (!payslipId) return;  // Do nothing if no month is selected

        // Call the existing function with the selected payslipId
        window.showPayslipDetails(Number(payslipId));
    });

    // Existing function to update the payslip data when a month is selected
    window.showPayslipDetails = function(payslipId) {
        if (event) event.preventDefault();  // Prevent default scroll behavior

        // Find the selected payslip data from the global payslipData array
        const payslip = window.payslipData;  // `payslipData` is injected via @json()

        // Find the selected payslip by ID
        const selectedPayslip = payslip.find(p => Number(p.MonthlyPaySlipId) === payslipId);

        // If a payslip is found, update the table content
        if (selectedPayslip) {
            const netPayWords = numberToWords(selectedPayslip.Tot_NetAmount);  // Assuming you have a numberToWords function
            console.log(netPayWords);

            // Update various fields with the selected payslip data
            document.getElementById("totalDays").innerText = selectedPayslip.TotalDay;
            document.getElementById("paidDays").innerText = selectedPayslip.PaidDay;
            document.getElementById("absentDays").innerText = selectedPayslip.Absent;
            document.getElementById("basicEarnings").innerText = selectedPayslip.Basic;
            document.getElementById("providentFund").innerText = selectedPayslip.Tot_Pf;
            document.getElementById("hra").innerText = selectedPayslip.Hra;
            document.getElementById("bonus").innerText = selectedPayslip.Bonus;
            document.getElementById("specialAllowance").innerText = selectedPayslip.Special;

            document.getElementById("totalEarnings").innerText = selectedPayslip.Tot_Gross;
            document.getElementById("totalDeductions").innerText = selectedPayslip.Tot_Deduct;
            document.getElementById("netPay").innerText = selectedPayslip.Tot_NetAmount;
            document.getElementById("netPayWords").innerText = netPayWords;
        }
    };
});



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
window.addEventListener('DOMContentLoaded', function() {
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
$(document).ready(function() {
  $('#salaryTable').DataTable();
});
