@component('mail::message')
<p><b>Dear {{$details['ReportingName']}}</b></p>
<p>{{$details['EmpName']}} Separation Logictics NOC Clearance </p>
<p><b>Department Name </b> : {{$details['DepartmentName']}}</p>
<p><b>Designation name </b> : {{$details['DesigName']}}</p>
<p>The Logistics clearance of <b>{{$details['EmpName']}}</b> has been verified by logistics department. 
Log on to ESS for further details

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
