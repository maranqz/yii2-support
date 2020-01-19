<?php

namespace SSupport\Module\Core\UseCase\Form;

interface FileAcceptAwareInterface
{
    public function getAcceptType(): string;
}
