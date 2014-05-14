<?php

class Character
{
    /* Champs */

    protected $_name;
    protected $_surname;
    protected $_birthday;

    public function __construct(array $data)
    {
        $this->hydrate($data);
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

    public function setName($value)
    {
        $this->_name = $value;
    }

    public function setSurname($value)
    {
        $this->_surname = $value;
    }

    public function setBirthday($value)
    {
        $this->_birthday = $value;
    }

}
?>