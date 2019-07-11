<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\CategoryType;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

/**
 * @Route("/category", name="category.")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(CategoryRepository $categoryRepository)
    {
        $categoryRepository = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository
        ]);
    }
    /**
     * @Route("/create", name="create")
     * @Route("/edit/{id}", name="edit")
     * @param Request $request
     * @return Response
     */
    public function form(Category $category = null, Request $request)
    {
        if (!$category) {
            $category = new Category();
        }
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //entity manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Category updated');
            return $this->redirect($this->generateUrl('category.index'));
        }
        return $this->render('category/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function remove(Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        try {
            $em->remove($category);
            $em->flush();
            $this->addFlash('success', 'Category deleted');
            return $this->redirect($this->generateUrl('category.index'));
        } catch (ForeignKeyConstraintViolationException $em) {
            $this->addFlash('danger', 'Impossible, cette category est associé à un produit ');
            return  $this->redirectToRoute('category.index');
        }
    }
    /**
     * @Route("/{id}", name="id")
     */
    public function show(Category $category)
    {
        return $this->render('category/show.html.twig', [
            'category' => $category
        ]);
    }
}
