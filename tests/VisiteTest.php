<?php

namespace App\Tests;

use App\Entity\Environnement;
use App\Entity\Visite;
use DateTime;
use PHPUnit\Framework\TestCase;

;

/**
 * Description of VisiteTest
 *
 * @author jstan
 */
class VisiteTest extends TestCase {

    public function testGetDatecreationString() {
        $visite = new Visite();
        $visite->setDatecreation(new DateTime("2024-04-24"));
        $this->assertEquals("24/04/2024", $visite->getDatecreationString());
    }

    public function testAddEnvironnementExistant() {
        $visite = new Visite();
        $env = new Environnement("Montagnes");

        $visite->addEnvironnement($env);

        // Add the same environment again
        $visite->addEnvironnement($env);

        // Assert that there is only one environment in the list
        $this->assertCount(1, $visite->getEnvironnements());
        $this->assertSame($env, $visite->getEnvironnements()[0]);
    }
}
