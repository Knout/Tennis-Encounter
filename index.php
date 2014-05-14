<?php
$id_rencontre = 1;

function classLoad($class)
{
    require_once $class . '.class.php';
}

spl_autoload_register('classLoad');

$db = new PDO('mysql:host=localhost;dbname=test', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            fieldset{
                display: inline;
                width: 250px;
            }
            #rencontre{
                width: 1200px;
                margin: auto;
                text-align: center;
            }
        </style>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <?php require_once 'inc/refresh_encounter.inc.php'; ?>

    </head>
    <body>

        <div id="rencontre">
            <input id="start_encounter" type="button" value="Démarrer la rencontre"/>
        </div>

        <script>
            $('#start_encounter').click(function() {
                var compteur = setInterval(function() {
                    RefreshEncounter('<?php echo $id_rencontre; ?>');
                }, 300);
            });
        </script>
    </body>
</html>