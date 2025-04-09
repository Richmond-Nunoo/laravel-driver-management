@component('mail::message')
# Welcome, {{ $driver->full_name }}

Your registration was successful. Thank you!

**Truck Type:** {{ $driver->truck_type }}
**Phone:** {{ $driver->phone }}

You can view your uploaded document later via the dashboard.

@component('mail::button', ['url' => route('drivers.dashboard', ['driver' => $driver->id])])
View Dashboard
@endcomponent

Thanks,
{{ config('app.name') }}
@endcomponent