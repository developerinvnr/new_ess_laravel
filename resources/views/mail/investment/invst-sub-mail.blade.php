@component('mail::message')
<p><b>Dear {{$details['EmpName']}},</b></p>
<p>You have successfully submitted investment submission form in period-{{$details['Period']}}</p>

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
