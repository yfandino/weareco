<?php

namespace classes;

class DetFactura {
	private $id;
	private $factura;
	private $producto;
	private $cantidad;
	private $precio;
	
	// CONSTRUCTOR
	public function __construct($id,$factura,$producto,$cantidad,$precio) {
		$this->setId($id);
		$this->setFactura($factura);
		$this->setProducto($producto);
		$this->setCantidad($cantidad);
		$this->setPrecio($precio);
	}
	
	// GETTERS
	public function getId() {
		return $this->id;
	}
	public function getFactura() {
		return $this->factura;
	}
	public function getProducto() {
		return $this->producto;
	}
	public function getCantidad() {
		return $this->cantidad;
	}
	public function getPrecio() {
		return $this->precio;
	}
	
	// SETTERS
	public function setId($id) {
		$this->id = $id;
	}
	public function setFactura($factura) {
		$this->factura = $factura;
	}
	public function setProducto($producto) {
		$this->producto = $producto;
	}
	public function setCantidad($cantidad) {
		$this->cantidad = $cantidad;
	}
	public function setPrecio($precio) {
		$this->precio = $precio;
	}
}

