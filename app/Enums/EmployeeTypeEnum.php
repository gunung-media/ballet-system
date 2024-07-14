<?php

namespace App\Enums;

enum EmployeeTypeEnum: string
{
    case teacher = 'Guru';
    case teacherAssistant = 'Asisten Guru';
    case employee = 'employee';
}
