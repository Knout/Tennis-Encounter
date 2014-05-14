<?php

/**
 * 
 */
class Encounter
{

    public $_id;
    public $_date_rencontre;
    public $_id_player_1;
    public $_id_player_2;
    public $_id_possesseur_balle;
    public $_score_player_1;
    public $_score_player_2;
    public $_historique;
    public $_entamee;
    public $_fin;
    public $_point_en_cours;
    public $_jeu_en_cours;
    public $_set_en_cours;

    public function __construct(array $data)
    {
        $this->hydrate($data);

        if (!empty($this->_entamee))
        {
            initialisation();
        }
        else
        {
            
        }
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value)
        {
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }

    public function rencontre_entamee()
    {
        if (!empty($this->_entamee))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function donner_balle()
    {
        $random = rand(1, 2);

        if ($random == 1)
        {
            $this->_id_possesseur_balle = $this->_id_player_1;
        }
        else
        {
            $this->_id_possesseur_balle = $this->_id_player_2;
        }
    }

    public function initialisation()
    {
        donner_balle();
    }

    public function calcul_score()
    {
        $historique = $this->Historique();
        $joueur_1 = array('points' => 0, 'jeux' => 0, 'set' => 0, 'match' => 0);
        $joueur_2 = array('points' => 0, 'jeux' => 0, 'set' => 0, 'match' => 0);
        $rencontre = array();

        if (!strlen($historique))
        {
            # Rencontre trop courte
        }
        else
        {
            for ($i = 0; $i < strlen($historique); $i++)
            {
                switch ($historique[$i])
                {
                    case 0:
                        {
                            $joueur_1['points'] += 1;
                            break;
                        }
                    case 1:
                        {
                            $joueur_2['points'] += 1;
                            break;
                        }
                    default :
                        {
                            # error?
                        }
                }

                if (($joueur_1['points'] >= 4 && ($joueur_1['points'] - $joueur_2['points'] >= 2)))
                {
                    # Joueur 1 remporte le jeu
                    $joueur_1['points'] = 0;
                    $joueur_2['points'] = 0;
                    $joueur_1['jeux'] += 1;
                }

                if (($joueur_2['points'] >= 4 && ($joueur_2['points'] - $joueur_1['points'] >= 2)))
                {
                    # Joueur 2 remporte le jeu
                    $joueur_1['points'] = 0;
                    $joueur_2['points'] = 0;
                    $joueur_2['jeux'] += 1;
                }

                if (($joueur_1['jeux'] >= 6 && ($joueur_1['jeux'] - $joueur_2['jeux'] >= 2)))
                {
                    array_push($rencontre, $joueur_1['jeux']);
                    array_push($rencontre, $joueur_2['jeux']);
                    $joueur_1['jeux'] = 0;
                    $joueur_2['jeux'] = 0;
                    $joueur_1['set'] += 1;
                }

                if (($joueur_2['jeux'] >= 6 && ($joueur_2['jeux'] - $joueur_1['jeux'] >= 2)))
                {
                    # Joueur 2 remporte le set
                    $joueur_1['jeux'] = 0;
                    $joueur_2['jeux'] = 0;
                    $joueur_2['set'] += 1;
                }

                if (($joueur_1['set'] >= 2 && ($joueur_1['set'] - $joueur_2['set'] >= 2)))
                {
                    # Joueur 1 remporte le match
                    $joueur_1['set'] = 0;
                    $joueur_2['set'] = 0;
                    $joueur_1['match'] += 1;
                }

                if (($joueur_2['set'] >= 2 && ($joueur_2['set'] - $joueur_1['set'] >= 2)))
                {
                    # Joueur 2 remporte le match
                    $joueur_1['set'] = 0;
                    $joueur_2['set'] = 0;
                    $joueur_2['match'] += 1;
                }
            }
        }

        /* echo '<pre> Joueur 1 : ';
          var_dump($joueur_1);
          echo '</pre>';
          echo '<pre> Joueur 2 : ';
          var_dump($joueur_2);
          echo '</pre>';
          echo '<pre> Rencontre : ';
          var_dump($rencontre);
          echo '</pre>'; */

        $this->setPoint_En_Cours($this->formatage_points($joueur_1['points'], $joueur_2['points']));
        $this->setJeu_En_Cours($joueur_1['jeux'] . ' ' . $joueur_2['jeux']);
        $this->setSet_En_Cours($this->formatage_set($rencontre));
    }

    public function formatage_set($rencontre)
    {
        $j1 = "";
        $j2 = "";
        foreach ($rencontre as $key => $value)
        {
            if ($key % 2 == 0)
            {
                $j1 .= '-' . $value;
            }
            else
            {
                $j2 .= '-' . $value;
            }
        }

        return $j1 . '<br />' . $j2;
    }
    
    public function affichage_points()
    {
        
    }

    public function formatage_points($pt1, $pt2)
    {
        $format = array(0 => 0, 1 => 15, 2 => 30, 3 => 40, 4 => 'A');
        
        if(in_array($pt1, $format))

        foreach ($format as $key => $value)
        {
            if ($pt1 == $key)
            {
                $pt1 = $format[$key];
            }
            else
            {
                if ($pt1 >= 5)
                {
                    $pt1 = $format[4];
                    $pt2 = $format[3];
                }
            }

            if ($pt2 == $key)
            {
                $pt2 = $format[$key];
            }
            else
            {
                if ($pt2 >= 5)
                {
                    $pt1 = $format[3];
                    $pt2 = $format[4];
                }
            }
        }

        return $pt1 . ' - ' . $pt2;
    }

    /* Getters */

    public function Id()
    {
        return $this->_id;
    }

    public function Date_Rencontre()
    {
        return $this->_date_rencontre;
    }

    public function Id_Player1()
    {
        return $this->_id_player_1;
    }

    public function Id_Player2()
    {
        return $this->_id_player_2;
    }

    public function Score_Player1()
    {
        return $this->_score_player_1;
    }

    public function Score_Player2()
    {
        return $this->_score_player_2;
    }

    public function Id_Possesseur_Balle()
    {
        return $this->_id_possesseur_balle;
    }

    public function Historique()
    {
        return $this->_historique;
    }

    public function Fin()
    {
        return $this->_fin;
    }

    public function Point_En_Cours()
    {
        return $this->_point_en_cours;
    }

    public function Jeu_En_Cours()
    {
        return $this->_jeu_en_cours;
    }

    public function Set_En_Cours()
    {
        return $this->_set_en_cours;
    }

    /* Setters */

    public function setId($value)
    {
        $this->_id = $value;
    }

    public function setDate_rencontre($value)
    {
        $this->_date_rencontre = $value;
    }

    public function setId_player_1($value)
    {
        $this->_id_player_1 = $value;
    }

    public function setId_Player_2($value)
    {
        $this->_id_player_2 = $value;
    }

    public function setScore_Player_1($value)
    {
        $this->_score_player_1 += $value;
    }

    public function setScore_Player_2($value)
    {
        $this->_score_player_2 += $value;
    }

    public function setId_Possesseur_Balle($value)
    {
        $this->_id_possesseur_balle = $value;
    }

    public function setHistorique($value)
    {
        $this->_historique = $value;
    }

    public function setFin($value)
    {
        $this->_fin = $value;
    }

    public function setPoint_En_Cours($value)
    {
        $this->_point_en_cours = $value;
    }

    public function setJeu_En_Cours($value)
    {
        $this->_jeu_en_cours = $value;
    }

    public function setSet_En_Cours($value)
    {
        $this->_set_en_cours = $value;
    }

}
?>