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
        "Aardvark",
        "Albatross",
        "Alligator",
        "Alpaca",
        "Ant",
        "Anteater",
        "Antelope",
        "Ape",
        "Armadillo",
        "Donkey",
        "Baboon",
        "Badger",
        "Barracuda",
        "Bat",
        "Bear",
        "Beaver",
        "Bee",
        "Bison",
        "Boar",
        "Buffalo",
        "Butterfly",
        "Camel",
        "Capybara",
        "Caribou",
        "Cassowary",
        "Cat",
        "Caterpillar",
        "Cattle",
        "Chamois",
        "Cheetah",
        "Chicken",
        "Chimpanzee",
        "Chinchilla",
        "Chough",
        "Clam",
        "Cobra",
        "Cockroach",
        "Cod",
        "Cormorant",
        "Coyote",
        "Crab",
        "Crane",
        "Crocodile",
        "Crow",
        "Curlew",
        "Deer",
        "Dinosaur",
        "Dog",
        "Dogfish",
        "Dolphin",
        "Dotterel",
        "Dove",
        "Dragonfly",
        "Duck",
        "Dugong",
        "Dunlin",
        "Eagle",
        "Echidna",
        "Eel",
        "Eland",
        "Elephant",
        "Elk",
        "Emu",
        "Falcon",
        "Ferret",
        "Finch",
        "Fish",
        "Flamingo",
        "Fly",
        "Fox",
        "Frog",
        "Gaur",
        "Gazelle",
        "Gerbil",
        "Giraffe",
        "Gnat",
        "Gnu",
        "Goat",
        "Goldfinch",
        "Goldfish",
        "Goose",
        "Gorilla",
        "Goshawk",
        "Grasshopper",
        "Grouse",
        "Guanaco",
        "Gull",
        "Hamster",
        "Hare",
        "Hawk",
        "Hedgehog",
        "Heron",
        "Herring",
        "Hippopotamus",
        "Hornet",
        "Horse",
        "Human",
        "Hummingbird",
        "Hyena",
        "Ibex",
        "Ibis",
        "Jackal",
        "Jaguar",
        "Jay",
        "Jellyfish",
        "Kangaroo",
        "Kingfisher",
        "Koala",
        "Kookabura",
        "Kouprey",
        "Kudu",
        "Lapwing",
        "Lark",
        "Lemur",
        "Leopard",
        "Lion",
        "Llama",
        "Lobster",
        "Locust",
        "Loris",
        "Louse",
        "Lyrebird",
        "Magpie",
        "Mallard",
        "Manatee",
        "Mandrill",
        "Mantis",
        "Marten",
        "Meerkat",
        "Mink",
        "Mole",
        "Mongoose",
        "Monkey",
        "Moose",
        "Mosquito",
        "Mouse",
        "Mule",
        "Narwhal",
        "Newt",
        "Nightingale",
        "Octopus",
        "Okapi",
        "Opossum",
        "Oryx",
        "Ostrich",
        "Otter",
        "Owl",
        "Oyster",
        "Panther",
        "Parrot",
        "Partridge",
        "Peafowl",
        "Pelican",
        "Penguin",
        "Pheasant",
        "Pig",
        "Pigeon",
        "Pony",
        "Porcupine",
        "Porpoise",
        "Quail",
        "Quelea",
        "Quetzal",
        "Rabbit",
        "Raccoon",
        "Rail",
        "Ram",
        "Rat",
        "Raven",
        "Red_deer",
        "Red_panda",
        "Reindeer",
        "Rhinoceros",
        "Rook",
        "Salamander",
        "Salmon",
        "Sand_Dollar",
        "Sandpiper",
        "Sardine",
        "Scorpion",
        "Seahorse",
        "Seal",
        "Shark",
        "Sheep",
        "Shrew",
        "Skunk",
        "Snail",
        "Snake",
        "Sparrow",
        "Spider",
        "Spoonbill",
        "Squid",
        "Squirrel",
        "Starling",
        "Stingray",
        "Stinkbug",
        "Stork",
        "Swallow",
        "Swan",
        "Tapir",
        "Tarsier",
        "Tiger",
        "Toad",
        "Trout",
        "Turkey",
        "Turtle",
        "Viper",
        "Vulture",
        "Wallaby",
        "Walrus",
        "Wasp",
        "Weasel",
        "Whale",
        "Wildcat",
        "Wolf",
        "Wolverine",
        "Wombat",
        "Woodcock",
        "Woodpecker",
        "Worm",
        "Wren",
        "Yak",
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
            /*
            $results[] = array(
                'nickname' => $this->generateNickname(),
                'code' => $code,
                'qrCode' => $this->generateQrCode($code)
            );*/
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
        return $this->qrCode->render($code);
    }



}