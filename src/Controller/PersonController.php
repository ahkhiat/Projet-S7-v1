<?php

namespace App\Controller;

use App\Entity\Person;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    #[Route('/person', name: 'app_person')]
    public function index(): Response
    {
        return $this->render('person/index.html.twig', [
            'controller_name' => 'PersonController',
        ]);
    }

    #[Route('/create_person', name: 'create_person')]
    public function createPerson(EntityManagerInterface $entityManager): Response 
    {
        $person = new Person();
        $person->setNom('Leung');
        $person->setPrenom('Thierry');
        $person->setVille('Marseille');

        $entityManager->persist($person);

        $entityManager->flush();

        return new Response('Saved new person with id ' .$person->getId());
    }

    #[Route('/persons', name: 'app_all_persons', methods :['GET'])]
    public function all_persons(PersonRepository $personRepository): Response 
    {
        
        return $this->render('person/all_persons.html.twig', [
            'persons' => $personRepository->findAll(),
        ]);
    }
    
    // #[Route('/person/{id}', name: 'person_show', methods :['GET'])]
    // public function show2(PersonRepository $personRepository): Response 
    // {
    //     $person = $personRepository
    //     ->find($id);

    //     if (!$person) {
    //         throw $this->createNotFoundException(

    //         );
    //     }
    //     return $this->render('person/all_persons.html.twig', [
    //         'persons' => $personRepository->findAll(),
    //     ]);
    // }
}

