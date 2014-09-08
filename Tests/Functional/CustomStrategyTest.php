<?php

/*
 * Copyright 2012 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace JMS\I18nRoutingBundle\Tests\Functional;

class CustomStrategyTest extends BaseTestCase
{
    public function testDefaultLocaleIsSetCorrectly()
    {
        $client = $this->createClient(array('config' => 'strategy_custom_with_hosts.yml'), array(
            'HTTP_HOST' => 'de.host',
        ));
        $client->insulate();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(1, count($locale = $crawler->filter('#locale')), substr($client->getResponse(), 0, 2000));
        $this->assertEquals('de', $locale->text());
    }

    public function testEnLocaleIsPreservedAfterException()
    {
        $client = $this->createClient(array('config' => 'strategy_prefix.yml'), array(
            'HTTP_HOST' => 'en.host',
        ));
        $client->insulate();

        $client->request('GET', '/exception');

        $request = $client->getRequest();

        $this->assertEquals('en', $request->getLocale());
    }

    public function testDeLocaleIsPreservedAfterException()
    {
        $client = $this->createClient(array('config' => 'strategy_prefix.yml'), array(
            'HTTP_HOST' => 'de.host',
        ));
        $client->insulate();

        $client->request('GET', '/exception');

        $request = $client->getRequest();

        $this->assertEquals('de', $request->getLocale());
    }
}