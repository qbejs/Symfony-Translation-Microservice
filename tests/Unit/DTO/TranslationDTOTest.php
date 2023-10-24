<?php

namespace App\Tests\Unit\DTO;

use App\Domain\Models\DTO\TranslationDTO;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TranslationDTOTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        self::bootKernel();
        $this->validator = self::getContainer()->get(ValidatorInterface::class);
    }

    public function testDTOCanBeInstantiated(): void
    {
        $dto = new TranslationDTO();
        $dto->languageId = 1;
        $dto->source = 2;
        $dto->text = 'Hello world!';
        $dto->externalId = 3;
        $dto->externalName = 'Hello world!';

        $this->assertInstanceOf(TranslationDTO::class, $dto);
        $this->assertEquals(1, $dto->languageId);
        $this->assertEquals(2, $dto->source);
        $this->assertEquals('Hello world!', $dto->text);
        $this->assertEquals(3, $dto->externalId);
        $this->assertEquals('Hello world!', $dto->externalName);
    }

    public function testDTOWithInvalidDesiredLanguageId(): void
    {
        $dto = new TranslationDTO();
        $dto->source = 1;
        $dto->text = 'Hello world!';
        $dto->languageId = -1; // Negative ID

        $errors = $this->validator->validate($dto);
        $this->assertGreaterThan(0, count($errors));

        $error = $errors[0];
        $this->assertEquals('languageId', $error->getPropertyPath());
        $this->assertStringContainsString('This value should be positive.', $errors, $error->getMessage());
    }

    public function testDTOWithInvalidSourceLanguage(): void
    {
        $dto = new TranslationDTO();
        $dto->source = -1; // Negative ID
        $dto->text = 'Hello world!';
        $dto->languageId = 1;

        $errors = $this->validator->validate($dto);
        $this->assertGreaterThan(0, count($errors));

        $error = $errors[0];
        $this->assertEquals('source', $error->getPropertyPath());
        $this->assertStringContainsString('This value should be positive.', $errors, $error->getMessage());
    }

    public function testDTOWithInvalidTextToTranslate(): void
    {
        $dto = new TranslationDTO();
        $dto->source = 1;
        $dto->text = ''; // Empty string
        $dto->languageId = 2;

        $errors = $this->validator->validate($dto);
        $this->assertGreaterThan(0, count($errors));

        $error = $errors[0];
        $this->assertEquals('text', $error->getPropertyPath());
        $this->assertStringContainsString('This value should not be blank.', $errors, $error->getMessage());
    }

    public function testDTONullableFields(): void
    {
        $dto = new TranslationDTO();
        $dto->id = null;
        $dto->createdAt = null;
        $dto->updatedAt = null;
        $dto->deletedAt = null;
        $dto->translated = null;
        $dto->externalId = null;
        $dto->externalName = null;

        $this->assertNull($dto->id);
        $this->assertNull($dto->createdAt);
        $this->assertNull($dto->updatedAt);
        $this->assertNull($dto->deletedAt);
        $this->assertNull($dto->translated);
        $this->assertNull($dto->externalId);
        $this->assertNull($dto->externalName);
    }
}
