@component('mail::message')

# 📅 Permanent Booking Summary

**Student ID:** {{ $studentId }}  
**Module:** {{ $module }}  
**Batch:** {{ $batch }}  
**LAB:** {{ $labName }}  
**Computer:** {{ $computerLabel }}  

---

## ✅ Reserved Dates ({{ $reservedCount }})

@if(count($reservedDates))
@foreach($reservedDates as $date)
• {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}  
@endforeach
@else
No dates reserved.
@endif

---

## ⚠️ Skipped Dates ({{ $skippedCount }})

@if(count($skippedDates))
@foreach($skippedDates as $skip)
• {{ \Carbon\Carbon::parse($skip['date'])->format('d-m-Y') }}  
  _Reason:_ {{ $skip['reason'] }}  
@endforeach

You may create a **temporary reservation** for these skipped dates if required.
@else
No skipped dates.
@endif

---

**⏰ Time:** {{ $start }} - {{ $end }}

If you have any questions, please contact the lab administration.

Best regards,  
**ESOFT Metro Campus Galle**

@endcomponent