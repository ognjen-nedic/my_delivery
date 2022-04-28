<?php

namespace App\Controller;

use App\Entity\Deliverer;
use App\Entity\Reservation;
use App\Form\DelivererType;
use App\Form\ReservationType;
use App\Repository\VehicleRepository;
use App\Repository\DelivererRepository;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/deliverers')]
class DelivererController extends AbstractController {
    #[Route('/', name: 'show_all_deliverers')]
    public function show_all_deliverers(DelivererRepository $delivererRepository) {
        $deliverers = $delivererRepository->findAll();
        return $this->render('deliverer/index.html.twig',[
            'deliverers' => $deliverers
        ]);
    }
    
    #[Route('/add', name:'add_new_deliverer')]
    public function add_new_deliverer(DelivererRepository $delivererRepository, Request $request) {
        $deliverer = new Deliverer;

        $form = $this->createForm(DelivererType::class, $deliverer);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()):
            $deliverer = $form->getData();
            $delivererRepository->add($deliverer);
            return $this->redirectToRoute('show_all_deliverers');
        endif;

        return $this->render('deliverer/add.html.twig',['form' => $form->createView()]);
    }

    /* #[Route('/add', name:'add_new_deliverer')]
    public function add_new_deliverer(DelivererRepository $delivererRepository, Request $request) {
        $deliverer = new Deliverer;
        if($request->request->get('add_deliverer')):
            $deliverer->setName($request->request->get('deliverer_name'));
            $delivererRepository->add($deliverer);
            return $this->redirectToRoute('show_all_deliverers');
        endif;

        return $this->render('deliverer/add.html.twig');
    } */

    #[Route('/new-reservation', name:'add_new_reservation')]
    public function add_new_reservation(ReservationRepository $reservationRepository, Request $request) {
        $reservation = new Reservation;

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()):
            $reservation = $form->getData();
            $reservationRepository->add($reservation);
            return $this->redirectToRoute('show_all_reservations');
        endif;
        
        return $this->render('deliverer/new_reservation.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /* #[Route('/new-reservation', name:'add_new_reservation')]
    public function add_new_reservation(DelivererRepository $delivererRepository, VehicleRepository $vehicleRepository, ReservationRepository $reservationRepository, Request $request) {
        $reservation = new Reservation;
        if($request->request->get('add_reservation')):
            $deliverer = $delivererRepository->find($request->request->get('deliverer'));
            $reservation->setDeliverer($deliverer);
            $vehicle = $vehicleRepository->find($request->request->get('vehicle'));
            $reservation->setVehicle($vehicle);
            $reservationRepository->add($reservation);
            return $this->redirectToRoute('show_all_reservations');
        endif;
        
        return $this->render('deliverer/new_reservation.html.twig',[
            'deliverers' => $delivererRepository->findAll(),
            'vehicles' => $vehicleRepository->findAll(),
            'reservations' => $reservationRepository->findAll()

        ]);
    } */

    #[Route('/{id}', name: 'deliverer_reservations_history')]
    public function deliverer_reservations_history(Deliverer $deliverer) {
        return $this->render('deliverer/reservations-list.html.twig',[
            'deliverer' => $deliverer
        ]);
    }

}
