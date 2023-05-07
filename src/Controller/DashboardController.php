<?php

namespace App\Controller;

use App\Entity\Patient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function dashboard(EntityManagerInterface $entityManager): Response
    {
        $patients = $entityManager->getRepository(Patient::class)->findAll();

        return $this->render('dashboard/dashboard.html.twig', [
            'patients' => $patients,
        ]);
    }


}
