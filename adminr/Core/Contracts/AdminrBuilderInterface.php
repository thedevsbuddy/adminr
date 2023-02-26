<?php

namespace Adminr\Core\Contracts;

interface AdminrBuilderInterface
{
    public function prepare(): static;

    public function processStub(string $stub): array|string;

    public function build(): static;

    public function rollback(): static;
}
