<?php

namespace App\Tests\Validations;

use App\Entity\Visite;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of VisiteValidationsTest
 *
 * @author jstan
 */
class VisiteValidationsTest extends KernelTestCase {

    public function getVisite(): Visite {
        return (new Visite())
                        ->setVille('New York')
                        ->setPays('USA');
    }
    
    public function assertErrors(Visite $visite, int $nbErruersAttendues, string $message = "") {
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($visite);
        $this->assertCount($nbErruersAttendues, $error, $message);
    }
    
    public function testValidNoteVisite() {
        $visite = $this->getVisite()->setNote(10);
        $this->assertErrors($visite, 0);
        $visite->setNote(1);
        $this->assertErrors($visite, 0);
        $visite->setNote(20);
        $this->assertErrors($visite, 0);
    }
    
    public function testNonValidNoteVisite() {
        $visite = $this->getVisite()->setNote(21);
        $this->assertErrors($visite, 1);
        $visite->setNote(-1);
        $this->assertErrors($visite, 1);
        $visite->setNote(-10);
        $this->assertErrors($visite, 1);
        $visite->setNote(30);
        $this->assertErrors($visite, 1);
    }
    
    public function testNonValidTempmaxVisite() {
        $visite = $this->getVisite()
                ->setTempmin(20)
                ->setTempmax(18);
        $this->assertErrors($visite, 1, "min=20, max=18 devrait échouer");
        $visite->setTempmax(10)->setTempmin(19);
        $this->assertErrors($visite, 1);
        $visite->setTempmax(11)->setTempmin(11);
        $this->assertErrors($visite, 1);
    }
    
    public function testValidTempmaxVisite() {
        $visite = $this->getVisite()
                ->setTempmin(18)
                ->setTempmax(19);
        $this->assertErrors($visite, 0, "min=20, max=18 devrait échouer");
        $visite->setTempmax(19)->setTempmin(10);
        $this->assertErrors($visite, 0);
    }
    
    public function testValidDatecreationVisite() {
        $visite = $this->getVisite()
                ->setDatecreation(new DateTime("30-01-2022"));
        $this->assertErrors($visite, 0);
        $visite->setDatecreation(new DateTime("now"));
        $this->assertErrors($visite, 0);
    }
    
    public function testNonValidDatecreationVisite() {
        $visite = $this->getVisite()
                ->setDatecreation(new DateTime("30-01-2030"));
        $this->assertErrors($visite, 1);
        $visite->setDatecreation(new DateTime("+1 day"));
        $this->assertErrors($visite, 1);
    }
    
    
}
