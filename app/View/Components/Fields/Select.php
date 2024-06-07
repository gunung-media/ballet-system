<?php

namespace App\View\Components\Fields;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public string $name;
    public mixed $label;
    public ?string $value;
    public array $choices;
    public bool $isRequired;
    public bool $isMultiple;

    public function __construct(
        string $name,
        string $label,
        mixed $value = null,
        mixed $choices = null,
        bool $isRequired = true,
        bool $isMultiple = false,
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->value = !is_string($value) && isset($value) && !is_null($value) && enum_exists($value) ? $value->value : $value;
        $this->choices = is_string($choices) && enum_exists($choices)
            ? collect($choices::cases())->mapWithKeys(fn ($choice) => [$choice->value => $choice->value])->toArray()
            : $choices;
        $this->isRequired = $isRequired;
        $this->isMultiple = $isMultiple;
    }

    public function render(): View|Closure|string
    {
        return view('components.fields.select');
    }
}
