<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Entity\CarSearch;
use Psr\Log\LoggerInterface;
use App\Form\CarTypeSearchType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    private $carSearch;

    public function __construct(private LoggerInterface $logger)
    { 
       $this->carSearch = new CarSearch();
    }
    #[Route('/admin', name:'admin')]

    public function index(CarRepository $carRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $form = $this->createForm(CarTypeSearchType::class, $this->carSearch);
        $form->handleRequest($request);
        $cars = $paginatorInterface->paginate(
            $carRepository->findAllWithPagination($this->carSearch),
            $request->query->getInt('page', 1), /* page number */
            6 /* limit per page */
        );

        return $this->render('car/cars.html.twig', [
            'cars' => $cars,
            'form' => $form->createView(),
            'admin' => true
        ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200));
       
    }

    #[Route('/admin/add', name:'carAdd')]
    #[Route('/admin/{id}', name:'carEdit', methods: 'GET|POST')]

    public function edit(Car $car=null, Request $request, EntityManagerInterface $entityManager): Response
    {
        $creation = false;;
        if(!$car){
            $creation = true;
            $car = new Car();
        }

        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($car);
            $entityManager->flush();
            $this->logger->info('Car updated');
            $this->addFlash('success', $creation ? 'Car created' : 'Car updated');
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/edit.html.twig', [
            'car' => $car,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/{id}', name:'carDelete', methods: 'deletion')]

    public function delete(Car $car, Request $request, EntityManagerInterface $entityManager): Response
    {
        if($this->isCsrfTokenValid('delete'.$car->getId(), $request->get('_token'))){
            $entityManager->remove($car);
            $entityManager->flush();
            $this->addFlash('success', 'Car deleted');
            return $this->redirectToRoute('admin');
        }

    }
}
