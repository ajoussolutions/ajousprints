<?php

/**
 * Check if node is installed (Windows and Linux)
 */
function isNodeInstalled() {
    return file_exists('/usr/bin/node') || file_exists('C:\Program Files\nodejs\node.exe');
}





