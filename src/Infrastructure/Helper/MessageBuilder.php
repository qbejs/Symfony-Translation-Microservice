<?php

namespace App\Infrastructure\Helper;

// Twig message builder for notifications

use App\Domain\Models\NotificationType;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MessageBuilder
{
    public function __construct(private readonly \Twig\Environment $twig)
    {
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function build(NotificationType $message, array $params = [], bool $stripHtml = false): string
    {
        $renderedMessage = $this->twig->render($message->getContent(), $params);

        if ($stripHtml) {
            return strip_tags($renderedMessage);
        }

        return $renderedMessage;
    }
}
