<!DOCTYPE html>
<html>
<head>
    <title>Query Submitted</title>
</head>
<body>
    <h1>Query Submitted</h1>
    <p>Employee ID: {{ $queryData['EmployeeID'] }}</p>
    <p>Department ID: {{ $queryData['QToDepartmentId'] }}</p>
    <p>Query Subject: {{ $queryData['QuerySubject'] }}</p>
    <p>Remarks: {{ $queryData['QueryValue'] }}</p>
    <!-- Add more fields as necessary -->
</body>
</html>
