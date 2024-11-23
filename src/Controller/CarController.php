<?php

namespace App\Controller;

use App\Entity\CarSearch;
use App\Form\CarTypeSearchType;
use App\Repository\CarRepository;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarController extends AbstractController
{
    private $carSearch;

    public function __construct(private LoggerInterface $logger)
    { 
       $this->carSearch = new CarSearch();
    }
    #[Route('/customer/cars', name: 'cars')]
    public function index(CarRepository $carRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        
        $form = $this->createForm(CarTypeSearchType::class, $this->carSearch);
        $form->handleRequest($request);
        $cars = $paginatorInterface->paginate(
            $carRepository->findAllWithPagination($this->carSearch),
            $request->query->getInt('page', 1), /* page number */
            6 /* limit per page */
        );

        // $this->logger->info($cars->count()??0);

        return $this->render('car/cars.html.twig', [
            'cars' => $cars,
            'form' => $form->createView(),
            'admin' => false
        ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200));
    }
}
