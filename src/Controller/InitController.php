<?php

namespace App\Controller;

use App\Entity\ClassLevel;
use App\Entity\Professor;
use App\Entity\Subject;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InitController extends AbstractController
{
    #[Route('/init', name: 'app_init')]
    public function index(UserPasswordHasherInterface $hasher, EntityManagerInterface $entityManager): Response
    {
        //création des données de test
        //Administrateur
        $admin = new User();
        $admin->setName('administrateur');
        $admin->setEmail('admin@lycee-faure.fr');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($hasher->hashPassword($admin, '&6HAUTdanslaFauré'));
        //Classes
        $class1 = new ClassLevel();
        $class1->setLabel('SIO1');
        $class2 = new ClassLevel();
        $class2->setLabel('SIO2');
        //Matieres
        $subject1 = new Subject();
        $subject1->setLabel('Bloc 1-Support et mise à disposition de services informatiques');
        $subject2 = new Subject();
        $subject2->setLabel('Bloc 2-Conception et développement d\'applications');
        $subject3 = new Subject();
        $subject3->setLabel('Bloc 3-Cybersécurité');
        $subject4 = new Subject();
        $subject4->setLabel('Ateliers de professionnalisation');
        //Prof
        $prof = new Professor();
        $prof->setName('Etienne Buffet');
        $prof->setEmail('etienne.buffet@lycee-faure.fr');
        $prof->setRoles(['ROLE_PROFESSOR']);
        $prof->setPassword($hasher->hashPassword($prof, 'prof'));
        $prof->addSubject($subject1);
        $prof->addSubject($subject2);
        $prof->addSubject($subject3);
        $prof->addSubject($subject4);
        $prof->addClassLevel($class1);
        $prof->addClassLevel($class2);

        //persistence des données
        $entityManager->persist($admin);
        $entityManager->persist($class1);
        $entityManager->persist($class2);
        $entityManager->persist($subject1);
        $entityManager->persist($subject2);
        $entityManager->persist($subject3);
        $entityManager->persist($subject4);
        $entityManager->persist($prof);
        $entityManager->flush();

        return $this->render('init/index.html.twig', [
            'message' => 'Initialisation OK-jetez un oeil au contenu de la bdd',
        ]);
    }
}
