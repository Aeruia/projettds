<?php

namespace App\Controller;

use App\Form\SubCategoryType;
use App\Entity\SubCategory;
use App\Repository\SubCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

/**
 * @Route("/subcategory", name="subcategory.")
 */
class SubCategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(SubCategoryRepository $subCategoryRepository)
    {
        $subCategoryRepository = $subCategoryRepository->findAll();
        return $this->render('sub_category/index.html.twig', [
            'subcategories' => $subCategoryRepository
        ]);
    }
    /**
     * @Route("/create", name="create")
     * @Route("/edit/{id}", name="edit")
     * @param Request $request
     * @return Response
     */
    public function form(SubCategory $subCategory = null, Request $request)
    {
        if (!$subCategory) {
            $subCategory = new SubCategory();
        }
        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //entity manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($subCategory);
            $em->flush();
            $this->addFlash('success', 'Subcategory updated');
            return $this->redirect($this->generateUrl('subcategory.index'));
        }

        return $this->render('sub_category/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function remove(SubCategory $subCategory)
    {
        $em = $this->getDoctrine()->getManager();
        try {
            $em->remove($subCategory);
            $em->flush();
            $this->addFlash('success', 'Subcategory deleted');
            return $this->redirect($this->generateUrl('subcategory.index'));
        } catch (ForeignKeyConstraintViolationException $em) {
            $this->addFlash('danger', 'Impossible, cette subcategory est associé à un produit ');
            return  $this->redirectToRoute('subcategory.index');
        }
    }
    /**
     * @Route("/{id}", name="id")
     */
    public function show(subCategory $subCategory)
    {
        return $this->render('sub_category/show.html.twig', [
            'subCategory' => $subCategory
        ]);
    }
}
