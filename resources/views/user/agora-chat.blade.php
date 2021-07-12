@include('template.header')

<div class="container mt-20" id="app">
    <agora-chat :allusers="{{ $users }}" authuserid="{{ auth()->user()->id }}" authuser="{{ auth()->user()->name }}"
        agora_id="{{ env('AGORA_APP_ID') }}" />
</div>

@include('template.footer')