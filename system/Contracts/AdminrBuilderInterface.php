<?php

namespace Adminr\System\Contracts;

use Illuminate\Http\Request;

abstract class AdminrBuilderInterface
{
    public abstract function prepare(Request $request): static;

    public abstract function processStub(string $stub): array|string;

    public abstract function build(): static;

    public abstract function rollback(): static;
}
