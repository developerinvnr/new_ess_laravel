@component('mail::message')
<p><b>Dear HR team,</b></p>
<p><b>{{$details['EmpName']}}</b> has successfully Declared investment declaration form form for a period-{{$details['Period']}}</p>

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
