Shift-Numbers
=============

Useful for companies that runs shift duties for their customer support staffs/lines. it displays the right set of phone numbers for the right shift.

How To
======

Include the class in your code

eg.

<?php
include('shiftnumbersclass.php');
?>


Initialize the class
eg.
<?php
$foo = new shiftNumbers;
?>

use $foo->currentShiftPhoneNumbersAsString(); to get phone numbers as a string variable, $foo->currentShiftPhoneNumbers() to get phone numbers as an array and $foo->run(); to echo out the phone numbers.

Additional Infomation
=====================

Just set the class variables and input the phonenumbers in the datafile you have set in this manner(without qoutes) "080456552980/Night/Weekend - 080456552980/Morning/Weekend - 08056552980/Morning - 08076876565/Night - 08078767654/Default". Use morning for the phone numbers to display in the morning shift, night for night shift, and default for the default phone number(this will show in the free times.)
