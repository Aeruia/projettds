<?php

namespace App\Controller;

use App\Form\ProductType;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ProductRepository;



/**
 * @Route("/product", name="product.")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }
    /**
     * @Route("/create", name="create")
     * @Route("/edit/{id}", name="edit")
     * @param Request $request
     * @return Response
     */
    public function create(Product $product = null, Request $request)
    {
        if (!$product) {
            $product = new Product();
        }
        $formProduct = $this->createForm(ProductType::class, $product);
        $formProduct->handleRequest($request);
        if ($formProduct->isSubmitted() && $formProduct->isValid()) {
            //entity manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            $this->addFlash('success', 'Product updated');
            return $this->redirect($this->generateUrl('product.index'));
        }

        return $this->render('product/create.html.twig', [
            'formProduct' => $formProduct->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function remove(Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
        $this->addFlash('success', 'Product deleted');
        return $this->redirect($this->generateUrl('product.index'));
    }
    /**
     * @Route("/{id}", name="id")
     */
    public function show(Product $product)
    {
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
