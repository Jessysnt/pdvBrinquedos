<?php

namespace App\Controller;

use App\Repository\ClienteDAO;
use Core\View;

class ClienteController
{
    public function clienteAdd()
    {
        $obClienteDAO = new ClienteDAO();
    
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
            $result = $obClienteDAO->adicionarCliente($_POST);
                
            
        }
        View::renderTemplate('/cliente/cliente.html'); 
    }
}