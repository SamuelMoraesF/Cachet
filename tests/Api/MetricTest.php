<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Tests\Cachet\Api;

use CachetHQ\Tests\Cachet\AbstractTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MetricTest extends AbstractTestCase
{
    use DatabaseMigrations;

    public function testGetMetrics()
    {
        $metrics = factory('CachetHQ\Cachet\Models\Metric', 3)->create();

        $this->get('/api/v1/metrics');
        $this->seeJson(['id' => (string) $metrics[0]->id]);
        $this->seeJson(['id' => (string) $metrics[1]->id]);
        $this->seeJson(['id' => (string) $metrics[2]->id]);
        $this->assertResponseOk();
    }

    public function testGetInvalidMetric()
    {
        $this->get('/api/v1/metrics/0');
        $this->assertResponseStatus(404);
    }

    public function testPostMetricUnauthorized()
    {
        $this->post('/api/v1/metrics');
        $this->assertResponseStatus(401);
    }

    public function testPostMetricNoData()
    {
        $this->beUser();

        $this->post('/api/v1/metrics');
        $this->assertResponseStatus(400);
    }

    public function testPostMetric()
    {
        $this->beUser();

        $this->post('/api/v1/metrics', [
            'name'          => 'Foo',
            'suffix'        => 'foo\'s per second',
            'description'   => 'Lorem ipsum dolor',
            'default_value' => 1,
            'display_chart' => 1,
        ]);
        $this->seeJson(['name' => 'Foo']);
        $this->assertResponseOk();
    }

    public function testGetNewMetric()
    {
        $incident = factory('CachetHQ\Cachet\Models\Metric')->create();

        $this->get('/api/v1/metrics/1');
        $this->seeJson(['name' => $incident->name]);
        $this->assertResponseOk();
    }

    public function testPutMetric()
    {
        $this->beUser();
        $metric = factory('CachetHQ\Cachet\Models\Metric')->create();

        $this->put('/api/v1/metrics/1', [
            'name' => 'Foo',
        ]);
        $this->seeJson(['name' => 'Foo']);
        $this->assertResponseOk();
    }

    public function testDeleteMetric()
    {
        $this->beUser();
        $metric = factory('CachetHQ\Cachet\Models\Metric')->create();

        $this->delete('/api/v1/metrics/1');
        $this->assertResponseStatus(204);
    }
}
