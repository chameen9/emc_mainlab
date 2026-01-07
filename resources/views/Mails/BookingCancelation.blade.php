@component('mail::message')

# ❌ Booking Cancelled

This email is to inform you that your reservation at **EMC Main Lab** has been **cancelled**.
Please do not attend the lab for this booking.

@component('mail::panel')
## 📋 Cancelled Booking Details

**🧑🏻‍🎓 Student ID:** {{ explode(' ', $booking->title)[0] }}  
**📘 Module:** {{ $booking->module }}  
**👥 Batch:** {{ $booking->batch }}

---

**📆 Date:** {{ \Carbon\Carbon::parse($booking->start)->format('Y-m-d') }}  
**⏰ Time:** {{ \Carbon\Carbon::parse($booking->start)->format('H:i') }} to {{ \Carbon\Carbon::parse($booking->end)->format('H:i') }}

---

**🏫 Lab:** {{ $booking->lab->lab_name }}  
**💻 Computer:** {{ $booking->computer->computer_label ?? 'N/A' }}
@endcomponent

@component('mail::button', ['url' => 'https://emcgalle.payzlite.net/reserve'])
Make a New Reservation
@endcomponent

If this cancellation was made by mistake or you need assistance, please contact the main lab.

Best regards,  
**ESOFT Metro Campus Galle**

@endcomponent
