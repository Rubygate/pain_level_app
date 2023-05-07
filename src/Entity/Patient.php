<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastName;

    #[ORM\Column(type: 'datetime')]
    private $monitoringStartDate;

    #[ORM\Column(type: 'datetime')]
    private $monitoringEndDate;

    #[ORM\Column(type: 'integer')]
    private $reminderInterval;

    #[ORM\Column(type: 'datetime')]
    private $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated;

    #[ORM\Column(type: 'text')]
    private $prescribedMedication;

    #[ORM\Column(type: 'string', length: 255)]
    private $contactPhone;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $painLevelRequestInterval;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: PatientReport::class)]
    private $patientReports;

    public function __construct()
    {
        $this->patientReports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMonitoringStartDate(): ?\DateTimeInterface
    {
        return $this->monitoringStartDate;
    }

    public function setMonitoringStartDate(\DateTimeInterface $monitoringStartDate): self
    {
        $this->monitoringStartDate = $monitoringStartDate;

        return $this;
    }

    public function getMonitoringEndDate(): ?\DateTimeInterface
    {
        return $this->monitoringEndDate;
    }

    public function setMonitoringEndDate(\DateTimeInterface $monitoringEndDate): self
    {
        $this->monitoringEndDate = $monitoringEndDate;

        return $this;
    }

    public function getReminderInterval(): ?int
    {
        return $this->reminderInterval;
    }

    public function setReminderInterval(int $reminderInterval): self
    {
        $this->reminderInterval = $reminderInterval;

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

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getPrescribedMedication(): ?string
    {
        return $this->prescribedMedication;
    }

    public function setPrescribedMedication(string $prescribedMedication): self
    {
        $this->prescribedMedication = $prescribedMedication;

        return $this;
    }

    public function getContactPhone(): ?string
    {
        return $this->contactPhone;
    }

    public function setContactPhone(string $contactPhone): self
    {
        $this->contactPhone = $contactPhone;

        return $this;
    }

    public function getPainLevelRequestInterval(): ?string
    {
        return $this->painLevelRequestInterval;
    }

    public function setPainLevelRequestInterval(?string $painLevelRequestInterval): self
    {
        $this->painLevelRequestInterval = $painLevelRequestInterval;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, PatientReport>
     */
    public function getPatientReports(): Collection
    {
        return $this->patientReports;
    }

    public function addPatientReport(PatientReport $patientReport): self
    {
        if (!$this->patientReports->contains($patientReport)) {
            $this->patientReports[] = $patientReport;
            $patientReport->setPatient($this);
        }

        return $this;
    }

    public function removePatientReport(PatientReport $patientReport): self
    {
        if ($this->patientReports->removeElement($patientReport)) {
            // set the owning side to null (unless already changed)
            if ($patientReport->getPatient() === $this) {
                $patientReport->setPatient(null);
            }
        }

        return $this;
    }
}
