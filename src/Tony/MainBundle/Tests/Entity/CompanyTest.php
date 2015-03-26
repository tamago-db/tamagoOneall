<?php

namespace Tony\MainBundle\Tests\Entity;

use Tony\MainBundle\Entity\Company;

class CompanyTest extends \PHPUnit_Framework_TestCase
{
    public function testSetName()
    {
        $company = new Company();

        $company->setName('Gograde');
        $this->assertEquals('Gograde', $company->getName());

        $company->setUrl('kkk.com');
        $this->assertEquals('kkk.com', $company->getUrl());
    }
}