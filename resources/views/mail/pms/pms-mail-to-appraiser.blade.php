@component('mail::message')
<p>Dear Sir/Mam,</p>
<p>{{$details['EmpName']}}  has submitted Appraisal Form </p>
<p><b>Emp Code:  </b> {{$details['EmpCode']}}</p>
<p><b>Department Name:  </b> {{$details['departmentname']}}</p>
<p><b>Designation Name:</b> {{$details['designationame']}}</p>

<p>You are required to Appraise as per PMS Schedule. For more details Kindly log on to ESS.</p>

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
