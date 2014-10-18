<?php
namespace Server\V1\Rpc\Info;

class InfoControllerFactory
{
    public function __invoke($controllers)
    {
        return new InfoController();
    }
}
