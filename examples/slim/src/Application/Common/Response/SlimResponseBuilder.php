<?php

namespace Damianopetrungaro\CleanArchitectureSlim\Application\Common\Response;

use Damianopetrungaro\CleanArchitecture\UseCase\Error\ErrorTypeInterface;
use Damianopetrungaro\CleanArchitecture\UseCase\Response\ResponseInterface;
use Damianopetrungaro\CleanArchitectureSlim\Application\Common\Error\ApplicationError;
use Damianopetrungaro\CleanArchitectureSlim\Application\Common\Error\ApplicationErrorType;
use Ramsey\Uuid\Uuid;
use Slim\Http\Response;

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
    public function setDefaultStatusCode(int $status): void
    {
        $this->status = $status;
    }

    /**
     * {@inheritdoc}
     * @return Response
     */
    public function build(ResponseInterface $response): Response
    {
        if ($response->isSuccessful()) {
            if ($response->hasData()) {
                return (new Response($this->status))->withJson($response->getData());
            }
            return new Response($this->status);
        }

        if ($response->hasErrors()) {
            return $this->buildErrorResponse($response);
        }

        return new Response(500);
    }

    /**
     * Return a Response with listed errors
     *
     * @param ResponseInterface $response
     *
     * @return Response
     */
    private function buildErrorResponse(ResponseInterface $response): Response
    {
        $status = null;
        $errorList = $response->getErrors();
        $jsonApiErrors = [];

        foreach ($errorList as $key => $errors) {
            /** @var ApplicationError $error */
            foreach ($errors as $error) {
                // Create the error response
                $jsonApiError = [
                    'id' => Uuid::uuid1(),
                    'code' => $error->code(),
                    'status' => $this->statusCodeFromErrorType($error->type())
                ];

                // Add source and meta if is an ApplicationError
                if ($error instanceof ApplicationError) {
                    $jsonApiError['source'] = ['pointer' => $error->pointer()];
                    $jsonApiError['meta'] = $error->meta();
                }

                // Create an array with a specific key if is not set
                isset($jsonApiErrors[$key]) ?: $jsonApiErrors[$key] = [];
                $jsonApiErrors[$key][] = $jsonApiError;

                // If the status code is different from the previous one, the HTTP status will be 500
                // TODO Use first status char for check error
                // Es: if errors are 401 and 422, use 400 as main status
                if ($status != null && $status !== $error->type()->getValue()) {
                    $status = 500;
                    continue;
                }
                // Else set this as current status code
                $status = $this->statusCodeFromErrorType($error->type());
            }
        }

        return (new Response($status))->withJson(['errors' => $jsonApiErrors]);
    }

    /**
     * Return the http status code
     *
     * @param $type
     *
     * @return int
     */
    private function statusCodeFromErrorType(ErrorTypeInterface $type): int
    {
        if ($type->getValue() == ApplicationErrorType::VALIDATION_ERROR) {
            return 422;
        }

        if ($type->getValue() == ApplicationErrorType::NOT_FOUND_ENTITY) {
            return 404;
        }

        if ($type->getValue() == ApplicationErrorType::PERSISTENCE_ERROR) {
            return 500;
        }
    }
}