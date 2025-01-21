@component('mail::message')
<p><b>Dear Sir/Mam,</b></p>
<p>{{$details['EmpName']}} Separation approval status</p>
<p><b>Department Name </b> : {{$details['DepartmentName']}}</p>
<p><b>Designation name </b> : {{$details['DesigName']}}</p>
<p>Resignation Application From Level-1 Reporting Manager".{{$details['EmpName']}} has {{$details['Action']}}
resignation application, for more details kindly log on

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
