<?php

namespace Adminr\Core\Contracts;

use Adminr\Core\Services\AdminrBuilderService;
use Illuminate\Http\Request;

interface AdminrBuilderInterface
{
    public function prepare(): static;

    public function processStub(string $stub): array|string;

    public function build(): static;

    public function rollback(): static;

    public function inject(AdminrBuilderService $service): static;
}
