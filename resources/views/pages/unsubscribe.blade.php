@extends('layouts.master')

@section('content')
    <div class="col-sm-12" style="margin-top: 10%; margin-bottom: 5%;">
        <h1 class="text-center" style="font-family: 'Raleway'; font-size: 6em;"><b>thegreatcorner</b></h1>
    </div>
    <div class="col-sm-12 col-md-offset-4 col-md-4">
        <form class="form-horizontal" action="unsubscribe" role="form" method="post">
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
                <p id="fillable"></p>
            </div>
            <div class="form-group">
                <div class="col-sm-12 col-md-12">
                    {!! Recaptcha::render() !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12 col-md-12">
                    <button type="submit" value="submit" class="btn btn-default">Unsubscribe</button>
                </div>
            </div>

        </form>
    </div>

@endsection