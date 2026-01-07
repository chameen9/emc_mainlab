@component('mail::message')

@if($booking->status == 'Scheduled')
# 👨🏻‍💻 Booking Confirmed

Dear Sir/Ma'am, Thank you for your reservation.  
Below are the details of your booking at **EMC Main Lab**.

@component('mail::panel')
## 📋 Booking Details

**👥 Batch:** {{ $booking->batch }}  
**📘 Module:** {{ $booking->module }}  

---

**📆 Date:** {{ \Carbon\Carbon::parse($booking->start)->format('Y-m-d') }}  
**⏰ Time:** {{ \Carbon\Carbon::parse($booking->start)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end)->format('H:i') }}

---

**🏫 Lab:** {{ $booking->lab->lab_name }}  
**🕵🏻‍♂️ Invigilator:** {{ $booking->lecturer }}  
**👤 Created By:** {{ $booking->created_by }}
@endcomponent

If you have any questions or need assistance, please contact the main lab.

Best regards,  
**ESOFT Metro Campus Galle**

@endcomponent

@elseif($booking->status == 'Completed')
# ✅ Booking Completed

Dear Sir/Ma'am, Your reservation at **EMC Main Lab** has been successfully completed.

@component('mail::panel')
## 📋 Booking Details

**👥 Batch:** {{ $booking->batch }}  
**📘 Module:** {{ $booking->module }}  

---

**📆 Date:** {{ \Carbon\Carbon::parse($booking->start)->format('Y-m-d') }}  
**⏰ Time:** {{ \Carbon\Carbon::parse($booking->start)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end)->format('H:i') }}

---

**🏫 Lab:** {{ $booking->lab->lab_name }}  
**🕵🏻‍♂️ Invigilator:** {{ $booking->lecturer }}  
@endcomponent

If you have any questions or need assistance, please contact the main lab.

Best regards,  
**ESOFT Metro Campus Galle**

@endcomponent

@elseif($booking->status == 'Cancelled')
# ❌ Booking Cancelled

Dear Sir/Ma'am, This email is to inform you that your reservation at **EMC Main Lab** has been **cancelled**.
Please do not attend the lab or inform to the students about this booking.

@component('mail::panel')
## 📋 Booking Details

**👥 Batch:** {{ $booking->batch }}  
**📘 Module:** {{ $booking->module }}  

---

**📆 Date:** {{ \Carbon\Carbon::parse($booking->start)->format('Y-m-d') }}  
**⏰ Time:** {{ \Carbon\Carbon::parse($booking->start)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end)->format('H:i') }}

---

**🏫 Lab:** {{ $booking->lab->lab_name }}  
**🕵🏻‍♂️ Invigilator:** {{ $booking->lecturer }}  
@endcomponent

If you have any questions or need assistance, please contact the main lab.

Best regards,  
**ESOFT Metro Campus Galle**

@endcomponent

@else
# ❌ Booking Cancelled

Dear Sir/Ma'am, This email is to inform you that your reservation at **EMC Main Lab** has been **cancelled**.
Please do not attend the lab or inform to the students about this booking.

@component('mail::panel')
## 📋 Booking Details

**👥 Batch:** {{ $booking->batch }}  
**📘 Module:** {{ $booking->module }}  

---

**📆 Date:** {{ \Carbon\Carbon::parse($booking->start)->format('Y-m-d') }}  
**⏰ Time:** {{ \Carbon\Carbon::parse($booking->start)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end)->format('H:i') }}

---

**🏫 Lab:** {{ $booking->lab->lab_name }}  
**🕵🏻‍♂️ Invigilator:** {{ $booking->lecturer }}  
@endcomponent

If you have any questions or need assistance, please contact the main lab.

Best regards,  
**ESOFT Metro Campus Galle**

@endcomponent

@endif