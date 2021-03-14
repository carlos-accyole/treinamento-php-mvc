<?php

namespace Alura\Cursos\Controller;

class FormularioInsercao implements InterfaceControladorRequisicao
{
    public function processaRequisicao(): void
    {
        $titulo = 'Novo curso';
        require_once __DIR__ . '/../../view/cursos/formulario.php';
    }
}