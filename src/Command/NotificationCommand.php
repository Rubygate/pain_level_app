<?php

namespace App\Command;

use App\Entity\Patient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsCommand(name: 'app:notify')]
class NotificationCommand extends Command
{
    public function __construct(private MailerInterface $mailer, private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $patients = $this->entityManager->getRepository(Patient::class)->findPatientDueForReminder();
        /** @var Patient $patient */
        foreach ($patients as $patient) {

            $email = (new Email())
                ->from('ayoadebamgbose@gmail.com')
                ->to($patient->getEmail())
                ->subject('Follow-up: Pain Report Request')
                ->html(
                    '<p>Dear '. $patient->getFirstName().'</p>'.
                        '<p>As part of our effort to provide you with the best care possible, Kindly click the link below to let us know you feel since you last used your medication.</p>'.
                        '<p> <a href="http://ec2-3-87-202-108.compute-1.amazonaws.com:8001/patient/'.$patient->getId().'/report">Click here to report your pain level.</a></p>'.
                        '<p>You are advised to be as sincere as possible to enable us to accurately assess your condition.</p>'.
                        '<p>Kind regards,<br/>Dr. Ayoade Adeyemo.</p>'
                );
        }
        $this->mailer->send($email);

        $intervalType = $patient->getReminderIntervalType();

        if ($intervalType == 'day'){
            $totalHourInMinute =  24 * 60;
        } elseif ($intervalType == 'weekly') {
            $totalHourInMinute = 7 * 24 * 60;
        }

        $nextReminderTime = $totalHourInMinute / $patient->getReminderInterval();
        $patient->setNextReminderTime($patient->getNextReminderTime()->modify("+ $nextReminderTime minutes"));
        $this->entityManager->flush();
        return Command::SUCCESS;
    }
}