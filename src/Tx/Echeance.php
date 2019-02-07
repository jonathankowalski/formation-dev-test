<?php

namespace FormDev\TauxCalc\Tx;


class Echeance
{
    public function get($montant)
    {
        if (!is_numeric($montant)) {
            $montant = 0;
        }
        return round($montant*33/100, 2);
    }
}