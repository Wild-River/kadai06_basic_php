<?php
// XSS対策関数
function h($val)
{
    return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
}
