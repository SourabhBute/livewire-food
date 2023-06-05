{{ header }}

<strong>Hello  {{ name }}!</strong> <br /><br />

You are receiving this email because we received a password reset request for your account. <br /><br />

The verification code is : <b>{{ otp }}</b>. OTP is valid for 5 minutes. <br/><br/>

<a href="{{ url }}" class="btn btn-primary">Link to the otp verification page.</a> <br /><br />

If you did not request a password reset, no further action is required. <br /><br />

Regards, <br />

<strong>{{ site_title }}</strong>

{{ footer }}
