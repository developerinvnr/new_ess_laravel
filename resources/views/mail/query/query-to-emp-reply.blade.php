@component('mail::message')
<p><b>Dear {{$details['EmpName']}},</b></p>
<p>Your Query has been replied on Subject-<b>{{$details['Subject']}}</b> 
raised to Department-<b>{{$details['DepartmentName']}}</b><br>
for more details logged in to </p>

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
