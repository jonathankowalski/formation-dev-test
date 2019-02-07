<?php

namespace FormDev\TauxCalc\Tx;

/**
 * Class Pret
 * @package FormDev\TauxCalc\Tx
 *
 * Mensualité = ( K x T ) / ( 1 - ( 1 + T )^-d )
 *
 * Capital = M x (1 - ( 1 + T )^-d  ) / T )
 */
class Pret
{
    public function get($echeance, $taux, $months)
    {
        $tauxMensuel = $taux/12;
        return round($echeance * (1 - (1 + $tauxMensuel) ** -$months) / $tauxMensuel);
    }
}