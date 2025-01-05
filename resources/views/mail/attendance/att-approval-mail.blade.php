@component('mail::message')
<p><b>Dear {{$details['Empname']}},</b></p>
<p>Your reporting manager 
    has taken action on your attendance 
    authorization request in ESS, Please 
    login into ESS for taking necessary action.
</p>

<p>You may please visit @component('mail::button', ['url' => $details['site_link']])
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
