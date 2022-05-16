<?php

namespace App\Repositories;

use App\Models\Coin;

class CoinRepo
{
    /**
     * @var Coin
     */
    private $coin;

    /**
     * @param Coin $coin
     */
    public function __construct(Coin $coin)
    {
        $this->coin = $coin;
    }

    public function all(){
        return $this->coin->all();
    }

}
