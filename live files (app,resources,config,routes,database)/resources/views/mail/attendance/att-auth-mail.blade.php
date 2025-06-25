@component('mail::message')
<p><b>Dear {{$details['ReportingManager']}},</b></p>
<p>This is to inform you that your team member has requested for attendance authorization.on  {{$details['RequestedDate']}} Below are the details of the request:</p>
<p><b>Requested By :</b> {{$details['EmpName']}}</p>
<p><b>Reason</b> : {{$details['reason']}}</p>

<p>Please review the request at your earliest conveniene. for further details please visit</p>

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>If the ESS button is not working, please click the link below to access it directly</p>
<a href="https://vnrseeds.co.in">https://vnrseeds.co.in</a>
<br>
<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
