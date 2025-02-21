@component('mail::message')
<p>Employee {{$details['EmpName']}} has raised a query about Subject-<b>{{$details['Subject']}}</b> 
raised to Department-<b>{{$details['DepartmentName']}}</b><br>
Kindly Take action withing 3 days.
for more details logged in to 
</p>

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent