<?php

namespace MASNathan\Config\Test;

use MASNathan\Config\Config;

/**
 * @coversDefaultClass \MASNathan\Config\Config
 */
class ConfigTest extends \PHPUnit_Framework_TestCase
{

    public function extensions()
    {
        return array(
            array('ini'),
            array('json'),
            array('php'),
            array('xml'),
            array('yml'),
        );
    }

    /**
     * @param $extension
     *
     * @dataProvider extensions
     */
    public function testRead($extension)
    {
        $resultValues = array(
            'config' => array(
                'github' => 'https://github.com/ReiDuKuduro',
                'me' => array(
                    'name' => 'Andre',
                    'surname' => 'Filipe',
                    'email' => 'andre.r.flip@gmail.com',
                ),
            ),
            'database' => array(
                'host' => 'localhost',
                'name' => 'config4all',
                'user' => 'root',
                'pass' => 'xpto',
            ),
        );

        $config = new Config;
        $config->read(__DIR__ . '/configs/*.' . $extension);
        $this->assertEquals($resultValues, $config->get());
    }
}
