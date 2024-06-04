<?php

namespace App\View\Components\Fields;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public string $name;
    public string $label;
    public bool $isRequired;
    public array $choices;

    public function __construct(
        string $name,
        string $label,
        bool $isRequired = true,
        mixed $choices = null
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->isRequired = $isRequired;
        $this->choices = is_string($choices) && enum_exists($choices) ? collect($choices::cases())->mapWithKeys(fn ($choice) => [$choice->name => $choice->value])->toArray() : $choices;
    }

    public function render(): View|Closure|string
    {
        return view('components.fields.select');
    }
}
