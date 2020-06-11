<?php


namespace App\Controller\Admin;


use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     * @return Response
     */
    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin/property/create", name="admin.property.create")
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($property);
            $em->flush();
            $this->addFlash('success', 'Crée avec succès');
            return  $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/create.html.twig', [
            'property'=> $property,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function edit(int $id, Request $request)
    {
        $property = $this->repository->find($id);
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Modifié avec succès');
            return  $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/edit.html.twig', [
            'property'=> $property,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function delete(int $id, Request $request)
    {
        $property = $this->repository->find($id);

        // On vérifie la conformité du token csrf
        if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))){
            $em = $this->getDoctrine()->getManager();
            $em->remove($property);
            $em->flush();
            $this->addFlash('success', 'Supprimé avec succès');
        }
        return $this->redirectToRoute('admin.property.index');
    }
}