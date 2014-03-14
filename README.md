Induction
=========

(c) 2004 LG Coding

Induction software I wrote for a friend whilst high on post-op medication.

Induction records user details before letting them undertake an induction course. The next time they attend site they will enter these details in and if the visit is within the accepted range (typically a year) they don't have to do the induction again.

Induction allows multiple courses - this repo only includes one titled 'visitor' although there is technically no limit.

Each course is built off Powerpoint presentations being converted to .HTML files. These files need to be edited to include some PHP code at the top (see the files inside 'visitor/' for more information) in order to work correctly.

Also found in the sample course is whats called a 'stitch' - this allows you to have the user confirm a question before continuing. It's easy enough for them to lie, but if they finish then you can safely presume they answered 'Yes' to the question and they don't have any recourse. If they answer 'No', then their progress in this course is halted until they revisit the course and answer 'Yes'.

There is an administration function which allows queries to be run as well as some variables to be changed.

Requirements
------------
Apache v2 or higher
PHP 5.x
MySQL (database class is written for this but any SQL db can be substituted with minimal fuss, see *db.class.php*)
A sense of Humour

Disclaimer
----------

I wrote this code in 2004 after I had a parathyroidectomy - I was literally still drugged up to my gills when I was asked to write this. I also didn't have access to the internet at the time so most of the code was written from memory. I have looked through the code throughout the years and have been thouroughly disgusted by it - for instance the code in which it checks if it has been mroe than one year since their last induction completion originally was >200 lines long! It's certianly much shorter now but ther are bits in there that I don't like. Feel free to use whatever you like, just don't moan about my shonky code :) - cizzit, 2014
