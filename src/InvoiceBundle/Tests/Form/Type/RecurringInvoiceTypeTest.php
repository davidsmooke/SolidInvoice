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

namespace SolidInvoice\InvoiceBundle\Tests\Form\Type;

use Cron\CronExpression;
use Money\Currency;
use SolidInvoice\CoreBundle\Entity\Discount;
use SolidInvoice\CoreBundle\Form\Type\DiscountType;
use SolidInvoice\CoreBundle\Tests\FormTestCase;
use SolidInvoice\InvoiceBundle\Entity\RecurringInvoice;
use SolidInvoice\InvoiceBundle\Form\Type\ItemType;
use SolidInvoice\InvoiceBundle\Form\Type\RecurringInvoiceType;
use SolidInvoice\MoneyBundle\Entity\Money;
use Symfony\Component\Form\PreloadedExtension;

class RecurringInvoiceTypeTest extends FormTestCase
{
    public function testSubmit(): void
    {
        $notes = $this->faker->text;
        $terms = $this->faker->text;
        $discountValue = $this->faker->numberBetween(0, 100);
        $formData = [
            'client' => null,
            'discount' => [
                'value' => $discountValue,
                'type' => Discount::TYPE_PERCENTAGE,
            ],
            'items' => [],
            'notes' => $notes,
            'terms' => $terms,
            'total' => 0,
            'baseTotal' => 0,
            'tax' => 0,
            'frequency' => (string) CronExpression::factory('@weekly'),
            'date_start' => $this->faker->dateTime,
            'date_end' => $this->faker->dateTime,
        ];

        $object = new RecurringInvoice();
        $object->setFrequency('0 0 * * 0');

        Money::setBaseCurrency('USD');

        $data = clone $object;

        $object->setTerms($terms);
        $object->setNotes($notes);
        $discount = new Discount();
        $discount->setType(Discount::TYPE_PERCENTAGE);
        $discount->setValue($discountValue);
        $object->setDiscount($discount);
        $object->setTotal(new \Money\Money(0, new Currency('USD')));
        $object->setTax(new \Money\Money(0, new Currency('USD')));
        $object->setBaseTotal(new \Money\Money(0, new Currency('USD')));

        $this->assertFormData($this->factory->create(RecurringInvoiceType::class, $data), $formData, $object);
    }

    protected function getExtensions()
    {
        $currency = new Currency('USD');

        $invoiceType = new RecurringInvoiceType($currency);
        $itemType = new ItemType($this->registry);

        return [
            // register the type instances with the PreloadedExtension
            new PreloadedExtension([$invoiceType, $itemType, new DiscountType($currency)], []),
        ];
    }
}
