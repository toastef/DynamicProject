<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Course;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentsFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $user = $manager->getRepository(User::class)->findAll();
        $courses = $manager->getRepository(Course::class)->findAll();
        $nbcourses = count($courses);
        $nbuser = count($user);

            for($i = 0 ; $i <= 30 ; $i++)
            {
                $comment = new Comment();
                $comment->setCreatedAt(new \DateTimeImmutable())
                        ->setRating($faker->numberBetween(0,5))
                        ->setComment($faker->paragraph(5,true))
                        ->setTitle($faker->words(3,true))
                        ->setCourse($courses[$faker->numberBetween(0,$nbcourses -1)])
                        ->setUser($user[$faker->numberBetween(0,$nbuser -1)]);
                $manager->persist($comment);
            }

        $manager->flush();
    }

    public function getDependencies()
    {
       return [
           UserFixtures::class,
           CourseFixtures::class,
       ];
    }
}
