<?php

header('Cache-Control: no-store');
header('Content-Type: text/event-stream');

while (true) {
    $curDate = date(DATE_ISO8601);
    echo 'data: This is a message at time ' . $curDate, "\n\n";

    while (ob_get_level() > 0) {
        ob_end_flush();
    }

    flush();

    if (connection_aborted()) {
        break;
    }

    sleep(1);
}
