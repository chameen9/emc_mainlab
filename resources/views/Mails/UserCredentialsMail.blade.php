@component('mail::message')

# 👨🏻‍💻 Your user account credentials

Here are your account credentials for **EMC Main Lab**:

---

**👤 Name:** {{ $user->name }}  
**📧 Email:** {{ $user->email }}  
**🔑 Password:** {{ $password }}

---

@component('mail::button', ['url' => 'https://emcgalle.payzlite.net/login'])
Visit EMC Main Lab !
@endcomponent

We recommend that you change your password after logging in for the first time.
(Profile -> Change Password)

Best regards,  
**ESOFT Metro Campus Galle**
@endcomponent