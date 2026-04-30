SET @dbname = DATABASE();
SET @tablename = 'accessories';
SET @columnname = 'responsible_user_id';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND COLUMN_NAME = @columnname) > 0,
  'SELECT 1',
  'ALTER TABLE `accessories` ADD COLUMN `responsible_user_id` MEDIUMINT(8) UNSIGNED NULL'
));
PREPARE stmt FROM @preparedStatement;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @fkname = 'fk_accessory_responsible_user';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
   WHERE TABLE_SCHEMA = @dbname AND TABLE_NAME = @tablename AND CONSTRAINT_NAME = @fkname) > 0,
  'SELECT 1',
  'ALTER TABLE `accessories` ADD CONSTRAINT `fk_accessory_responsible_user` FOREIGN KEY (`responsible_user_id`) REFERENCES `users`(`user_id`) ON DELETE SET NULL'
));
PREPARE stmt FROM @preparedStatement;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

