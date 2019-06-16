<?php
namespace Jankx\Template;

use Jankx\Exception as JankxException;

class Exception extends JankxException
{
    const TEMPLATE_EXCEPTION_ENGINE_NOT_FOUND = 7301;
    const TEMPLATE_EXCEPTION_INVALID_ENGINE   = 7302;
}
