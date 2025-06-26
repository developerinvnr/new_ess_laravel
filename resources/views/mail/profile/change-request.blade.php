@component('mail::message')
<p>{{$details['EmpName']}} has raised a Change Request regarding their documents details to be change</b><br>
<b>EC:</b>{{$details['EC']}},<br>
<b>Subject:</b>{{$details['Subject']}},<br>
<b>Message:</b>{{$details['Message']}},<br>

for more details logged in to
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
