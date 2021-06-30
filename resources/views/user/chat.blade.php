@include('template.header')

<div class="container mt-20" id="app">
    <chats :user="{{auth()->user() }}"></chats>
</div>

@include('template.footer')
