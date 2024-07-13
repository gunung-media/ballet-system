<?php

namespace App\View\Components\Fields;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public string $type;
    public string $name;
    public string $label;
    public bool $isRequired;
    public ?string $value;
    public ?string $isMoney;

    public function __construct(
        string $type,
        string $name,
        string $label,
        bool $isRequired = true,
        ?string $value = null,
        bool $isMoney = false,
    ) {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->isRequired = $isRequired;
        $this->value = $value;
        $this->isMoney = $isMoney;
    }

    public function render(): View|Closure|string
    {
        return view('components.fields.input');
    }
}
