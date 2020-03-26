<?php
/*
$output = shell_exec('ls -lart');
echo "<pre>$output</pre>";

echo "Below me should be an analysis. If there isn't I will scream";

$output = shell_exec('gcloud');
echo "<pre>$output</pre>";

*/


echo '<p>come on</p>';
#chdir('/');
#echo '<p>'.$_SERVER['DOCUMENT_ROOT'].'</p>';
#echo '<p>'.getcwd().'</p>';
# Includes the autoloader for libraries installed with composer
#include '/home/bitnami/vendor/autoload.php';
require'/home/bitnami/vendor/autoload.php';
echo '<p>test2</p>';

# Imports the Google Cloud client library
use Google\Cloud\Language\LanguageClient;

# Your Google Cloud Platform project ID
$projectId = 'dactr-272020';

# Instantiates a client ['projectId' => $projectId]
$language = new LanguageClient(['projectId' => $projectId]);

# The text to analyze
$text = "I love garlic bread! It's by far the best type of bread on earth.";
echo '<p>'.$text.'</p>';
/*
# Detects the sentiment of the text   analyzeSentiment()
$annotation = $language->analyzeSentiment("I love garlic bread! It's by far the best type of bread on earth.");
echo '<p>bro i am screaming 1</p>';
$sentiment = $annotation->sentiment();
echo '<p>bro i am screaming 2</p>';
echo "<p>Text: " . $text . "Sentiment: " . $sentiment['score'] . ", " . $sentiment['magnitude'] . "</p>";
*/
$annotation = $language->analyzeSentiment('Google Cloud Platform is a powerful tool.');
echo '<p>test3</p>';
$sentiment = $annotation->sentiment();

echo '<p>'.$sentiment['score'].'</p>';
if ($sentiment['score'] > 0) {
    echo '<p>This is a positive message.</p>';
}
?>
