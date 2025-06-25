@component('mail::message')
<p><b>Dear {{$details['ITname']}},</b></p>
<p> {{$details['EmpName']}} has submitted asset request form, 
need next level approval from IT team 
for more details, kindly log on to

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
