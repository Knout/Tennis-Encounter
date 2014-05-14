<?php
$db = new PDO('mysql:host=localhost;dbname=test', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

include_once('../class/Character.class.php');
include_once('../class/EncounterManager.class.php');
include_once('../class/Encounter.class.php');
include_once('../class/PlayerManager.class.php');
include_once('../class/Player.class.php');
include_once('../class/PlayerManager.class.php');

if (isset($_POST['encounter']) && !empty($_POST['encounter']))
{
    $id_encounter = intval($_POST['encounter']);
}
else
{
    exit();
}

$EncounterManager = new EncounterManager($db);
$JoueurManager = new PlayerManager($db);

$encounter = $EncounterManager->get($id_encounter);
$joueur_1 = $JoueurManager->get($encounter->Id_Player1());
$joueur_2 = $JoueurManager->get($encounter->Id_Player2());

echo $encounter->calcul_score();

if ($encounter->Id_Possesseur_Balle() == $joueur_1->Id())
{
    if ($joueur_1->frapper() == true)
    {

        $encounter->setId_Possesseur_Balle($joueur_2->Id());
        $popup_1 = "Joueur 1 Frappe";
        $popup_2 = "";
        $token = 1;
    }
    else
    {
        $encounter->setScore_Player_2(1);
        $encounter->setHistorique($encounter->Historique() . '1');
        $encounter->setId_Possesseur_Balle($joueur_2->Id());
        $popup_1 = "Joueur 1 Rate";
        $popup_2 = "";
    }
}
else
if ($encounter->Id_Possesseur_Balle() == $joueur_2->Id())
{
    if ($joueur_2->frapper() == true)
    {

        $encounter->setId_Possesseur_Balle($joueur_1->Id());
        $popup_1 = "";
        $popup_2 = "Joueur 2 Frappe";
        $token = 2;
    }
    else
    {
        $encounter->setScore_Player_1(1);
        $encounter->setHistorique($encounter->Historique() . '0');
        $encounter->setId_Possesseur_Balle($joueur_1->Id());
        $popup_1 = "";
        $popup_2 = "Joueur 2 Rate";
    }
}

$JoueurManager->update($joueur_1);
$JoueurManager->update($joueur_2);
$EncounterManager->update($encounter);
?>

<!-- Panel Joueur 1 -->
<fieldset id="panel_joueur_1">
    <div id="popup_1"><?php echo $popup_1; ?>&nbsp;</div>
    <legend>Joueur 1</legend>
    <p class="nom_joueur"><?php echo $joueur_1->Surname() . ' ' . $joueur_1->Name(); ?></p>
    <p class="rang_joueur"><?php echo $joueur_1->Rank(); ?></p>
</fieldset>

<!-- Panel Rencontre -->
<fieldset>
    <legend>Rencontre</legend>
    <p> Point en cours : <?php echo $encounter->Point_En_Cours(); ?></p>
    <p> Jeu en cours : <?php echo $encounter->Jeu_En_Cours();?></p>
    <p> Set en cours : <br /><?php echo $encounter->Set_En_Cours(); ?></p>
    <p>Score Joueur 1 : <?php echo $encounter->Score_Player1(); ?></p>
    <p>Score Joueur 2 : <?php echo $encounter->Score_Player2(); ?></p>
</fieldset>

<!-- Panel Joueur 2 -->
<fieldset id="panel_joueur_2">
    <div id="popup_2"><?php echo $popup_2; ?>&nbsp;</div>
    <legend>Joueur2</legend>
    <p class="nom_joueur"><?php echo $joueur_2->Surname() . ' ' . $joueur_2->Name(); ?></p>
    <p class="rang_joueur"><?php echo $joueur_2->Rank(); ?></p>
</fieldset>