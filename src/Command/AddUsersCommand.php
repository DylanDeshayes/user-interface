<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(
    name: 'add-users',
    description: 'Ajoute les utilisateurs pour le test',
)]
class AddUsersCommand extends Command
{
    private $entityManager;
    private $userPasswordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;
        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        
        $io = new SymfonyStyle($input, $output);
        $aasUsers = [
            ['firstname'=>'Testeur','lastname'=>'Sans droit','email'=>'test@test.fr','roles'=>[],'password'=>'test'],
            ['firstname'=>'Admin','lastname'=>'Role admin','email'=>'admin@admin.fr','roles'=>["ROLE_ADMIN"],'password'=>'admin']
        ];

        $eUser = new User();

        foreach($aasUsers as $asUser){
            $eUser->setFirstname($asUser['firstname']);
            $eUser->setLastname($asUser['lastname']);
            $eUser->setEmail($asUser['email']);
            $eUser->setRoles($asUser['roles']);

            $eUser->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $eUser,
                    $asUser['password']
                )
            );

            $this->entityManager->persist($eUser);
            $this->entityManager->flush();
            $this->entityManager->clear();
        }

        $io->success('Deux utilisateurs ont été créés.');

        return Command::SUCCESS;
    }
}
