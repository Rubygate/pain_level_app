<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\PatientReport;
use App\Form\PatientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatientController extends AbstractController
{
    #[Route('/patient/{patientId}/details', name: 'app_patient_details')]
    public function viewDetails(Request $request, EntityManagerInterface $entityManager, int $patientId): Response
    {
        $patient = $entityManager->getRepository(Patient::class)->find($patientId);
        $patientReports = $entityManager->getRepository(PatientReport::class)->findBy(['patient' => $patient]);
        $data = [];
        /** @var PatientReport $patientReport */
        foreach ($patientReports as $patientReport){
            $reportData = new \stdClass();
            $reportData->period = $patientReport->getCreated()->format('Y-m-d');
            $reportData->pain_level = $patientReport->getPainLevel();
            $data[] = $reportData;
        }

        return $this->render('patient/patient_details.html.twig', [
            'report' => json_encode($data),
            'patient' => $patient
        ]);
    }


    #[Route('/patient', name: 'app_patient_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $patient  = new Patient();
        $form = $this->createForm(PatientType::class, $patient);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Patient $patient */
            $patient = $form->getData();
            $patient->setCreated(new \DateTime());
            $patient->setPainLevelRequestInterval(
                $patient->getReminderInterval()." ". $form->get('intervalType')->getData());

            $entityManager->persist($patient);
            $entityManager->flush();


            return $this->redirectToRoute('app_dashboard');
        }
        return $this->render('patient/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}