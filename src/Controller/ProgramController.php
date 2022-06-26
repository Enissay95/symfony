<?php
//Le travail d'un contrôleur de Symfony est de retourner un objet de la classe Response !
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Entity\Season;
use App\Entity\Program;
use App\Repository\EpisodeRepository;
use App\Entity\Episode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;


#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]

    public function index(ProgramRepository $programRepository): Response  //un objet qui représente une réponse HTTP complète.
    {
        $programs = $programRepository->findAll();

        return $this->render(
            'program/index.html.twig', 
            [
            'programs' => $programs,
            ]
        );
    }

    #[Route('/show/{id<^[0-9]+$>}', name: 'show')]
    public function show(int $id, ProgramRepository $programRepository):Response
    {
      $program = $programRepository->findOneBy(['id' => $id]);
     // same as $program = $programRepository->find($id);

      if (!$program) {
        throw $this->createNotFoundException(
            'No program with id : '.$id.' found in program\'s table.'
        );
      }
      return $this->render('program/show.html.twig', [
        'program' => $program,
      ]);
    }

    #[Route('/{program_id}/season/{season_id}}', methods: ['GET'], name: 'season_show')]
    #[Entity('program', options: ['id' => 'program_id'])]
    #[Entity('season', options: ['id' => 'season_id'])]
    public function showSeason(Program $program, Season $season):Response
    {

      if (!$season) {
        throw $this->createNotFoundException(
            'No season with id : '.$program.' found in program\'s table.'
        );
      }
      return $this->render('program/season_show.html.twig', [
        'program' => $program,
        'season' => $season,
      ]);
    }

    #[Route('/{program}/seasons/{season}/episode/{episode}', name: 'episode_show')]
    public function showEpisode(Program $program, Season $season, Episode $episode){
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode
        ]);
    }

}
