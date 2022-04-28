<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservations')]
class ReservationController extends AbstractController
{
    #[Route('/', name: 'show_all_reservations')]
    public function show_all_reservations(ReservationRepository $reservationRepository) {
        $reservations = $reservationRepository->findAll();
        return $this->render('reservation/index.html.twig',[
            'reservations' => $reservations
        ]);
    }
}
