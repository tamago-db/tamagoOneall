<?php
/**
 * Created by PhpStorm.
 * User: TONY
 * Date: 12/4/14
 * Time: 2:40 AM
 */

namespace Tony\MainBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Tony\MainBundle\Entity\Comment;
use Tony\MainBundle\Entity\Company;

class CommentFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $comment = new Comment();
        $comment->setUser('Tony');
        $comment->setComment('Competitive salary and good benefits; lots of opportunities for training; encouraged attendance and speaking at conferences; overall good consulting experience');
        $comment->setCompany($manager->merge($this->getReference('Company-1')));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Jim');
        $comment->setComment('Work life balance can be tricky due to the high amount of travel and sometimes long hours, but this is expected in consulting');
        $comment->setCompany($manager->merge($this->getReference('Company-1')));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('TingTing');
        $comment->setComment('office building was stuffy, Management was unfriendly,Flexible hours, Telecommuting, good vacation, good pay.');
        $comment->setCompany($manager->merge($this->getReference('Company-4')));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('YangYang');
        $comment->setComment('Great people, stimulating work, good work/life balance. Large projects, exciting clients, great "people" culture. Get stuck doing one-type of role ; managers need to listen to employees; easy to get burned out. ');
        $comment->setCompany($manager->merge($this->getReference('Company-3')));
        $comment->setCreated(new \DateTime("2014-11-23 06:15:20"));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('DaWei');
        $comment->setComment('You perform to meet your KPIs, working very hard, long hours, very diligently. KPIs are clear and achievable.Career growth is unattainable.');
        $comment->setCompany($manager->merge($this->getReference('Company-2')));
        $comment->setCreated(new \DateTime("2014-11-23 06:18:35"));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Kitty');
        $comment->setComment('Work life Balance, Great Benefits.(401K, Medical Insurance,etc..). Projects assignment, compensation could be better.');
        $comment->setCompany($manager->merge($this->getReference('Company-3')));
        $comment->setCreated(new \DateTime("2014-11-23 06:22:53"));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('DaMeng');
        $comment->setComment('Training:- Great Learning material on their website. Web sessions, Books, Classroom etc. This is a major plus point. Work Life Balance:- Will depend on the account/practice you work for. If you are in a client facing role with an offshore team, you will really have to spend the extra hours to deliver. If you are in a client facing role in a staff aug position, the work load may not be as much. ');
        $comment->setCompany($manager->merge($this->getReference('Company-1')));
        $comment->setCreated(new \DateTime("2014-11-23 06:25:15"));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Tony');
        $comment->setComment('Provided the opportunity to meet and build relationships with people from different backgrounds. I was presented with opportunities to work on things that broadened my scope of expertise.');
        $comment->setCompany($manager->merge($this->getReference('Company-2')));
        $comment->setCreated(new \DateTime("2014-11-23 06:46:08"));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('TingTing');
        $comment->setComment('The leadership did not necessarily invest a great time behind individual success within the company. It would have been nice for some to really care about ones success as they reach different milestones within the company.');
        $comment->setCompany($manager->merge($this->getReference('Company-4')));
        $comment->setCreated(new \DateTime("2014-11-23 10:22:46"));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('XiaoFang');
        $comment->setComment('Awesome place to work as well as great time with co-workers. Had a phenomenal company culture centered around a work hard-play hard environment.');
        $comment->setCompany($manager->merge($this->getReference('Company-1')));
        $comment->setCreated(new \DateTime("2014-11-23 11:08:08"));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('YangYang');
        $comment->setComment('This job is really great. Anyone can do it and they guarentee you a base so you make $16 for each Apt which usually takes around an hour. There is a lot of leg work with phoning to get your appointments but the base is just your training wheels. You can make as little or as much as your willing to work for. You choose your hours so you can work around your schedule which is awesome. And the commissions start at 10% and go up to 50% so theres lots of potential.');
        $comment->setCompany($manager->merge($this->getReference('Company-4')));
        $comment->setCreated(new \DateTime("2014-11-24 18:56:01"));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('WeiWei');
        $comment->setComment('If you are a motivated sales person and can grow a book of business with a great company culture - this is the place to do it. Yes many prospects are taken but if you are creative and willing to put in some additional effort, you can make six-figure earnings within the first 3 years');
        $comment->setCompany($manager->merge($this->getReference('Company-4')));
        $comment->setCreated(new \DateTime("2014-11-25 22:28:42"));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Stanley');
        $comment->setComment('Flexible scheduling was offered and was important to me as a high school student. Most of my co-workers were also in high school, which made it easier to transition into the job. ');
        $comment->setCompany($manager->merge($this->getReference('Company-3')));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setUser('Gabriel');
        $comment->setComment('The team I worked with was great! I loved the people I worked with and my Team Leader was a great manager.');
        $comment->setCompany($manager->merge($this->getReference('Company-4')));
        $manager->persist($comment);
        

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}