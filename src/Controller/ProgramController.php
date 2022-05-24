<?php
//Le travail d'un contrôleur de Symfony est de retourner un objet de la classe Response !
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProgramController extends AbstractController
{
    #[Route('/program/', name: 'program_index')]

    public function index(): Response  //un objet qui représente une réponse HTTP complète.
    {
        return $this->render('program/index.html.twig', [
            'website' => 'Wild Series',
         ]);
    }
}
