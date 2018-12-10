<?php
namespace classes;
class Direccion {
	private $id;
	private $direccion;
	private $ciudad;
	private $cp;
	private $tipo;
	private $owner;
	
	// CONSTRUCTOR
	public function __construct($id,$direccion,$ciudad,$cp,$tipo,$owner) {
		$this->setId($id);
		$this->setDireccion($direccion);
		$this->setCiudad($ciudad);
		$this->setCp($cp);
		$this->setTipo($tipo);
		$this->setOwner($owner);
	}
	
	// GETTERS
	public function getId() {
		return $this->id;
	}
	public function getDireccion() {
		return $this->direccion;
	}
	public function getCiudad() {
		return $this->ciudad;
	}
	public function getCp() {
		return $this->cp;
	}
	public function getTipo() {
		return $this->tipo;
	}
	public function getOwner() {
		return $this->owner;
	}
	
	// SETTERS
	public function setId($id) {
		$this->id = $id;
	}
	public function setDireccion($direccion) {
		$this->direccion = $direccion;
	}
	public function setCiudad($ciudad) {
		$this->ciudad = $ciudad;
	}
	public function setCp($cp) {
		$this->cp = $cp;
	}
	public function setTipo($tipo) {
		$this->tipo = $tipo;
	}
	public function setOwner($owner) {
		$this->owner = $owner;
	}
}