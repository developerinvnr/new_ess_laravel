@component('mail::message')
<p>Dear {{$details['EmpName']}},</p>

<p>Your appraisal form has been reversed by your reporting manager for necessary corrections</p>
<p>For more details Kindly log on to ESS.</p>

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
