<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;




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

    #[Route('/new', name: 'new')]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();

        // Create the form, linked with $category
        $form = $this->createForm(CategoryType::class, $category);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {

            $categoryRepository->add($category, true);
            // Redirect to categories list
            return $this->redirectToRoute('category_index');

            // Deal with the submitted data
            // For example : persiste & flush the entity
            // And redirect to a route that display the result
        }

        // Render the form (best practice)
        return $this->renderForm('category/new.html.twig', [
            'form' => $form,
        ]);

        // Alternative
        // return $this->render('category/new.html.twig', [
        //   'form' => $form->createView(),
        // ]);
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
