<?php

namespace App\Enum;

enum UserTitleEnum: string
{
    case STUDENT = 'student';
    case TEACHER = 'teacher';
    case EMPLOYEE = 'employee';
}