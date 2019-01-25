<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 19/10/2018
 * Time: 14:13
 */

namespace App\Utility;

use App\Entity\PersonInCharge;
use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use chillerlan\QRCode\QRCode;

class AccessDataGenerator
{
    const ANIMALS = [
        "Albatross",
        "Alpaca",
        "Antelope",
        "Ape",
        "Armadillo",
        "Donkey",
        "Barracuda",
        "Bat",
        "Bear",
        "Bee",
        "Buffalo",
        "Butterfly",
        "Camel",
        "Capybara",
        "Cat",
        "Caterpillar",
        "Cattle",
        "Cheetah",
        "Chicken",
        "Chimpanzee",
        "Clam",
        "Cobra",
        "Coyote",
        "Crab",
        "Crocodile",
        "Deer",
        "Dinosaur",
        "Dog",
        "Dogfish",
        "Dolphin",
        "Dove",
        "Dragonfly",
        "Duck",
        "Dugong",
        "Eagle",
        "Elephant",
        "Emu",
        "Falcon",
        "Fish",
        "Flamingo",
        "Fox",
        "Frog",
        "Gazelle",
        "Giraffe",
        "Gnu",
        "Goat",
        "Goldfish",
        "Gorilla",
        "Hamster",
        "Hawk",
        "Hippopotamus",
        "Horse",
        "Jaguar",
        "Jellyfish",
        "Kangaroo",
        "Koala",
        "Lemur",
        "Leopard",
        "Lion",
        "Llama",
        "Lobster",
        "Mantis",
        "Monkey",
        "Mouse",
        "Octopus",
        "Opossum",
        "Ostrich",
        "Otter",
        "Owl",
        "Oyster",
        "Panther",
        "Parrot",
        "Pelican",
        "Penguin",
        "Pig",
        "Pony",
        "Porcupine",
        "Rabbit",
        "Raccoon",
        "Raven",
        "Red_deer",
        "Red_panda",
        "Reindeer",
        "Rhinoceros",
        "Salmon",
        "Seahorse",
        "Seal",
        "Shark",
        "Sheep",
        "Snail",
        "Snake",
        "Sparrow",
        "Squid",
        "Squirrel",
        "Swan",
        "Tapir",
        "Tiger",
        "Toad",
        "Turkey",
        "Turtle",
        "Weasel",
        "Whale",
        "Wildcat",
        "Wolf",
        "Wolverine",
        "Woodpecker",
        "Zebra"];

    private $entityManager;
    private $qrCode;

    public function __construct(QRCode $QRCode, EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        $this->qrCode = $QRCode;
    }

    public function generateAccessData($number)
    {
        $results = array();

        for($i=1; $i<=$number; $i++) {
            $studentCode = $this->generateCode();
            $personInChargeCode = $this->generateCode();

            $student = new Student();
            $personInCharge = new PersonInCharge();

            $student->setCode($studentCode);
            $student->setNickname($this->generateNickname());
            $student->setQrCode($this->generateQrCode($studentCode));

            $personInCharge->setCode($personInChargeCode);
            $personInCharge->setQrCode($this->generateQrCode($personInChargeCode));

            $student->setPersonInCharge($personInCharge);

            $this->entityManager->persist($student);
            $this->entityManager->flush();

            $results[] = $student->getId();

            /*
            $results[] = array(
                'nickname' => $this->generateNickname(),
                'code' => $code,
                'qrCode' => $this->generateQrCode($code)
            );
            */
        }

        return $results;
    }

    private function generateNickname() {
        return self::ANIMALS[array_rand(self::ANIMALS)] . rand(100, 999);
    }

    private function generateCode() {
        $code = random_bytes(4);
        $code = strtoupper(bin2hex($code));

        if($this->entityManager->getRepository('App\Entity\Student')->findOneByCode($code)) {
            $this->generateCode();
        }

        return $code;
    }

    private function generateQrCode($code) {
        return $this->qrCode->render($code, '/welcome');
    }



}