@component('mail::message')
<p><b>Dear {{$details['ForwardedName']}},</b></p>
<p>Query has been forwarded to you <br>
Emp Name- <b>{{$details['EmpName']}}</b><br>
Subject-<b>{{$details['Subject']}}</b> <br>
Department-<b>{{$details['DepartmentName']}}</b> <br>

</b><br>
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
