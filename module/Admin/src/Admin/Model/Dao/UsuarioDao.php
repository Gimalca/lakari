<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioDao
 *
 * @author Pedro
 */

namespace Admin\Model\Dao;

use ArrayObject;
use Admin\Model\Entity\Usuario;

class UsuarioDao {

    private $listaUsuario;

    public function __construct() {

        $this->listaUsuario = new ArrayObject();

        $this->listaUsuario->append(new Usuario(1, "Pedro", "Giacometto", "pedro@gmail.com",'123456'));
        $this->listaUsuario->append(new Usuario(2, "Juan", "Gonzales", "juan@gmail.com",'123456'));
        $this->listaUsuario->append(new Usuario(3, "Andres", "Suarez", "andres@gmail.com",'123456'));
        $this->listaUsuario->append(new Usuario(4, "Jose", "Perez", "jose@gmail.com",'123456'));
        $this->listaUsuario->append(new Usuario(5, "Pedro", "Rivas", "Mario@gmail.com",'123456'));
        $this->listaUsuario->append(new Usuario(6, "Pedro", "Ramos", "raul@gmail.com",'123456'));
        $this->listaUsuario->append(new Usuario(7, "Jorge", "Ramos", "jorge@gmail.com",'123456'));
        $this->listaUsuario->append(new Usuario(8, "Jose", "Jimenez", "pablo@gmail.com",'123456'));
        $this->listaUsuario->append(new Usuario(9, "Pedro", "Salas", "carlos@gmail.com",'123456'));
        $this->listaUsuario->append(new Usuario(10, "Pedro", "Flores", "julio@gmail.com",'123456'));
        $this->listaUsuario->append(new Usuario(11, "Jose", "Perry", "keny@gmail.com",'123456'));
        $this->listaUsuario->append(new Usuario(12, "Pedro", "Martin", "xavier@gmail.com",'123456'));
        $this->listaUsuario->append(new Usuario(13, "Andres", "Castellano", "marina@gmail.com",'123456'));
        $this->listaUsuario->append(new Usuario(14, "Jose", "Martin", "mario@gmail.com",'123456'));
        $this->listaUsuario->append(new Usuario(15, "Andres", "Flores", "paola@gmail.com",'123456'));
    }

    public function obtenerTodos() {

        return $this->listaUsuario;
    }

    public function obtenerPorId($id) {

        $usuario = null;

        foreach ($this->listaUsuario as $usuario) {
            if ($usuario->getId() == $id) {
                $resultado = $usuario;
                break;
            }
        }

        return $resultado;
    }

    public function buscarPorNombre($nombre) {

        $result = new ArrayObject();

        foreach ($this->listaUsuario as $usuario) {
            if ($usuario->getNombre() == $nombre) {
                $result->append($usuario);
            }
        }

        return $result;
    }

    public function aunteticar($email, $password) {

        foreach ($this->listaUsuario as $usuario) {
            if (($usuario->getEmail()==$email) && ($usuario->getPassword()==$password)){
               echo 'Valida'; die;
            }
        }

        return false;
    }

    //put your code here
}
