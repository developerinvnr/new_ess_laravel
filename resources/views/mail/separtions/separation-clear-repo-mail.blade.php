@component('mail::message')
<p><b>Dear Sir/Mam,</b></p>
<p>NOC Department Clearance </p>
<p>The departmental clearance form of {{$details['EmpName']}} has been submitted by reporting manager.
<p><b>Department Name </b> : {{$details['DepartmentName']}}</p>
<p><b>Designation name </b> : {{$details['DesigName']}}</p>
<p>For details kindly log on to</p>

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent

