<?php

namespace app;
require_once '../vendor/autoload.php';
class Auth implements IAuth
{
    public IUser $user;
    public int $p;
    public int $q;
    public int $x;
    public int $g;
    public int $y;
    public int $k;
    public int $r;
    public int $s;

    public function __construct()
    {
        $this->setPnQ();
        $this->setX();
        $this->setG();
        $this->setY();
        $this->setK();
        $this->setR();
    }

    public function setPnQ(): void
    {
        $array = $this->generateArray();

        while (true) {
            $p = $this->randArrayElement($array);
            $q = $this->randArrayElement($array);
            if ((($p - 1) % $q) == 0) {
                $this->p = $p;
                $this->q = $q;
                return;
            }
        }
    }

    public function setX(): void
    {
        $this->x = rand(2, $this->q - 1);
    }

    public function setG(): void
    {
        $bool = true;
        $i = 2;
        while ($bool) {
            if ((pow($i,$this->q) % $this->p) == 1) {
                $bool = false;
                $this->g = $i;
            } else {
                $i++;
            }
        }
    }

    public function setR(): void
    {
        $this->r = bcpowmod($this->g , $this->k , $this->p);
    }

    public function setY(): void
    {
        $bool = true;
        $y = 1;
        while ($bool) {
            if (((pow($this->g,$this->x) * $y) % $this->p) == 1) {
                $bool = false;
                $this->y = $y;
            } else {
                $y++;
            }
        }
    }
    public function setK(): void
    {
        $this->k = rand(1, $this->q);
    }

    public function setS(int $e): int
    {
        return ($this->k + ($this->x * $e)) % $this->q;
    }
    public function generateArray(): array
    {
        $array = [];
        $N = rand(10, 100);
        for ($i = 5; $i < $N; $i++) {
            $count = 0;
            for ($j = 2; $j <= sqrt($i); $j++) {
                if ($i % $j == 0) {
                    $count++;
                }
            }
            if ($count == 0) {
                $array[] = $i;
            }
        }
        return $array;
    }

    public function randArrayElement($array): int
    {
        $k = array_rand($array);
        return $array[$k];
    }

}