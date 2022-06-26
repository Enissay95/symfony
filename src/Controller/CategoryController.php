<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;



#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {

        $category = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $category,
        ]);
    }

    #[Route('/{categoryName}', name: 'show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {

        $categoryName = $categoryRepository->findByName(['categoryName' => $categoryName]);

        $categories = $categoryRepository->findAll();
        $programs = $programRepository->findAll();

        $categoryResults = $programRepository->findByCategory(
            $categoryName,
            ['id' => 'ASC']
        );

        return $this->render('category/show.html.twig', [
            'categoryName' => $categoryName,
            'programs' => $programs,
            'categories' => $categories,
            'categoryResults' => $categoryResults,

        ]);
    }
}
