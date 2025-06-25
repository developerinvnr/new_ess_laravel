@component('mail::message')
<p><b>Dear {{$details['ReviewerName']}},</b></p>

<p>
Your Reporting Manager has reverted your team {{$details['EmpName']}}
KRA for the year 2025–2026 with the <b>Reason:</b> {{$details['Reason']}}
For details, please visit the ESS portal at vnrseeds.co.in."
</p>

@component('mail::button', ['url' => $details['site_link']])
       ESS
@endcomponent

<p>Regards,</p>
<p>ESS Web Admin</p>

<br>
<br>
<small>*Please do not reply to this email. This is an automated message, and responses cannot be received by our system.</small>
@endcomponent
