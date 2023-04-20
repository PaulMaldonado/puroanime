@extends('layouts.app')

@section('styles')
<style>
.rating {
    display: inline-flex;
    flex-direction: row-reverse;
    justify-content: center;
    align-items: center;
    font-size: 1.5em;
}

.rating-input {
    display: none;
}

.rating-star {
    position: relative;
    padding: 0 3px;
    cursor: pointer;
    transition: color 0.2s;
}

.rating-input:checked ~ .rating-star {
    color: #ffc107;
}

.rating-input:hover ~ .rating-star {
    color: #ffc107;
}

</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>{{$anime->title}}</h1>
            <p>{{$anime->description}}</p>
            <img src="{{asset($anime->cover_image)}}" alt="{{$anime->title}}" class="img-fluid">
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h2>Episodios</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Episodio</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Calificación promedio</th>
                        <th>Calificar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($anime->episodes as $episode)
                        <tr>
                            <td>{{ $episode->number }}</td>
                            <td>{{ $episode->title }}</td>
                            <td>{{ ucfirst($episode->type) }}</td>
                            <td>{{ $episode->ratings->avg('rating') }}</td>
                            <td>
                                {{-- Aquí puedes agregar el formulario para calificar el episodio --}}
                                <form method="POST" action="{{route('anime.rating.store', $episode)}}">
                                    @csrf
                                    <input type="hidden" name="anime_id" value="{{$anime->id}}">
                                    <input type="hidden" name="episode_id" value="{{$episode->id}}">
                                    <div class="rating">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input type="radio" name="rating" id="rating-{{$episode->id}}-{{$i}}" value="{{$i}}" class="rating-input">
                                            <label for="rating-{{$episode->id}}-{{$i}}" class="rating-star"><i class="fas fa-star"></i></label>
                                        @endfor
                                    </div>
                                    {{-- <button type="submit" class="btn btn-primary">Enviar calificación</button> --}}
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.rating-input').forEach(input => {
    console.log("llega!")
    input.addEventListener('change', () => {
        input.closest('form').submit();
    });
});
</script>
@endsection