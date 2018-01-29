<?php

/*
 * This file is part of ibrand/setting.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use iBrand\Component\Setting\Models\SystemSetting;
use iBrand\Component\Setting\Repositories\EloquentSetting;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/29
 * Time: 16:11.
 */
class EloquentSettingTest extends BaseTest
{
    protected $setting;

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->loadMigrationsFrom(__DIR__.'/database');

        $this->setting = new EloquentSetting(new SystemSetting());
    }

    public function testSet()
    {
        //test string value.
        $setting = $this->setting->setSetting(['key' => 'value']);
        $this->assertSame(iBrand\Component\Setting\Models\SystemSetting::class, get_class($setting));
        $this->assertSame('key', $setting->key);
        $this->assertSame('value', $setting->value);

        //test 0 value.
        $setting0 = $this->setting->setSetting(['key0' => 0]);
        $this->assertSame(0, $setting0->value);

        //test "" string.
        $setting1 = $this->setting->setSetting(['key1' => '']);
        $this->assertSame('', $setting1->value);

        //test array
        $setting2 = $this->setting->setSetting(['key2' => ['key1' => 'value1', 'key2' => 'value2']]);
        $this->assertSame(2, count($setting2->value));
        $this->assertSame(['key1' => 'value1', 'key2' => 'value2'], $setting2->value);

        //test bool
        $setting3 = $this->setting->setSetting(['key3' => true]);
        $this->assertTrue($setting3->value);

        $setting4 = $this->setting->setSetting(['key4' => false]);
        $this->assertFalse($setting4->value);
    }

    public function testGet()
    {
        //test string value.
        $setting = $this->setting->setSetting(['key' => 'value']);
        $this->assertSame('value', $this->setting->getSetting('key'));
        //test 0 value.
        $setting0 = $this->setting->setSetting(['key0' => 0]);
        $this->assertSame(0, $this->setting->getSetting('key0'));

        //test "" string.
        $setting1 = $this->setting->setSetting(['key1' => '']);
        $this->assertSame('', $this->setting->getSetting('key1'));

        //test array
        $setting2 = $this->setting->setSetting(['key2' => ['key1' => 'value1', 'key2' => 'value2']]);
        $this->assertSame(2, count($this->setting->getSetting('key2')));
        $this->assertSame(['key1' => 'value1', 'key2' => 'value2'], $this->setting->getSetting('key2'));

        //test bool
        $setting3 = $this->setting->setSetting(['key3' => true]);
        $this->assertTrue($this->setting->getSetting('key3'));

        $setting4 = $this->setting->setSetting(['key4' => false]);
        $this->assertFalse($this->setting->getSetting('key4'));
    }
}
