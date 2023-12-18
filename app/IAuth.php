<?php

namespace App;
interface IAuth
{
    public function generateArray(): array;

    public function randArrayElement($array): int;

    public function setPnQ(): void;

    public function setX(): void;

    public function setG(): void;

    public function setY(): void;

    public function setK(): void;

    public function setS(int $e): int;

    public function setR(): void;
}