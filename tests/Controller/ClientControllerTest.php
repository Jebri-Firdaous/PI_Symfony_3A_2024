<?php

namespace App\Test\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ClientRepository $repository;
    private string $path = '/client/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Client::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Client index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'client[nom_personne]' => 'Testing',
            'client[prenom_personne]' => 'Testing',
            'client[numero_telephone]' => 'Testing',
            'client[mail_personne]' => 'Testing',
            'client[mdp_personne]' => 'Testing',
            'client[image_personne]' => 'Testing',
            'client[genre]' => 'Testing',
            'client[age]' => 'Testing',
            'client[personne]' => 'Testing',
        ]);

        self::assertResponseRedirects('/client/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Client();
        $fixture->setNom_personne('My Title');
        $fixture->setPrenom_personne('My Title');
        $fixture->setNumero_telephone('My Title');
        $fixture->setMail_personne('My Title');
        $fixture->setMdp_personne('My Title');
        $fixture->setImage_personne('My Title');
        $fixture->setGenre('My Title');
        $fixture->setAge('My Title');
        $fixture->setPersonne('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Client');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Client();
        $fixture->setNom_personne('My Title');
        $fixture->setPrenom_personne('My Title');
        $fixture->setNumero_telephone('My Title');
        $fixture->setMail_personne('My Title');
        $fixture->setMdp_personne('My Title');
        $fixture->setImage_personne('My Title');
        $fixture->setGenre('My Title');
        $fixture->setAge('My Title');
        $fixture->setPersonne('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'client[nom_personne]' => 'Something New',
            'client[prenom_personne]' => 'Something New',
            'client[numero_telephone]' => 'Something New',
            'client[mail_personne]' => 'Something New',
            'client[mdp_personne]' => 'Something New',
            'client[image_personne]' => 'Something New',
            'client[genre]' => 'Something New',
            'client[age]' => 'Something New',
            'client[personne]' => 'Something New',
        ]);

        self::assertResponseRedirects('/client/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom_personne());
        self::assertSame('Something New', $fixture[0]->getPrenom_personne());
        self::assertSame('Something New', $fixture[0]->getNumero_telephone());
        self::assertSame('Something New', $fixture[0]->getMail_personne());
        self::assertSame('Something New', $fixture[0]->getMdp_personne());
        self::assertSame('Something New', $fixture[0]->getImage_personne());
        self::assertSame('Something New', $fixture[0]->getGenre());
        self::assertSame('Something New', $fixture[0]->getAge());
        self::assertSame('Something New', $fixture[0]->getPersonne());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Client();
        $fixture->setNom_personne('My Title');
        $fixture->setPrenom_personne('My Title');
        $fixture->setNumero_telephone('My Title');
        $fixture->setMail_personne('My Title');
        $fixture->setMdp_personne('My Title');
        $fixture->setImage_personne('My Title');
        $fixture->setGenre('My Title');
        $fixture->setAge('My Title');
        $fixture->setPersonne('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/client/');
    }
}
