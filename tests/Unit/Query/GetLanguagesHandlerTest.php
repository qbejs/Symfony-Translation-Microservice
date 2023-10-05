<?php

namespace App\Tests\Unit\Query;

use App\Application\Language\Query\GetLanguagesQuery;
use App\Application\Language\QueryHandler\GetLanguagesHandler;
use App\Domain\Models\Language;
use App\Tests\Unit\BaseTest;

class GetLanguagesHandlerTest extends BaseTest
{
    public function testItReturnsAllLanguages()
    {
        $languagesMock = [
            $this->createMock(Language::class),
            $this->createMock(Language::class),
        ];

        $this->mockLanguageRepositoryFindAll($languagesMock);

        $handler = new GetLanguagesHandler($this->languageRepository);

        $query = new GetLanguagesQuery();
        $result = $handler->__invoke($query);

        $this->assertSame($languagesMock, $result);
    }
}