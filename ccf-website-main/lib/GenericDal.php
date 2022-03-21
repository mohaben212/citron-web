<?php

namespace lib;

/**
 * Description of GenericDal
 *
 */
abstract class GenericDal {
    abstract protected function table(): string;
    abstract protected function primary(): ?string;
    protected function columns(): array {
        return get_object_vars($this);
    }
    
    public function insert($id = null): bool {
        $returns = false;
        $data = [];
        foreach($this->columns() as $k => $v) {
            if(is_object($v) && is_a($v, \DateTime::class)) {
                $v = $v->format(\DateTime::ATOM);
            }
            $data[$k] = $v;
        }
        if(!empty($id) && !empty($this->primary())) {
            $data[$this->primary()] = $id;
        }
        $q = "insert ignore into `".$this->table()."` (`".implode("`, `", array_keys($data))."`) values (:".implode(", :", array_keys($data)).")";
        $id = Database::getInstance()->qi($q, $data);
        if(!empty($id)) { $this->{$this->primary()} = $id; $returns = true; }
        return $returns;
    }
    
    public function update(): bool {
        $returns = false;
        $kid = $this->primary();
        $data = [];
        foreach($this->columns() as $k => $v) {
            if(is_object($v) && is_a($v, \DateTime::class)) {
                $v = $v->format(\DateTime::ATOM);
            }
            $data[$k] = $v;
        }
        
        $tu = [];
        foreach(array_keys($data) as $k) {
            if($k !== $kid) {
                $tu[] = "`".$k."`=:".$k;
            }
        }
        $q = "update `".$this->table()."` set ".implode(", ", $tu)." where `".$kid."`=:".$kid;
        if(Database::getInstance()->qu($q, $data)) {
            $returns = true;
        }
        return $returns;
    }
    
    public function load($id): self {
        $sel = Database::getInstance()->qo(
                "select * from `".$this->table()."` where `".$this->primary()."`=:id",
                ['id' => $id,]
                );
        if(!empty($sel)) {
            foreach($sel as $k => $v) {
                if(property_exists($this, $k) && !empty($v)) {
                    $mn = 'set'.ucfirst($k);
                    if(method_exists($this, $mn)) {
                        $this->$mn($v);
                    } else {
                        $this->$k = $v;
                    }
                }
            }
        }
        return $this;
    }
    
    public function all(): array {
        return Database::getInstance()->qa("select * from `".$this->table()."`");
    }
}
