@component('mail::message')
<p><b>Dear Sir/Mam,</b></p>
<p>Exit Interview form from Reporting Manager</p>
<p>{{$details['EmpName']}}</p>
<p><b>Department Name </b> : {{$details['DepartmentName']}}</p>
<p><b>Designation name </b> : {{$details['DesigName']}}</p>
<p>Exit Interview form from Reporting Manager for {{$details['EmpName']}} has been submmitted
 for more details kindly log on

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
