<?php

/**
 * 
 */
class PlayerManager
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

    public function add(Player $player)
    {
        $q = $this->_db->prepare('INSERT INTO player SET surname = :surname, name = :name, birthday = :birthday, rank = :rank');

        $q->bindValue(':surname', $player->Surname(), PDO::PARAM_STR);
        $q->bindValue(':name', $player->Name(), PDO::PARAM_STR);
        $q->bindValue(':birthday', $player->Birthday(), PDO::PARAM_STR);
        $q->bindValue(':rank', $player->Rank(), PDO::PARAM_INT);

        $q->execute();
    }

    public function get($id)
    {
        if ($id)
        {
            $q = $this->_db->query('SELECT * FROM player WHERE id = ' . $id);
            $data = $q->fetch(PDO::FETCH_ASSOC);

            return new Player($data);
        }
    }

    public function update(Player $player)
    {
        $q = $this->_db->prepare('UPDATE player SET id = :id, surname = :surname, name = :name, birthday = :birthday, rank = :rank, moral = :moral, accuracy = :accuracy WHERE id = ' . $player->Id());

        $q->bindValue(':id', $player->Id(), PDO::PARAM_INT);
        $q->bindValue(':surname', $player->Surname(), PDO::PARAM_STR);
        $q->bindValue(':name', $player->Name(), PDO::PARAM_STR);
        $q->bindValue(':birthday', $player->Birthday(), PDO::PARAM_STR);
        $q->bindValue(':rank', $player->Rank(), PDO::PARAM_INT);
        $q->bindValue(':moral', $player->Moral(), PDO::PARAM_INT);
        $q->bindValue(':accuracy', $player->Accuracy(), PDO::PARAM_INT);

        $q->execute();
    }

}

?>