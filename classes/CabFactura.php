<?php
namespace classes;
class CabFactura {
	
	private $id;
	private $cliente;
	private $precioTotal;
	
	// CONSTRUCTOR
	public function __construct($id,$cliente,$precioTotal) {
		$this->setId($id);
		$this->setCliente($cliente);
		$this->setPrecioTotal($precioTotal);
	}
	
	// GETTERS
	public function getId() {
		return $this->id;
	}
	public function getCliente() {
		return $this->cliente;
	}
	public function getPrecioTotal() {
		return $this->precioTotal;
	}
	
	// SETTERS
	public function setId($id) {
		$this->id = $id;
	}
	public function setCliente($cliente) {
		$this->cliente = $cliente;
	}
	public function setPrecioTotal($precioTotal) {
		$this->precioTotal = $precioTotal;
	}
}

