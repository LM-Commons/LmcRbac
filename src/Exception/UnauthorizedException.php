<?php

declare(strict_types=1);

namespace Lmc\Rbac\Exception;

use RuntimeException;

final class UnauthorizedException extends RuntimeException implements ExceptionInterface
{
}
