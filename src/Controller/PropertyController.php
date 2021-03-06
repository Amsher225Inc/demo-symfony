<?php


namespace App\Controller;


use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PropertyController extends  AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $propertyRepository;

    /**
     * PropertyController constructor.
     * @param PropertyRepository $propertyRepository
     */
    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }


    /**
     * @return Response
     */
    public function index() : Response
    {
        return $this->render('property/index.html.twig',[
            "active_menu" => 'property'
        ]);
    }


    /**
     * @param string $slug
     * @param int $id
     * @return Response
     */
    public function show(string $slug, int $id ) : Response
    {
        $property = $this->propertyRepository->find($id);

        if($property->getSlug() !== $slug)
        {
            return $this->redirectToRoute('property.show', ['slug'=>$property->getSlug(), 'id'=>$property->getId()], 301);
        }
        return $this->render('property/show.html.twig', [
            "active_menu" => 'property',
            "property" => $property
        ]);
    }
}