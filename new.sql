ALTER TABLE `allowances` ADD `taxable` VARCHAR(255) NULL AFTER `percent`;

ALTER TABLE `allowances` ADD `pentionable` VARCHAR(255) NULL AFTER `taxable`;




//kuadd emp_code and emp_level
ALTER TABLE `employee` ADD `emp_code` VARCHAR(100) NOT NULL AFTER `home`, ADD `emp_level` INT(100) NOT NULL AFTER `emp_code`; 