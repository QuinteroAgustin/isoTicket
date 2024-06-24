@component('mail::message')
# Notification Importante

{{$messageContent}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
