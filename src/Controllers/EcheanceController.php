<?php

namespace FormDev\TauxCalc\Controllers;

use Omega\Core\Controllers\AbstractController;
use FormDev\TauxCalc\Tx\Echeance;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class EcheanceController extends AbstractController
{
    /**
     * @var Echeance
     */
    private $echeance;
    public function __construct(Echeance $e)
    {
        $this->echeance = $e;
    }

    public function getHandle(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $content = json_decode($request->getBody()->getContents(), true);
        $response = $response->withHeader('Content-type', 'application/json');
        $response->getBody()->write(json_encode([
            'montant' => $this->echeance->get($content['montant'])
        ]));
        return $response;
    }

}