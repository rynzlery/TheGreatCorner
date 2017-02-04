<script src="{{ URL::asset('public/bower/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::asset('public/bower/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script>
    $("#category").change(function(){
        if ($("#category").val() == "voitures") {
            $("#fillable").html("<div class='col-sm-12 col-md-6'><input type='number' class='form-control' id='prixmax' name='prixmax' placeholder='année max' min='1900' max='2020'></div><div class='col-sm-12 col-md-6'><input type='number' class='form-control' id='prixmin' name='prixmin' placeholder='année min' min='0' max='999999999'></div>");
        }
    });
</script>