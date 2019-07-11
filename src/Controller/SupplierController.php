<?php

namespace App\Controller;

use App\Form\SupplierType;
use App\Entity\Supplier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\SupplierRepository;



/**
 * @Route("/supplier", name="supplier.")
 */
class SupplierController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(SupplierRepository $supplierRepository)
    {
        $suppliers = $supplierRepository->findAll();
        return $this->render('supplier/index.html.twig', [
            'suppliers' => $suppliers
        ]);
    }
    /**
     * @Route("/create", name="create")
     * @Route("/edit/{id}", name="edit")
     * @param Request $request
     * @return Response
     */
    public function create(Supplier $supplier = null, Request $request)
    {
        if (!$supplier) {
            $supplier = new supplier();
        }
        $formSupplier = $this->createForm(SupplierType::class, $supplier);
        $formSupplier->handleRequest($request);
        if ($formSupplier->isSubmitted() && $formSupplier->isValid()) {
            //entity manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($supplier);
            $em->flush();
            $this->addFlash('success', 'Supplier updated');
            return $this->redirect($this->generateUrl('supplier.index'));
        }

        return $this->render('supplier/create.html.twig', [
            'formSupplier' => $formSupplier->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function remove(Supplier $supplier)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($supplier);
        $em->flush();
        $this->addFlash('success', 'Supplier deleted');
        return $this->redirect($this->generateUrl('supplier.index'));
    }
    /**
     * @Route("/{id}", name="id")
     */
    public function show(Supplier $supplier)
    {
        return $this->render('supplier/show.html.twig', [
            'supplier' => $supplier
        ]);
    }
}
