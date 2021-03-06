<?php

declare(strict_types=1);

/*
 * This file is part of SolidInvoice project.
 *
 * (c) 2013-2017 Pierre du Plessis <info@customscripts.co.za>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SolidInvoice\MailerBundle\Tests\Form\Type\TransportConfig;

use SolidInvoice\CoreBundle\Tests\FormTestCase;
use SolidInvoice\MailerBundle\Form\Type\TransportConfig\MailgunApiTransportConfigType;

class MailgunApiTransportConfigTypeTest extends FormTestCase
{
    public function testSubmit(): void
    {
        $formData = [
            'key' => 'foobar',
            'domain' => 'baz',
        ];

        $this->assertFormData(MailgunApiTransportConfigType::class, $formData, ['key' => 'foobar', 'domain' => 'baz']);
    }
}
