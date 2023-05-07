<?php

namespace App\Entity;

use App\Repository\PatientReportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientReportRepository::class)]
class PatientReport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $painLevel;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'patientReports')]
    #[ORM\JoinColumn(nullable: false)]
    private $patient;

    #[ORM\Column(type: 'date')]
    private $created;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPainLevel(): ?int
    {
        return $this->painLevel;
    }

    public function setPainLevel(int $painLevel): self
    {
        $this->painLevel = $painLevel;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }
}
