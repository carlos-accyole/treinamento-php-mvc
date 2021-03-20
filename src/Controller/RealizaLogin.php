<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Usuario;
use Alura\Cursos\Helper\FlashMessageTrait;
use Alura\Cursos\Infra\EntityManagerCreator;

class RealizaLogin implements InterfaceControladorRequisicao
{
    use FlashMessageTrait;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $repositorioUsuario;

    public function __construct()
    {
        $entityManager = (new EntityManagerCreator())->getEntityManager();
        $this->repositorioUsuario = $entityManager->getRepository(Usuario::class);
    }

    public function processaRequisicao(): void
    {
        $email = filter_input(
          INPUT_POST,
          'email',
           FILTER_VALIDATE_EMAIL
        );

        if (is_null($email) || $email === false) {
            $this->defineMenssagem('danger','O e-mail digitado não é um e-mail válido.');
            header('Location: /login');
            return;
        }

        $senha = filter_input(
            INPUT_POST,
            'senha',
            FILTER_SANITIZE_STRING
        );

        /** @var  Usuario $usuario */
        $usuario = $this->repositorioUsuario->findOneBy(['email' => $email]);

//        if (is_null($usuario) || !$usuario->senhaEstaCorreta($senha)) {
//            $this->defineMenssagem('danger','E-mail ou senha inválidos');
//            header('Location: /login');
//            return;
//        }

        $_SESSION['logado'] = true;

        header('Location: /listar-cursos');
    }
}