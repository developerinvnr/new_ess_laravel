@component('mail::message')
<p><b>Dear {{$details['ReportingManager']}},</b></p>
<p>{{$details['EmpName']}} has cancelled leave application for</p>
<p><b>Leave </b> : {{$details['leavetype']}}</p>
<p><b>Duration :</b> {{$details['FromDate']}} To {{$details['ToDate']}}({{$details['TotalDays']}})days</p>

<p>Please review the request at your earliest conveniene. for further details please visit</p>

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
