<?php

namespace FormDev\TauxCalc\Controllers;

use FormDev\TauxCalc\Tx\Pret;
use Omega\Core\Controllers\AbstractController;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PretController extends AbstractController
{
    /**
     * @var Pret
     */
    private $pret;
    public function __construct(Pret $p)
    {
        $this->pret = $p;
    }

    public function getHandle(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $content = json_decode($request->getBody()->getContents(), true);
        $response = $response->withHeader('Content-type', 'application/json');
        $response->getBody()->write(json_encode([
            'montant' => $this->pret->get($content['echeance'], $content['taux'], $content['months'])
        ]));
        return $response;
    }

}