<?php

namespace Extcode\CartProducts\Reaction;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use TYPO3\CMS\Reactions\Model\ReactionInstruction;
use TYPO3\CMS\Reactions\Reaction\ReactionInterface;

class UpdateStockReaction implements ReactionInterface
{
    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly StreamFactoryInterface $streamFactory
    ) {}

    public static function getType(): string
    {
        return 'cart-products-update-stock-reaction';
    }

    public static function getDescription(): string
    {
        return 'LLL:EXT:cart_products/Resources/Private/Language/locallang.xlf:reaction.update-stock.description';
    }

    public static function getIconIdentifier(): string
    {
        return 'ext-cartproducts-extension-icon';
    }

    public function react(
        ServerRequestInterface $request,
        array $payload,
        ReactionInstruction $reaction
    ): ResponseInterface {
        $payloadDecoded = json_decode((string)json_encode($payload), true);

        if (isset($payloadDecoded['productId'])) {
            return $this->jsonResponse(['status' => 'stock was updated']);
        }
        return $this->jsonResponse(['status' => 'product not available'], 404);
    }

    protected function jsonResponse(array $data, int $statusCode = 200): ResponseInterface
    {
        return $this->responseFactory
            ->createResponse($statusCode)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream((string)json_encode($data)));
    }
}
