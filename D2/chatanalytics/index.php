<?php
$json_data = file_get_contents('result.json');
$data = json_decode($json_data, true);

$messages_sent = $data['messages_sent'];
$messages_received = $data['messages_received'];

$total_sent = count($messages_sent);
$total_received = count($messages_received);

function average_length($messages) {
    $total_length = array_sum(array_map('strlen', $messages));
    return $total_length / count($messages);
}

$average_length_sent = average_length($messages_sent);
$average_length_received = average_length($messages_received);

$words_sent = [];
foreach ($messages_sent as $message) {
    $words = str_word_count(strtolower($message), 1);
    foreach ($words as $word) {
        if (isset($words_sent[$word])) {
            $words_sent[$word]++;
        } else {
            $words_sent[$word] = 1;
        }
    }
}

arsort($words_sent);
$top_words_sent = array_slice($words_sent, 0, 5);

echo "<h2>Chat Analytics</h2>";
echo "<p><strong>Top 5 send words :</strong></p><ul>";
foreach ($top_words_sent as $word => $count) {
    echo "<li>$word ($count times)</li>";
}
echo "</ul>";
echo "<p><strong>Total messages sent :</strong> $total_sent</p>";
echo "<p><strong>Total messages received :</strong> $total_received</p>";
echo "<p><strong>Average character length sent :</strong> " . round($average_length_sent, 2) . "</p>";
echo "<p><strong>Average character length received :</strong> " . round($average_length_received, 2) . "</p>";
?>
