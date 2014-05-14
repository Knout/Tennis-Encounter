<?php

class Player extends Character
{
    /* Champs */

    public $_id;
    public $_rank;
    // Statistiques
    public $_moral; // Le moral (Augmente avec un tir réussi, baisse avec un tir manqué)
    public $_accuracy;  // La précision (en %, stable toute la rencontre, augmente avec une victoire, baisse avec une défaite)
    public $_agility;   // L'agilité
    public $_strenght;  // La force
    public $_stamina;   // La vitalité
    public $_luck;  // La moule... le soleil dans les yeux, le vent, un supporter nu sur le terrain etc..

    public function frapper()
    {
        $min_range = 0;
        $max_range = 1;
        
        $tir = rand($min_range, $max_range * $this->_accuracy);
        
        $that_luck = rand(1, 100);

        $rand = rand(0, ((100 - ($this->_accuracy * ($this->_moral * ($that_luck / 100)))))); //ex: 0 - ((100-(75 * (0.9 * (91/100)))) : 0 - 38.575
        if ($rand < 55)
            return true;
        else
            return false;
    }
    
    /* Getters */
    
    public function Id()
    {
        return $this->_id;
    }

    public function Surname()
    {
        return $this->_surname;
    }

    public function Name()
    {
        return $this->_name;
    }

    public function Birthday()
    {
        return $this->_birthday;
    }

    public function Rank()
    {
        return $this->_rank;
    }
    
    public function Moral()
    {
        return $this->_moral;
    }
    
    public function Accuracy()
    {
        return $this->_accuracy;
    }

    /* Setters */

    public function setId($value)
    {
        $this->_id = $value;
    }

    public function setRank($value)
    {
        $this->_rank = $value;
    }
    
    public function setMoral($value)
    {
        $this->_moral = $value;
    }
    
    public function setAccuracy($value)
    {
        $this->_accuracy = $value;
    }

}

?>