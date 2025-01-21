@component('mail::message')
<p><b>Dear {{$details['Hrname']}},</b></p>
<p>Account Section has been revert the seperation clearance form back to you kindly get back to it </p>
<p><b>Employee Name </b> : {{$details['EmployeeName']}}</p>

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
