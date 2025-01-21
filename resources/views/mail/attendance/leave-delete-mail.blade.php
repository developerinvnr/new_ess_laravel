@component('mail::message')
<p><strong>Dear {{$details['ReportingManager']}},</strong></p>

<p>{{$details['EmpName']}} has deleted their leave application for the following:</p>
<p><strong>Leave Type:</strong> {{$details['leavetype']}}</p>
<p><strong>Requested Dates:</strong> {{$details['FromDate']}} to {{$details['ToDate']}}</p>

@component('mail::button', ['url' => $details['site_link']])
ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
