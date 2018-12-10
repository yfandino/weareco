<?php
namespace classes;
class Producto {
	
	private $id;
	private $nombre;
	private $descripcion;
	private $stock;
	private $precio;
	private $img;
	private $cantidad = 1;
	
	// CONTRUCTOR
	public function __construct($id,$nombre,$descripcion,$stock,$precio,$img) {
		$this->setId($id);
		$this->setNombre($nombre);
		$this->setDescripcion($descripcion);
		$this->setStock($stock);
		$this->setPrecio($precio);
		$this->setImg($img);
	}
	
	//GETTERS
	public function getId() {
        return $this->id;
    }
	public function getNombre() {
        return $this->nombre;
    }
	public function getDescripcion() {
        return $this->descripcion;
    }
	public function getStock() {
        return $this->stock;
    }
	public function getPrecio() {
        return $this->precio;
    }

	public function getImg() {
        return $this->img;
    }
    public function getCantidad() {
    	return $this->cantidad;
    }
	
    // SETTERS
	public function setId($id) {
        $this->id = $id;
    }
	public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
	public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
	public function setStock($stock) {
        $this->stock = $stock;
    }
	public function setPrecio($precio) {
        $this->precio = $precio;
    }
	public function setImg($img) {
        $this->img = $img;
    }
    public function setCantidad($cantidad) {
    	$this->cantidad = $cantidad;
    }
}