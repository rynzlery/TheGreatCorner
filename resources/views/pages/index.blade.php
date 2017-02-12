@extends('layouts.master')

@section('content')
    @if(Session::has('flash_message'))
        <div class="center col s12 m4 offset-m4"><div class="alert alert-success">{!! session('flash_message') !!}</div></div>
    @endif
    <div class="col-sm-12" style="margin-top: 10%; margin-bottom: 5%;">
        <h1 class="text-center" style="font-family: 'Raleway'; font-size: 6em;"><b>thegreatcorner</b></h1>
    </div>
    <div class="col-sm-12 col-md-offset-4 col-md-4">
        <form class="form-horizontal" action="thegreatcorner.php" role="form" method="post">
            {{ csrf_field() }}
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="email" class="form-control" id="email" name="email" placeholder="email">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12 col-md-6">
                    <select class="form-control" name="region">
                        <option value="">region</option>
                        <option value="alsace">Alsace</option>
                        <option value="aquitaine">Aquitaine</option>
                        <option value="auvergne">Auvergne</option>
                        <option value="basse_normandie">Basse-Normandie</option>
                        <option value="bourgogne">Bourgogne</option>
                        <option value="bretagne">Bretagne</option>
                        <option value="centre">Centre</option>
                        <option value="champagne_ardenne">Champagne-Ardenne</option>
                        <option value="corse">Corse</option>
                        <option value="franche_comte">Franche-Comté</option>
                        <option value="haute_normandie">Haute-Normandie</option>
                        <option value="ile_de_france">Ile-de-France</option>
                        <option value="languedoc_roussillon">Languedoc-Roussillon</option>
                        <option value="limousin">Limousin</option>
                        <option value="lorraine">Lorraine</option>
                        <option value="midi_pyrenees">Midi-Pyrénées</option>
                        <option value="nord_pas_de_calais">Nord-Pas-de-Calais</option>
                        <option value="pays_de_la_loire">Pays de la Loire</option>
                        <option value="picardie">Picardie</option>
                        <option value="poitou_charentes">Poitou-Charentes</option>
                        <option value="paca">Paca</option>
                        <option value="rhone_alpes">Rhône-Alpes</option>
                        <option value="guadeloupe">Guadeloupe</option>
                        <option value="martinique">Martinique</option>
                        <option value="guyane">Guyane</option>
                        <option value="reunion">Réunion</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-6">
                    <select id="category" class="form-control" name="type">
                        <option value="">catégorie</option>
                        <option value="offres_d_emploi">Offres d'emploi</option>
                        <option value="voitures">Voitures</option>
                        <option value="motos">Motos</option>
                        <option value="caravaning">Caravaning</option>
                        <option value="utilitaire">Utilitaire</option>
                        <option value="location">Location</option>
                        <option value="colocation">Colocation</option>
                        <option value="informatique">Informatique</option>
                        <option value="consoles_jeux_video">Consoles & Jeux vidéo</option>
                        <option value="image_son">Image & Son</option>
                        <option value="telephonie">Téléphonie</option>
                        <option value="dvd_films">DVD / Films</option>
                        <option value="cd_musique">CD / Musique</option>
                        <option value="livres">Livres</option>
                        <option value="velos">Vélos</option>
                        <option value="instruments_de_musique">Instruments de musique</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12 col-md-12">
                    <input class="form-control" id="wordsearched" name="wordsearched" placeholder="Mots clés">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12 col-md-6">
                    <input type="number" class="form-control" id="prixmin" name="prixmin" placeholder="prix min" min="0" max="999999999">
                </div>
                <div class="col-sm-12 col-md-6">
                    <input type="number" class="form-control" id="prixmax" name="prixmax" placeholder="prix max" min="0" max="999999999">
                </div>
            </div>
            <div class="form-group">
                <p id="fillable"></p>
            </div>
            <div class="form-group">
                <div class="col-sm-12 col-md-12">
                    {!! Recaptcha::render() !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12 col-md-12">
                    <button type="submit" value="submit" class="btn btn-default">Submit</button>
                    <a style="color: white;" href="/thegreatcorner/unsubscribe">Unsubscribe</a>
                </div>
            </div>

        </form>
    </div>

@endsection