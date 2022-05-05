<?php

namespace App\Controller;

use Core\View;

class FornecedorController
{
    public function fornecedor()
    {
        
        View::renderTemplate('/fornecedores/fornecedor.html');
    }
}