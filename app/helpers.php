<?php

function status(int $status, $content = null, array $headers = [])
{
    return response($content, $status, $headers);
}
