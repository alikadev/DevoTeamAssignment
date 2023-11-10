<?php

interface IController
{
    public function start() : void;
    public function setWorker(Worker $worker) : void;
}