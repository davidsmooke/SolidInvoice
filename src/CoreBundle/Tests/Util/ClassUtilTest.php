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

namespace SolidInvoice\CoreBundle\Tests\Util;

use PHPUnit\Framework\TestCase;
use SolidInvoice\CoreBundle\Util\ClassUtil;

class ClassUtilTest extends TestCase
{
    public function testFindClassInFile()
    {
        if (PHP_VERSION_ID >= 80000) {
            static::assertSame('1\\ClassUtilTest', ClassUtil::findClassInFile(__FILE__));
        } else {
            static::assertSame(ClassUtilTest::class, ClassUtil::findClassInFile(__FILE__));
        }
    }

    public function testFindClassInFileWithInvalidFile()
    {
        static::assertNull(ClassUtil::findClassInFile(dirname(__DIR__).'/Fixtures/file.php'));
    }
}
