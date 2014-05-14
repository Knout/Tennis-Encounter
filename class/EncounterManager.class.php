<?php

/**
 * 
 */
class EncounterManager
{

    private $_db;

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }

    public function get($id)
    {
        $q = $this->_db->query('SELECT * FROM encounter WHERE id = ' . $id);
        $data = $q->fetch(PDO::FETCH_ASSOC);

        return new Encounter($data);
    }

    public function getPossesseur(int $id)
    {
        $q = $this->_db->query('SELECT possesseur FROM encounter WHERE id = ' . $id);
    }

    public function update(Encounter $encounter)
    {
        $q = $this->_db->prepare('UPDATE encounter SET date_rencontre = :date_rencontre, id_player_1 = :id_player_1, id_player_2 = :id_player_2, score_player_1 = :score_player_1, score_player_2 = :score_player_2, id_possesseur_balle = :id_possesseur_balle, historique = :historique, fin = :fin WHERE id = ' . $encounter->Id());

        $q->bindValue(':date_rencontre', $encounter->Date_Rencontre(), PDO::PARAM_STR);
        $q->bindValue(':id_player_1', $encounter->Id_Player1(), PDO::PARAM_STR);
        $q->bindValue(':id_player_2', $encounter->Id_Player2(), PDO::PARAM_STR);
        $q->bindValue(':score_player_1', $encounter->Score_Player1(), PDO::PARAM_INT);
        $q->bindValue(':score_player_2', $encounter->Score_Player2(), PDO::PARAM_INT);
        $q->bindValue(':id_possesseur_balle', $encounter->Id_Possesseur_Balle(), PDO::PARAM_INT);
        $q->bindValue(':historique', $encounter->Historique(), PDO::PARAM_STR);
        $q->bindValue(':fin', $encounter->Fin(), PDO::PARAM_INT);

        $q->execute();
    }

}

?>