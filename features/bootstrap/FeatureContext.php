<?php

use Behat\Behat\Context\Context;
use FormDev\TauxCalc\Tx\Echeance;
use PHPUnit\Framework\Assert;
use Facebook\WebDriver\WebDriverBy;
use Symfony\Component\Panther\PantherTestCaseTrait;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    use PantherTestCaseTrait;

    private $client;
    private $crawler;
    private $result;
    private $revenu;
    /**
     * @var Echeance;
     */
    private $echeance;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->result = 0;
        $this->echeance = new Echeance;
        $_SERVER['PANTHER_NO_SANDBOX'] = 1;
    }

    private function getClient()
    {
        if (!$this->client) {
            $this->client = self::createPantherClient();
        }
        return $this->client;
    }

    private function getCrawler()
    {
        if (!$this->crawler) {
            $this->crawler = $this->getClient()->request('GET', '/');
        }
        return $this->crawler;
    }

    /**
     * @Given Paul dispose d'un revenu de :revenu €
     */
    public function paulDisposeDunRevenuDeEur($revenu)
    {
        $this->revenu = $revenu;
        $this->result = $this->echeance->get($revenu);
    }

    /**
     * @Then son échéance devrait s'elever à :echeance €
     */
    public function sonEcheanceDevraitSeleverAEur($echeance)
    {
        Assert::assertEquals($echeance, $this->result);
    }

    /**
     * @When Paul le renseigne dans le champ :field
     */
    public function paulLeRenseigneDansLeChamp($field)
    {
        $element = $this->getCrawler()->findElement(WebDriverBy::id($field));
        $element->sendKeys($this->revenu)->click();
        Assert::assertEquals($this->revenu, $element->getAttribute('value'));
        $this->getClient()->wait(12);
    }

    /**
     * @When que Paul attend :seconds secondes
     */
    public function quePaulAttendSecondes($seconds)
    {
        $this->getClient()->wait($seconds);
    }

    /**
     * @Then Le champ :field devrait contenir :value €
     */
    public function leChampDevraitContenirEur($field, $value)
    {
        Assert::assertEquals(
            $value,
            $this->getCrawler()->findElement(WebDriverBy::id($field))->getAttribute('value')
        );
    }
}
