@include('template.header')

<div class="container mt-20" id="app">
    <video-chat :allusers="{{ $users }}" :authUserId="{{ auth()->user()->id }}" turn_url="{{ env('TURN_SERVER_URL') }}"
        turn_username="{{ env('TURN_SERVER_USERNAME') }}" turn_credential="{{ env('TURN_SERVER_CREDENTIAL') }}" />
</div>

@include('template.footer')
