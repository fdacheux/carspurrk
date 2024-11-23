<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\Brand;
use App\Entity\Model;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $brand1 = new Brand();
        $brand1->setFieldName('Yotota');
        $manager->persist($brand1);

        $brand2 = new Brand();
        $brand2->setFieldName('Pijot');
        $manager->persist($brand2);

        $model1 = new Model();
        $model1->setFieldName('Mauris');
        $model1->setAveragePrice(20000);
        $model1->setImage('modele1.jpg');
        $model1->setBrand($brand1);
        $manager->persist($model1);
        
        $model2 = new Model();
        $model2->setFieldName('Banana');
        $model2->setAveragePrice(25000);
        $model2->setImage('modele2.jpg');
        $model2->setBrand($brand2);
        $manager->persist($model2);

        $model3 = new Model();
        $model3->setFieldName('Batmobile');
        $model3->setAveragePrice(250000);
        $model3->setImage('modele3.jpg');
        $model3->setBrand($brand2);
        $manager->persist($model3);

        $model4 = new Model();
        $model4->setFieldName('JBond');
        $model4->setAveragePrice(40000);
        $model4->setImage('modele4.jpg');
        $model4->setBrand($brand1);
        $manager->persist($model4);

        $model5 = new Model();
        $model5->setFieldName('Bender');
        $model5->setAveragePrice(30000);
        $model5->setImage('modele5.jpg');
        $model5->setBrand($brand1);
        $manager->persist($model5);

        $models = [$model1, $model2, $model3, $model4, $model5];

        $faker = \Faker\Factory::create();
        foreach ($models as $model) {
            $rand = rand(3, 5);

            for ($i = 1; $i <= $rand; $i++) {
                $car = new Car();
                $car->setNumberPlate($faker->regexify("[A-Z]{2}[0-9]{3,4}[A-Z]{2}"));
                $car->setDoorsNumber($faker->randomElement($array = array(3,5)));
                $car->setYear($faker->numberBetween($min = 1990, $max = 2024));
                $car->setModel($model);
                $manager->persist($car);
            }
        }

        //PROBLEM WITH FAKER TO SOLVE https://github.com/fzaninotto/Faker

        $manager->flush();
    }
}
