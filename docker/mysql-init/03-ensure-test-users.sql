-- Known local logins. Safe to run on every boot.

UPDATE `users`
SET `password` = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    `user_status_id` = 9
WHERE `email` IN ('admin@realestate.com', 'landlord@realestate.com', 'mohammad.almarzouq@outlook.com');

INSERT INTO `users` (`name`, `email`, `password`, `role_id`, `user_status_id`, `notification_enable`, `created_at`, `updated_at`)
SELECT 'mohammad', 'mohammad.almarzouq@outlook.com',
       '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
       2, 9, 1, NOW(), NOW()
FROM DUAL
WHERE NOT EXISTS (
    SELECT 1 FROM `users` WHERE `email` = 'mohammad.almarzouq@outlook.com'
);

INSERT INTO `widget_users` (`widget_id`, `user_id`)
SELECT wu.widget_id, u.id
FROM `widget_users` wu
JOIN `users` src ON src.id = wu.user_id AND src.email = 'landlord@realestate.com'
JOIN `users` u ON u.email = 'mohammad.almarzouq@outlook.com'
WHERE NOT EXISTS (
    SELECT 1 FROM `widget_users` x
    WHERE x.user_id = u.id AND x.widget_id = wu.widget_id
);
