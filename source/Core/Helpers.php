<?php

function url(string $path = null): string
{
    return CONF_URL_BASE . $path;
}