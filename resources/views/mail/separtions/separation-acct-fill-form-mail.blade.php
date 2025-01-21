@component('mail::message')
<p>{{$details['EmpName']}} Separation Account NOC Clearance </p>
<p><b>Department Name </b> : {{$details['DepartmentName']}}</p>
<p><b>Designation name </b> : {{$details['DesigName']}}</p>
<p>Finance has submitted the accounts statement for {{$details['EmpName']}}
Log on to ESS for further details.

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
