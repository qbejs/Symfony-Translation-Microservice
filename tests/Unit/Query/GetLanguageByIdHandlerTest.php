<?php

namespace App\Tests\Unit\Query;

use App\Application\Language\Query\GetLanguageByIdQuery;
use App\Application\Language\QueryHandler\GetLanguageByIdHandler;
use App\Domain\Models\Language;
use App\Tests\Unit\BaseTest;

class GetLanguageByIdHandlerTest extends BaseTest
{
    public function testItReturnsLanguageWhenFound()
    {
        $languageIdValue = 123;
        $languageMock = $this->createMock(Language::class);

        $this->mockLanguageRepositoryFind($languageIdValue, $languageMock);

        $handler = new GetLanguageByIdHandler($this->languageRepository);

        $query = new GetLanguageByIdQuery($languageIdValue);
        $result = $handler($query);

        $this->assertSame($languageMock, $result);
    }

    public function testItReturnsNullWhenLanguageNotFound()
    {
        $languageIdValue = 123;

        $this->mockLanguageRepositoryFind($languageIdValue, null);

        $handler = new GetLanguageByIdHandler($this->languageRepository);

        $query = new GetLanguageByIdQuery($languageIdValue);
        $result = $handler($query);

        $this->assertNull($result);
    }
}