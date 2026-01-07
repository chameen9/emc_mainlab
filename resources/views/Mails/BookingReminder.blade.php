@component('mail::message')
# ⏰ Booking Reminder

This is a reminder for your lab booking scheduled **tomorrow**.

@component('mail::panel')
**📆 Date:** {{ \Carbon\Carbon::parse($booking->start)->format('d-m-Y') }}  
**⏰ Time:** {{ \Carbon\Carbon::parse($booking->start)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end)->format('H:i') }}  
**👥 Batch:** {{ $booking->batch }}  
**📄 Type:** {{ $booking->description }}  

**🏫 Lab:** {{ $booking->lab->lab_name ?? 'N/A' }}  
**💻 Computer:** {{ $booking->computer->computer_label ?? 'Any' }}  
**📘 Module:** {{ $booking->module }}
@endcomponent

Please be on time.

Best regards,  
**ESOFT Metro Campus Galle**
@endcomponent