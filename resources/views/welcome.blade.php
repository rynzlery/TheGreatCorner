<html>
@foreach($informations as $information)

    <div class="col-sm-12 col-md-6">
        {{$information['title']}} <br>
        {{$information['date']}}<br>
        {{$information['item_description']}}<br>
        {{$information['prix']}} <br>
        {{Html::image($information['img'])}}<br>
        {{($information['link'])}}<br><br>
    </div>

@endforeach

</html>
