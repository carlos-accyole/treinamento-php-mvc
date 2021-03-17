<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Infra\EntityManagerCreator;
use Doctrine\Common\Persistence\ObjectRepository;

class FormularioEdicao extends ControllerComHtml implements InterfaceControladorRequisicao
{
    /**
     * @var ObjectRepository
     */
    private $cursoRepository;

    public function __construct()
    {
        $entityManager = (new EntityManagerCreator())->getEntityManager();
        $this->cursoRepository = $entityManager->getRepository(Curso::class);
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(
            INPUT_GET,
            'id',
            FILTER_VALIDATE_INT
        );

        if (is_null($id) || $id === false) {
            header('Location: /listar-cursos');
            return;
        }

        $curso = $this->cursoRepository->find($id);
        echo $this->renderizaHtml('cursos/formulario.php',
            [
                'curso' => $curso,
                'tutulo' => 'Alterar curso' . $curso->getDescricao()
            ]
        );
    }
}