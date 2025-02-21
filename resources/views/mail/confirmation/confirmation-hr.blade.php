@component('mail::message')
<p><b>Dear HR Team,</b></p>
<p>Confirmation of {{$details['EmpName']}} has been actioned By Reporting</p>
<p>EmpCode - {{$details['EmpCode']}}</p>
<p>Please review the submission at your earliest conveniene. for further details please visit</p>

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
