ALTER TABLE `allowances` ADD `taxable` VARCHAR(255) NULL AFTER `percent`;

ALTER TABLE `allowances` ADD `pentionable` VARCHAR(255) NULL AFTER `taxable`;
