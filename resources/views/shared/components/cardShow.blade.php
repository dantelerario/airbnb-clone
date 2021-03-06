{{--
DOCUMENTATION:
This template need to be include with a parameter of model App\Flat
--}}
<div class="card-show">
    <div class="jumbotron pt-20 pb-20">
        <img src="{{ asset('storage/' . $flat->image ) }}" alt="{{$flat -> title}}">
        <h1>{{$flat->title}}</h1>

    </div>

    <div class="description d-flex s-between">
        <div class="desc">
            <h2 class="mb-10">Descrizione</h2>
            <p>{{$flat->description}}</p>
        </div>
        <div class="desc-list">
            <h2 class="mb-10">Dettagli</h2>
            <ul>
                <li>Numero di stanze: {{$flat->number_of_rooms}}</li>
                <li>Numero di posti letto: {{$flat->number_of_beds}}</li>
                <li>Numero di bagni: {{$flat->number_of_bathrooms}}</li>
                <li>Metri quadrati: {{$flat->square_meters}}</li>
                <li>Indirizzo: {{$flat->address }}</li>
                <li>Include:
                    <ul class="ml-15">
                        @foreach ($flat->services->map(function($item) {
                        return $item->type;
                        }) as $service)
                        <li>{{ $service }}</li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <div class="content-container d-flex s-between">
        <div class="map-description">
            <h3 class="mb-10">Mappa</h3>
            <div class="map">
                <input type="hidden" name="latlong" id="lat" value="{{ $flat->lat}}">
                <input type="hidden" name="latlong" id="lng" value="{{ $flat->lng}}">
                <div id="mapid" class="map-container mb-20"></div>
            </div>

        </div>
        @if (Auth::check() && $flat->user_id == Auth::user()->id)
        <div class="button-card mb-20 d-flex">
            <div class="left-btn d-flex">
                <a class="btn btn-stat mb-5 mr-5" href="{{ route('admin.statistics' , $flat->id) }}"><i
                        class="far fa-chart-bar"></i><span class="top-text">Statistiche</span></a>
                <a class="btn btn-spons mb-5 mr-5"
                    href="{{ route('admin.sponsorships.create', ['flat_id' => $flat->id]) }}"><i
                        class="fas fa-medal"></i><span class="top-text">Sponsorizza</span></a>
                <a class="btn btn-edit mb-5 mr-5" href="{{ route('admin.flats.edit', $flat->id) }}"><i
                        class="far fa-edit"></i><span class="top-text">Modifica</span></a>
                <form action="{{ route('admin.flats.destroy', $flat->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete"><i class="far fa-trash-alt"></i><span
                            class="top-text">Elimina</span></button>
                </form>
                {{-- <button class="btn btn-"><i class="far fa-arrow-alt-circle-right"></i></button> --}}
            </div>
        </div>
        @else
        <div class="df-column mb-20">
            <h3 class="mb-10">Scrivi al proprietario</h3>
            <form class="form form-message" action="{{ route('requests') }}" method="POST">
                @csrf
                @method('POST')
                <ul class="accountholder df-column ">
                    <li class="d-flex s-between align-center">
                        <input type="text" class="field-style field-split" name="name" id="form_name" placeholder="Nome"
                            value="@auth {{ old('name', Auth::user()->name) }}@endauth @guest{{ old('name') }} @endguest">

                        <input type="text" class="field-style field-split" name="surname" id="form_surname"
                            placeholder="Cognome"
                            value="@auth {{ old('surname', Auth::user()->surname) }}@endauth @guest{{ old('surname') }} @endguest">
                    </li>
                    <li class="d-flex s-between align-center">
                        <input type="email" class="field-style field-full" name="email" id="form_email"
                            placeholder="Email"
                            value="@auth {{ old('email', Auth::user()->email) }}@endauth @guest{{ old('email') }} @endguest">
                    </li>
                    <li class="d-flex s-between align-center">
                        <textarea name="message" id="form_message" class="field-style"
                            placeholder="Chiedi qualcosa al proprietario">{{ old('message') }}</textarea>
                    </li>
                    <li class="d-flex s-center align-center">
                        <input type="hidden" class="form-control" name="flat_id" id="flat_id" value="{{ $flat->id }}">
                        <input type="submit" value="Invia" class="btn btn-search">
                    </li>
                </ul>
            </form>
            @endif
        </div>
    </div>
</div>
</div>