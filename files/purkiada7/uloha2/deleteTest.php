<?
unlink(__DIR__ . '/files/test/log/adminsearched.log');
unlink(__DIR__ . '/files/test/log/edited.log');
unlink(__DIR__ . '/files/test/log/loggedadmin.log');
unlink(__DIR__ . '/files/test/log/passwordreset.log');
rmdir(__DIR__ . '/files/test/log');
unlink(__DIR__ . '/files/test/texts/edit.txt');
unlink(__DIR__ . '/files/test/texts/text1.txt');
unlink(__DIR__ . '/files/test/texts/text2.txt');
rmdir(__DIR__ . '/files/test/texts');
rmdir(__DIR__ . '/files/test');
