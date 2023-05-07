<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\PatientReport;
use App\Form\PatientReportType;
use App\Form\PatientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatientReportController extends AbstractController
{
    #[Route('/patient/{patientId}/report', name: 'app_patient_report')]
    public function report(Request $request,EntityManagerInterface $entityManager, int $patientId): Response
    {
        $patient = $entityManager->getRepository(Patient::class)->find($patientId);
        $patientReport  = new PatientReport();
        $patientReport->setPatient($patient);
        $form = $this->createForm(PatientReportType::class, $patientReport);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $patientReport->setCreated(new \DateTime());
            $entityManager->persist($patientReport);
            $entityManager->flush();
            return $this->render('patient_report/thanks.html.twig');
        }
        return $this->render('patient_report/report.html.twig', [
            'patient' => $patient,
            'form' => $form->createView()
        ]);
    }
}
