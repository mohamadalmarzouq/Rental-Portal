-- Columns and tables added after the May 2020 dump.
-- Laravel's default "password" hash so local login is known.

ALTER TABLE `users`
    ADD COLUMN `overdue_days` INT NULL AFTER `photo`,
    ADD COLUMN `grace_period` INT NULL AFTER `overdue_days`,
    ADD COLUMN `due_date` INT NULL AFTER `grace_period`,
    ADD COLUMN `over_due_date` INT NULL AFTER `due_date`,
    ADD COLUMN `logo` VARCHAR(255) NULL AFTER `over_due_date`,
    ADD COLUMN `company_name` VARCHAR(255) NULL AFTER `logo`,
    ADD COLUMN `company_address` VARCHAR(255) NULL AFTER `company_name`,
    ADD COLUMN `login_token` TEXT NULL AFTER `company_address`;

ALTER TABLE `units`
    ADD COLUMN `no_of_livingrooms` INT NULL,
    ADD COLUMN `unit_description` INT NULL,
    ADD COLUMN `no_of_kitchens` VARCHAR(255) NULL;

ALTER TABLE `invoice_extras`
    ADD COLUMN `property_id` BIGINT NULL AFTER `id`,
    ADD COLUMN `unit_id` BIGINT NULL AFTER `property_id`,
    ADD COLUMN `lease_id` BIGINT NULL AFTER `unit_id`,
    ADD COLUMN `tenant_id` BIGINT NULL AFTER `lease_id`,
    ADD COLUMN `waive_amount` DOUBLE NULL AFTER `amount`;

ALTER TABLE `invoices`
    ADD COLUMN `deposit` TINYINT(1) NULL DEFAULT 0;

ALTER TABLE `leases`
    ADD COLUMN `residence_type` VARCHAR(255) NULL,
    ADD COLUMN `marriage_status` VARCHAR(255) NULL,
    ADD COLUMN `attachments` VARCHAR(255) NULL,
    ADD COLUMN `due_date` DATE NULL,
    ADD COLUMN `advance_payment` DOUBLE NULL,
    ADD COLUMN `waived_amount` DOUBLE NULL,
    ADD COLUMN `deposit` DOUBLE NULL,
    ADD COLUMN `attachment_name` VARCHAR(255) NULL;

ALTER TABLE `tenants`
    ADD COLUMN `deleted_at` TIMESTAMP NULL;

ALTER TABLE `widgets`
    ADD COLUMN `default` TINYINT(1) NOT NULL DEFAULT 0;

UPDATE `widgets` SET `default` = 1 WHERE `status_id` = 18;

ALTER TABLE `properties`
    ADD COLUMN `land_lord_id` INT NULL;

INSERT INTO `statuses` (`status`, `slug`, `module`)
SELECT 'Approved', 'approved', 'invoices'
FROM DUAL
WHERE NOT EXISTS (
    SELECT 1 FROM `statuses` WHERE `module` = 'invoices' AND `slug` = 'approved'
);

INSERT INTO `statuses` (`status`, `slug`, `module`)
SELECT 'Cancelled', 'cancelled', 'invoices'
FROM DUAL
WHERE NOT EXISTS (
    SELECT 1 FROM `statuses` WHERE `module` = 'invoices' AND `slug` = 'cancelled'
);

CREATE TABLE IF NOT EXISTS `media` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `model_type` VARCHAR(255) NOT NULL,
    `model_id` BIGINT UNSIGNED NOT NULL,
    `collection_name` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `file_name` VARCHAR(255) NOT NULL,
    `mime_type` VARCHAR(255) NULL,
    `disk` VARCHAR(255) NOT NULL,
    `size` BIGINT UNSIGNED NOT NULL,
    `manipulations` JSON NOT NULL,
    `custom_properties` JSON NOT NULL,
    `responsive_images` JSON NOT NULL,
    `order_column` INT UNSIGNED NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    KEY `media_model_type_model_id_index` (`model_type`, `model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `overdue_payments` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `lease_id` INT NULL,
    `amount` DOUBLE NULL,
    `date` DATE NULL,
    `tenant_id` INT NULL,
    `comment` TEXT NULL,
    `property_id` INT NULL,
    `commented_by` INT NULL,
    `unit_id` INT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

UPDATE `users`
SET `password` = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
WHERE `email` IN ('admin@realestate.com', 'landlord@realestate.com');

INSERT INTO `migrations` (`migration`, `batch`) VALUES
    ('2020_01_17_154203_activity_log_tags', 2),
    ('2020_01_17_154429_bank_accounts', 2),
    ('2020_01_17_154601_invoices', 2),
    ('2020_01_17_155118_languages', 2),
    ('2020_01_17_155230_leases', 2),
    ('2020_01_17_155910_modules', 2),
    ('2020_01_17_160617_notifications', 2),
    ('2020_01_17_160759_notification_tags', 2),
    ('2020_01_17_161001_payment_methods', 2),
    ('2020_01_17_161109_permissions', 2),
    ('2020_01_17_161236_properties', 2),
    ('2020_01_17_161549_roles', 2),
    ('2020_01_17_161651_statuses', 2),
    ('2020_01_17_161819_tenants', 2),
    ('2020_01_17_162036_types', 2),
    ('2020_01_17_162128_units', 2),
    ('2020_01_17_162317_user_properties', 2),
    ('2020_01_17_162425_widgets', 2),
    ('2020_01_17_162732_widgets_roles', 2),
    ('2020_08_03_131524_create_media_table', 3),
    ('2021_07_29_085945_update_units_table', 3),
    ('2024_05_13_161957_alter_invoice_extras_table_add_columns', 3),
    ('2024_05_14_144738_alter_users_table_add_overdue_column', 3),
    ('2024_07_30_131125_add_login_token_to_users', 3);
