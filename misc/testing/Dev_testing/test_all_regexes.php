<?php
if (!isset($argv[1]))
	exit("This script will test a string(release name), single quoted, against all regexes in lib/namecleaning.php. To test a string run:\nphp test_all_regexes.php '[Samurai.Warriors.3.PROPER.USA.Wii-CLANDESTiNE-Scrubbed-xeroxmalf]-[#a.b.g.w@efnet]-[www.abgx.net]-[001/176] - \"Samurai.Warriors.3.PROPER.USA.Wii-CLANDESTiNE-Scrubbed-xeroxmalf.par2\" yEnc'");
require_once(dirname(__FILE__)."/../../../www/config.php");

$file = WWW_DIR.'lib/namecleaning.php';
$handle = fopen($file, "r");

$test_str = $argv[1];

$e0 = '([-_](proof|sample|thumbs?))*(\.part\d*(\.rar)?|\.rar)?(\d{1,3}\.rev"|\.vol.+?"|\.[A-Za-z0-9]{2,4}"|")';
$e1 = $e0.' yEnc$/';

if ($handle)
{
	while (($line = fgets($handle)) !== false)
	{
		$line = preg_replace('/\$this->e0/', $e0, $line);
		$line = preg_replace('/\$this->e1/', $e1, $line);
		if (preg_match('/if \(preg_match\(\'(.+)\', \$this->subject\, \$match\)\)/', $line, $match) || preg_match('/if \(preg_match\(\'(.+)\', \$subject\, \$match\)\)/', $line, $match))
		{
			$regex = $match[1];
			if (preg_match($regex, $test_str, $match1))
			{
				echo $match[1]."\n";
				echo $match1[1]."\n\n";
			}
		}
    }
}
else
{
    echo "bad file path?\n";
}
