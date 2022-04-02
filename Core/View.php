<?php

namespace Core;

class View
{
    /**
     * Renderiza um arquivo da View
     */
    public static function render($view, $args=[]){
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/App/View/$view";

        if(is_readable($file)){
            require $file;
        }else{
            throw new \Exception("$file não encontado");
        }
    }

    /**
     * Retorna json
     */
    public static function jsonResponse($data=null, $httpStatus=200)
    {
        header_remove();
        header('Content-type; application/json');
        http_response_code($httpStatus);
        echo json_encode($data);
        exit();
    }

    /**
     * Renderizar um template usando Twig
     *
     * @param string $template  O arquivo de template Twig
     * @param array $args   Um array de associação de dados para exibir na view (opcional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . '/App/View');            
            if (\App\Config::SHOW_ERRORS) {
                $twig = new \Twig\Environment($loader,['debug' => true]);
                $twig->addExtension(new \Twig\Extension\DebugExtension());
                $twig->addGlobal('session', $_SESSION);
            } else {
                $twig = new \Twig\Environment($loader);
                $twig->addGlobal('session', $_SESSION);
            }
        }

        echo $twig->render($template, $args);
    }
}