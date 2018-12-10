<?php
namespace classes;
class Cliente {
	private $id;
	private $username;
	private $password;
	private $nombre;
	private $apellidos;
	private $dni;
	private $email;
	private $telefono;
	
	// CONSTRUCTOR
	public function __construct($username) {
		$this->setUsername($username);
	}
	
	// GETTERS
	public function getId() {
		return $this->id;
	}
	public function getUsername() {
		return $this->username;
	}
	public function getPassword() {
		return $this->password;
	}
	public function getNombre() {
		return $this->nombre;
	}
	public function getApellidos() {
		return $this->apellidos;
	}
	public function getDni() {
		return $this->dni;
	}
	public function getEmail() {
		return $this->email;
	}
	public function getTelefono() {
		return $this->telefono;
	}
	
	// SETTERS
	public function setId($id) {
		$this->id = $id;
	}
	public function setUsername($username) {
		$this->username = $username;
	}
	public function setPassword($password) {
		$this->password = $password;
	}
	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}
	public function setApellidos($apellidos) {
		$this->apellidos = $apellidos;
	}
	public function setDni($dni) {
		$this->dni = $dni;
	}
	public function setEmail($email) {
		$this->email = $email;
	}
	public function setTelefono($telefono) {
		$this->telefono = $telefono;
	}
}