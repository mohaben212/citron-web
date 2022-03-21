<?php
namespace dal;

/**
 * Description of Contract
 *
 */
class Contract extends \lib\GenericDal {
    protected function table(): string {
        return 'contracts';
    }
    
    protected function primary(): ?string {
        return 'id';
    }
    
    protected $id = null;
    protected ?int $person = null;
    protected ?\DateTime $start = null;
    protected ?\DateTime $end = null;
    protected string $position = '';
    protected int $vacations = 0;
    protected float $salary = 0.;

    public function getId(): int {
        return $this->id;
    }
    
    public function getPerson(): ?int {
        return $this->person;
    }

    public function getStart() {
        return empty($this->start)? null:$this->start->format('Y-m-d');
    }

    public function getEnd() {
        return empty($this->end)? null:$this->end->format('Y-m-d');
    }

    public function getPosition(): string {
        return $this->position;
    }

    public function getVacations(): int {
        return $this->vacations;
    }

    public function getSalary(): float {
        return $this->salary;
    }

    public function setPerson(?int $person): self {
        $this->person = $person;
        return $this;
    }

    public function setStart($start): self {
        if(is_object($start) && is_a($start, \DateTime::class)) {
            $this->start = $start;
        } else {
            $this->start = \DateTime::createFromFormat('Y-m-d', $start);
        }
        return $this;
    }

    public function setEnd($end): self {
        if(is_object($end) && is_a($end, \DateTime::class)) {
            $this->end = $end;
        } else {
            $this->end = \DateTime::createFromFormat('Y-m-d', $end);
        }
        return $this;
    }

    public function setPosition(string $position): self {
        $this->position = $position;
        return $this;
    }

    public function setVacations(int $vacations): self {
        $this->vacations = $vacations;
        return $this;
    }

    public function setSalary(float $salary): self {
        $this->salary = $salary;
        return $this;
    }


}
