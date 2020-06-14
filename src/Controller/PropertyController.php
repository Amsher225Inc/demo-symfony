<?php


namespace App\Controller;


use App\Entity\Contact;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropertySearchType;
use App\Notification\ContactNotification;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param CacheManager $cacheManager
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request, CacheManager $cacheManager) : Response
    {
        // La recherche des biens
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);

        // Re
        $properties =  $paginator->paginate(
            $this->propertyRepository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('property/index.html.twig',[
            'active_menu' => 'property',
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }


    /**
     * @param string $slug
     * @param int $id
     * @param ContactNotification $notification
     * @param Request $request
     * @return Response
     */
    public function show(string $slug, int $id ,ContactNotification $notification, Request $request) : Response
    {

        $property = $this->propertyRepository->find($id);

        if($property->getSlug() !== $slug)
        {
            return $this->redirectToRoute('property.show', [
                'slug'=>$property->getSlug(),
                'id'=>$property->getId()
            ],301);
        }

        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $notification->notify($contact);
            $this->addFlash('success', 'Votre message a été envoyer avec succès.');
           return $this->redirectToRoute('property.show', [
                'slug'=>$property->getSlug(),
                'id'=>$property->getId()
            ]);
        }

        return $this->render('property/show.html.twig', [
            'active_menu' => 'property',
            'property' => $property,
            'form' => $form->createView()
        ]);
    }
}