//List of provider domains available at https://davidwalsh.name/demo/SMS-Carriers.pdf
//Some of them might be out of date, but verizon works at least with the domain @vtext.com

<?php mail("<phone number>@<provider domain>", "<subject>", "<message text>", "From: <personal trainer name> <<email address>>\r\n"); ?>

//Example:
//mail("5555555555@vtext.com", "subject example", "Testing SMS through PHP", "From: Greg <boyarkogc@gmail.com>\r\n");
//note that you do need the brackets around the email, but not anywhere else
