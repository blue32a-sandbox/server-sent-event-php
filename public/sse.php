<?php
function debug($message) {
    file_put_contents('../logs/app.log', $message . "\n", FILE_APPEND);
}

ignore_user_abort(true);
header('Cache-Control: no-store');
header('Content-Type: text/event-stream');

$id = 0;

while (true) {
    $curDate = date(DATE_ISO8601);
    debug($curDate);

    // event: messageとして送信
    echo 'id: ' . ++$id . "\n";
    echo 'data: This is a message at time ' . $curDate . "\n";
    echo 'data: hoge' . "\n";
    echo "\n"; // 2つの改行文字で区切られる

    // 新しいメッセージ
    echo 'id: ' . ++$id . "\n";
    echo "event: ping\n";
    echo 'data: {"time": "' . $curDate . '", "text": "This is ping."}';
    echo "\n\n";

    while (ob_get_level() > 0) {
        ob_end_flush();
    }

    flush();

    // 何故か機能しない・・・
    if (connection_aborted()) {
        debug('connection aborted');
        break;
    }

    sleep(1);
}

debug('exit');
