<?php
namespace Jankx\Template\Exceptions;

class TemplateException extends \Exception
{
    const TEMPLATE_EXCEPTION_ENGINE_NOT_FOUND      = 7301;
    const TEMPLATE_EXCEPTION_INVALID_ENGINE        = 7302;
    const TEMPLATE_EXCEPTION_INVALID_BOILERPLATE   = 7303;
    const TEMPLATE_EXCEPTION_NOT_FOUND_BOILERPLATE = 7304;
}
