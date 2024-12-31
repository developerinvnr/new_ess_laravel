@component('mail::message')
<p><b>Dear {{$details['ReportingManager']}},</b></p>
<p>For your information attendance authorization request raised by:- </p>
<p><b>Team Member :</b> {{$details['EmpName']}}</p>
<p><b>Reason</b> : {{$details['reason']}}</p>
<br>

<p>You may please visit @component('mail::button', ['url' => $details['offer_link']])
       ESS
@endcomponent
for more details or to view the reporting approval status:</p>

<br>
<br>

<p>Regards,</p>
<p>From,</p>
<p>Admin</p>

<br>
<br>
<small>This is a system generated mail.</small>
@endcomponent
