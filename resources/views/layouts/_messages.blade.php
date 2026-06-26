@if (session('success'))
    <x-flash-message type="success">
        {{ session('success') }}
    </x-flash-message>
@endif

@if (session('error'))
    <x-flash-message type="error">
        {{ session('error') }}
    </x-flash-message>
@endif
