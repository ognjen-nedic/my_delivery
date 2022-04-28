<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vehicles')]
class VehicleController extends AbstractController {
    #[Route('/', name: 'show_all_vehicles')]
    public function show_all_vehicles(VehicleRepository $vehicleRepository) {
        $vehicles = $vehicleRepository->findAll();
        return $this->render('vehicle/index.html.twig',[
            'vehicles' => $vehicles
        ]);
    }

    #[Route('/{id}', name: 'vehicle_reservations_history')]
    public function vehicle_reservations_history(Vehicle $vehicle) {
        return $this->render('vehicle/reservations-list.html.twig',[
            'vehicle' => $vehicle
        ]);
    }
}