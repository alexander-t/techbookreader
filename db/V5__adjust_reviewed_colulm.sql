UPDATE reviews SET reviewed = replace(reviewed, ',', '');
UPDATE reviews SET reviewed = replace(reviewed, 'read', 'Read');
UPDATE reviews SET reviewed = 'January 2012' WHERE title LIKE 'Agile IT Security%';
UPDATE reviews SET reviewed = 'August 2008' WHERE title LIKE 'JUnit in Action';
UPDATE reviews SET reviewed = 'August 2008' WHERE title LIKE 'Complete Java 2 Certification Study Guide (Fifth edition)';
UPDATE reviews SET reviewed = 'August 2008' WHERE title LIKE 'Mastering Enterprise JavaBeans, 3rd edition';
UPDATE reviews SET reviewed = 'August 2008' WHERE title LIKE 'Beginning 3D Game Programming';
UPDATE reviews SET reviewed = 'August 2008' WHERE title LIKE 'Building Internet Firewalls (2nd Edition)';
UPDATE reviews SET reviewed = 'August 2008' WHERE title LIKE 'Working Effectively with Legacy Code';
UPDATE reviews SET reviewed = 'February 2012' WHERE title LIKE 'Crystal Clear: A Human-Powered Methodology for Small Teams';
UPDATE reviews SET reviewed = 'May 2012' WHERE title LIKE 'Seam Framework: Experience the Evolution of Java EE';
UPDATE reviews SET reviewed = 'March 2013' WHERE title LIKE 'Bridging the Communication Gap: Specification by Example and Agile Acceptance Testing';
UPDATE reviews SET reviewed = concat(trim(substr(reviewed, locate(' ', reviewed) + 1)), ' ', trim(substr(reviewed, 1, locate(' ', reviewed) - 1)));
UPDATE reviews SET reviewed = replace(reviewed, 'January', '-1');
UPDATE reviews SET reviewed = replace(reviewed, 'February', '-2');
UPDATE reviews SET reviewed = replace(reviewed, 'March', '-3');
UPDATE reviews SET reviewed = replace(reviewed, 'April', '-4');
UPDATE reviews SET reviewed = replace(reviewed, 'May', '-5');
UPDATE reviews SET reviewed = replace(reviewed, 'June', '-6');
UPDATE reviews SET reviewed = replace(reviewed, 'July', '-7');
UPDATE reviews SET reviewed = replace(reviewed, 'August', '-8');
UPDATE reviews SET reviewed = replace(reviewed, 'august', '-8');
UPDATE reviews SET reviewed = replace(reviewed, 'September', '-9');
UPDATE reviews SET reviewed = replace(reviewed, 'October', '-9');
UPDATE reviews SET reviewed = replace(reviewed, 'November', '-9');
UPDATE reviews SET reviewed = replace(reviewed, 'December', '-9');
UPDATE reviews SET reviewed = replace(reviewed, ' ', '');
