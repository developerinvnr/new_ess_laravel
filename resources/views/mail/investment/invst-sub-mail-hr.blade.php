@component('mail::message')
<p><b>Dear HR team,</b></p>
<p>{{$details['EmpName']}}has successfully submitted investment submission form in period-{{$details['Period']}}</p>

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
