<p>esto es una prueba</p>

@foreach ($usuario as $user)
    {{$user->email}}
    {{ $user->password }}
@endforeach