@component('mail::message')
<p><b>Dear {{$details['ReportingManager']}},</b></p>
<p>{{$details['EmpName']}} has submitted leave application for</p>
<p><b>Leave </b> : {{$details['leavetype']}}</p>
<p><b>Duration :</b> {{$details['FromDate']}} To {{$details['ToDate']}}({{$details['TotalDays']}})days</p>

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
