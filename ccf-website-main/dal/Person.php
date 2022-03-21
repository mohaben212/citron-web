<?php
namespace dal;

/**
 * Description of Person
 *
 */
class Person extends \lib\GenericDal {
    protected function table(): string {
        return 'persons';
    }
    
    protected function primary(): ?string {
        return 'id';
    }
    
    protected $id = null;
    protected ?string $firstname = null;
    protected ?string $lastname = null;
    protected ?\DateTime $birthdate = null;
    protected ?string $gender = null;
    
    public function getId() {
        return $this->id;
    }
    
    public function getFirstname(): ?string {
        return $this->firstname;
    }

    public function getLastname(): ?string {
        return $this->lastname;
    }

    public function getBirthdate(): ?string {
        return empty($this->birthdate)? null:$this->birthdate->format('Y-m-d');
    }

    public function getGender(): ?string {
        return $this->gender;
    }

    public function setFirstname(string $firstname): self {
        $this->firstname = $firstname;
        return $this;
    }

    public function setLastname(string $lastname): self {
        $this->lastname = $lastname;
        return $this;
    }

    public function setBirthdate($birthdate): self {
        if(is_object($birthdate) && is_a($birthdate, \DateTime::class)) {
            $this->birthdate = $birthdate;
        } else {
            $this->birthdate = \DateTime::createFromFormat('Y-m-d', $birthdate);
        }
        return $this;
    }

    public function setGender(string $gender): self {
        if(in_array($gender, ['m', 'f', 'o',])) {
            $this->gender = $gender;
        }
        return $this;
    }


}
