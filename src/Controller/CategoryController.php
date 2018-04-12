<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {

        $this->categoryRepository = $categoryRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/category/", name="category")
     */
    public function index()
    {
        $categories = $this->categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/category/create/", name="category.create")
     */
    public function create(Request $request)
    {
        $category = new Category();
        return $this->handleForm($request, $category);

    }

    /**
     * @Route("/category/{id}/edit/", name="category.edit")
     */
    public function edit(Request $request, $id)
    {
        $category = $this->categoryRepository->find($id);

        if($category === null){
            throw $this->createNotFoundException("Task #$id does not exist");
        }

        return $this->handleForm($request, $category);
    }

    /**
     * @Route("/category/{id}/delete/", name="category.delete")
     */
    public function delete(Request $request, $id)
    {
        $category = $this->categoryRepository->find($id);

        if($category === null){
            throw $this->createNotFoundException("Task #$id does not exist");
        }

        $this->entityManager->remove($category);
        $this->entityManager->flush();
        return $this->redirect('/category');
    }

    /**
     * @param Request $request
     * @param $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function handleForm(Request $request, $category)
    {
        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->entityManager->persist($data);
            $this->entityManager->flush();
            return $this->redirect('/category');
        }

        return $this->render('category/create.html.twig', [
            'form' => $form->createView()
        ]);
        exit;
    }
}
