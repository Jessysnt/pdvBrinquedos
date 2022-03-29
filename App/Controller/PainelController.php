<?php

namespace App\Controller;

use Core\View;

class PainelController
{
    public function painel()
    {
        
        View::renderTemplate('/painel/inicio.html');
    }
}
