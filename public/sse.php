<?php
function debug($message) {
    file_put_contents('../logs/app.log', $message . "\n", FILE_APPEND);
}

ignore_user_abort(false);
header('Cache-Control: no-store');
header('Content-Type: text/event-stream');

while (true) {
    $curDate = date(DATE_ISO8601);
    debug($curDate);
    echo 'data: This is a message at time ' . $curDate, "\n\n";

    while (ob_get_level() > 0) {
        ob_end_flush();
    }

    flush();

    if (connection_aborted()) {
        debug('connection aborted');
        break;
    }

    sleep(1);
}

debug('exit');
