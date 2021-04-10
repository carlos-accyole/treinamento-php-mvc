<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Usuario;
use Alura\Cursos\Helper\FlashMessageTrait;
use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RealizaLogin implements RequestHandlerInterface
{
    use FlashMessageTrait;

    private $repositorioUsuario;

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repositorioUsuario = $entityManager->getRepository(Usuario::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $email = filter_var(
            $request->getParsedBody()['email'],
           FILTER_VALIDATE_EMAIL
        );

        $resposta = new Response(302, ['Location' => '/login']);

        if (is_null($email) || $email === false) {
            $this->defineMenssagem('danger','O e-mail digitado não é um e-mail válido.');
            return $resposta;
        }

        $senha = filter_var(
            $request->getParsedBody()['senha'],
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

        return new Response(302, ['Location' => '/listar-cursos']);

    }
}