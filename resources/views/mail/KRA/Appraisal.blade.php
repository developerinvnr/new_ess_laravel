@component('mail::message')
<p><b>Dear {{$details['EmpName']}},</b></p>

<p>Your Reporting Manager, has successfully submitted your KRA for the year 2025–2026. 
For details, please visit the ESS portal at "vnrseeds.co.in.</p>

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
