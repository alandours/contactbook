@if(count($errors))

    <ul class="msg-error" id="msg-flash">

    @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

    </ul>

@endif