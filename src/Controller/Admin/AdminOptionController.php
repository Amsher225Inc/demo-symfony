<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Form\OptionType;
use App\Repository\OptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminOptionController extends AbstractController
{
    /**
     * @var OptionRepository
     */
    private $optionRepository;

    /**
     * AdminOptionController constructor.
     * @param OptionRepository $optionRepository
     */
    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    /**
     * @Route("/admin/option", name="option_index", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('admin/option/index.html.twig', [
            'options' => $this->optionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/option/create", name="option_create", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $option = new Option();
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($option);
            $entityManager->flush();

            return $this->redirectToRoute('option_index');
        }

        return $this->render('admin/option/create.html.twig', [
            'option' => $option,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin/option/{id}", name="option_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Option $option
     * @return Response
     */
    public function edit(Request $request, Option $option): Response
    {
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('option_index');
        }

        return $this->render('admin/option/edit.html.twig', [
            'option' => $option,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/option/{id}", name="option_delete", methods={"DELETE"})
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function delete( int $id, Request $request): Response
    {
        $option = $this->optionRepository->find($id);
        if ($this->isCsrfTokenValid('delete'.$option->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($option);
            $entityManager->flush();
        }

        return $this->redirectToRoute('option_index');
    }
}
