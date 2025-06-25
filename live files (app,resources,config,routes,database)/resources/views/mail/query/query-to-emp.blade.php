@component('mail::message')
<p><b>Dear {{$details['EmpName']}},</b></p>
<p>We have recieved your query about Subject-<b>{{$details['Subject']}}</b> 
raised to Department-<b>{{$details['DepartmentName']}}</b><br>
We have forwarded the same to appropriate owner and a reply shall be sent soon
for more details logged in to </p>

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
