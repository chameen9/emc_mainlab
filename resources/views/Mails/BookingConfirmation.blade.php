@component('mail::message')

# 👨🏻‍💻 Booking Confirmation

Thank you for your reservation.  
Below are the details of your booking at **EMC Main Lab**.

@component('mail::panel')
## 📋 Booking Details

**🧑🏻‍🎓 Student ID:** {{ explode(' ', $booking->title)[0] }}  
**📘 Module:** {{ $booking->module }}  
**👥 Batch:** {{ $booking->batch }}

---

**📆 Date:** {{ \Carbon\Carbon::parse($booking->start)->format('Y-m-d') }}  
**⏰ Time:** {{ \Carbon\Carbon::parse($booking->start)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end)->format('H:i') }}

---

**🏫 Lab:** {{ $booking->lab->lab_name }}  
**💻 Computer:** {{ $booking->computer->computer_label }}
@endcomponent

@component('mail::button', ['url' => 'https://www.emcgalle.online/reserve'])
Reserve Another Slot
@endcomponent

If you have any questions or need assistance, please contact the main lab.

Best regards,  
**ESOFT Metro Campus Galle**

@endcomponent