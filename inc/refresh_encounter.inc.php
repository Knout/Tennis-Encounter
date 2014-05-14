<script>
    function RefreshEncounter(id_encounter)
    {
        var request = $.ajax({
            type: "POST",
            url: "inc/panel_joueur.php",
            data: {encounter: id_encounter},
            cache: false,
            async: false
        });

        request.done(function(html) {
            $('#rencontre').html(html);
        });

        request.fail(function(error) {
            alert("RefreshPlayer Failed : " + error);
        });
    }
</script>