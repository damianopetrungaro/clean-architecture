<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Common\Response;

use Damianopetrungaro\CleanArchitecture\UseCase\Error\ErrorType;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\Response;
use Damianopetrungaro\CleanArchitectureSlim\Common\Error\ApplicationError;
use Damianopetrungaro\CleanArchitectureSlim\Common\Error\ApplicationErrorType;
use Ramsey\Uuid\Uuid;
use Slim\Http\Response as SlimResponse;

final class SlimResponseBuilder implements ResponseBuilderInterface
{
    /**
     * @var int $status
     */
    private $status = 200;

    /**
     * Override default success status code
     *
     * @param int $status
     */
    public function setDefaultSuccessStatusCode(int $status): void
    {
        $this->status = $status;
    }

    /**
     * {@inheritdoc}
     *
     * @return SlimResponse
     */
    public function build(Response $response): SlimResponse
    {
        if ($response->isSuccessful()) {
            return $this->buildSuccessResponse($response);
        }

        if ($response->hasErrors()) {
            return $this->buildErrorResponse($response);
        }

        return new SlimResponse(500);
    }

    /**
     * Return a CollectionResponse with a standardized response
     *
     * @param Response $response
     *
     * @return CollectionResponse
     */
    private function buildSuccessResponse(Response $response): SlimResponse
    {
        if ($response->hasData()) {
            return (new SlimResponse($this->status))->withJson(['data' => $response->getData()]);
        }

        return new SlimResponse($this->status);
    }

    /**
     * Return a CollectionResponse with listed errors
     *
     * @param Response $response
     *
     * @return CollectionResponse
     */
    private function buildErrorResponse(Response $response): SlimResponse
    {
        $status = null;
        $errorList = $response->getErrors();
        $jsonApiErrors = [];

        /** @var ApplicationError $error */
        foreach ($errorList as $key => $error) {
            // Create the error response
            $jsonApiError = [
                'id' => Uuid::uuid1(),
                'code' => $error->code(),
                'status' => $this->statusCodeFromErrorType($error->type())
            ];

            // Add source and meta if is an ApplicationError and are set
            if ($error instanceof ApplicationError) {
                !$error->pointer() ?: $jsonApiError['source'] = ['pointer' => $error->pointer()];
                !$error->meta() ?: $jsonApiError['meta'] = $error->meta();
            }

            // Create an array with a specific key if is not set
            isset($jsonApiErrors[$key]) ?: $jsonApiErrors[$key] = [];
            $jsonApiErrors[$key][] = $jsonApiError;

            // If the status code is different from the previous one, the HTTP status will be 500
            // TODO Use first status char for check error
            // Es: if errors are 401 and 422, use 400 as main status
            if ($status !== null && $status !== $this->statusCodeFromErrorType($error->type())) {
                $status = 500;
                continue;
            }
            // Else set this as current status code
            $status = $this->statusCodeFromErrorType($error->type());

        }

        return (new SlimResponse($status))->withJson(['errors' => $jsonApiErrors]);
    }

    /**
     * Return the http status code
     *
     * @param $type
     *
     * @return int
     */
    private function statusCodeFromErrorType(ErrorType $type): int
    {
        if (in_array($type->getValue(), [ApplicationErrorType::VALIDATION_ERROR, ApplicationErrorType::USER_PASSWORD_MISMATCH], true)) {
            return 422;
        }

        if ($type->getValue() === ApplicationErrorType::USER_PASSWORD_MISMATCH) {
            return 422;
        }

        if ($type->getValue() === ApplicationErrorType::NOT_FOUND_ENTITY) {
            return 404;
        }

        if ($type->getValue() === ApplicationErrorType::PERSISTENCE_ERROR) {
            return 500;
        }

        return 500;
    }
}