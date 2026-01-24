@component('mail::message')

# ✅ Booking Completed Successfully

This email confirms that your reservation at **EMC Main Lab** has been **successfully completed**.

@component('mail::panel')
## 📋 Completed Booking Details

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

@component('mail::button', ['url' => 'https://www.emcgalle.online/reserve'])
Reserve Another Slot
@endcomponent

If you require another reservation or need further assistance, feel free to use the system again or contact the main lab.

Best regards,  
**ESOFT Metro Campus Galle**

@endcomponent