@component('mail::message')
<p><b>Dear {{$details['EmpName']}},</b></p>
<p>  You have successfully submitted the KRA for the year 2025-2026</p>

<p>For further details please visit</p>

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
