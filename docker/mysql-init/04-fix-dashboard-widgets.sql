-- Dashboard collection cards originally required invoice status "paid".
-- Landlord invoices start as "approved", so the cards stayed at 0.
-- Also add date placeholders so the dashboard date picker actually filters.

UPDATE `widgets`
SET `query` = 'SELECT IFNULL(SUM(invoices.total_amount), 0) AS value FROM invoices WHERE invoices.type_id = 5 AND invoices.end_date BETWEEN [START_DATE] AND [END_DATE] AND EXISTS (SELECT 1 FROM statuses WHERE invoices.invoice_status_id = statuses.id AND statuses.module = ''invoices'' AND statuses.slug IN (''approved'', ''paid'')) AND EXISTS (SELECT 1 FROM properties WHERE invoices.property_id = properties.id AND EXISTS (SELECT 1 FROM property_assigned_mappings WHERE properties.id = property_assigned_mappings.property_id AND user_id = [USER_ID] AND IF([PROPERTY] IS NULL, properties.id > 0, properties.id = [PROPERTY])))'
WHERE `id` = 21;

UPDATE `widgets`
SET `query` = 'SELECT IFNULL(SUM(invoices.total_amount), 0) AS value FROM invoices WHERE invoices.type_id = 5 AND invoices.end_date BETWEEN [START_DATE] AND [END_DATE] AND EXISTS (SELECT 1 FROM statuses WHERE invoices.invoice_status_id = statuses.id AND statuses.module = ''invoices'' AND statuses.slug IN (''approved'', ''paid'')) AND EXISTS (SELECT 1 FROM payment_methods WHERE invoices.payment_method_id = payment_methods.id AND payment_methods.slug = ''online'' AND payment_methods.module = ''invoices'') AND EXISTS (SELECT 1 FROM properties WHERE invoices.property_id = properties.id AND EXISTS (SELECT 1 FROM property_assigned_mappings WHERE properties.id = property_assigned_mappings.property_id AND user_id = [USER_ID] AND IF([PROPERTY] IS NULL, properties.id > 0, properties.id = [PROPERTY])))'
WHERE `id` = 22;

UPDATE `widgets`
SET `query` = 'SELECT IFNULL(SUM(invoices.total_amount), 0) AS value FROM invoices WHERE invoices.type_id = 5 AND invoices.end_date BETWEEN [START_DATE] AND [END_DATE] AND EXISTS (SELECT 1 FROM statuses WHERE invoices.invoice_status_id = statuses.id AND statuses.module = ''invoices'' AND statuses.slug IN (''approved'', ''paid'')) AND EXISTS (SELECT 1 FROM payment_methods WHERE invoices.payment_method_id = payment_methods.id AND payment_methods.slug = ''offline'' AND payment_methods.module = ''invoices'') AND EXISTS (SELECT 1 FROM properties WHERE invoices.property_id = properties.id AND EXISTS (SELECT 1 FROM property_assigned_mappings WHERE properties.id = property_assigned_mappings.property_id AND user_id = [USER_ID] AND IF([PROPERTY] IS NULL, properties.id > 0, properties.id = [PROPERTY])))'
WHERE `id` = 23;

UPDATE `widgets`
SET `query` = 'SELECT IFNULL(SUM(invoices.total_amount), 0) AS value FROM invoices WHERE invoices.type_id = 5 AND invoices.end_date BETWEEN [START_DATE] AND [END_DATE] AND EXISTS (SELECT 1 FROM statuses WHERE invoices.invoice_status_id = statuses.id AND statuses.module = ''invoices'' AND statuses.slug IN (''approved'', ''paid'')) AND EXISTS (SELECT 1 FROM payment_methods WHERE invoices.payment_method_id = payment_methods.id AND payment_methods.slug = ''kiosk'' AND payment_methods.module = ''invoices'') AND EXISTS (SELECT 1 FROM properties WHERE invoices.property_id = properties.id AND EXISTS (SELECT 1 FROM property_assigned_mappings WHERE properties.id = property_assigned_mappings.property_id AND user_id = [USER_ID] AND IF([PROPERTY] IS NULL, properties.id > 0, properties.id = [PROPERTY])))'
WHERE `id` = 28;

UPDATE `widgets`
SET `query` = 'SELECT IFNULL((SELECT SUM(i.total_amount) FROM invoices i INNER JOIN properties p ON i.property_id = p.id INNER JOIN property_assigned_mappings m ON p.id = m.property_id AND m.user_id = [USER_ID] INNER JOIN statuses s ON i.invoice_status_id = s.id AND s.module = ''invoices'' AND s.slug IN (''approved'', ''paid'') WHERE i.type_id = 5 AND i.end_date BETWEEN [START_DATE] AND [END_DATE] AND IF([PROPERTY] IS NULL, p.id > 0, p.id = [PROPERTY])), 0) - IFNULL((SELECT SUM(i.total_amount) FROM invoices i INNER JOIN properties p ON i.property_id = p.id INNER JOIN property_assigned_mappings m ON p.id = m.property_id AND m.user_id = [USER_ID] INNER JOIN statuses s ON i.invoice_status_id = s.id AND s.module = ''invoices'' AND s.slug IN (''approved'', ''paid'') WHERE i.type_id = 6 AND i.end_date BETWEEN [START_DATE] AND [END_DATE] AND IF([PROPERTY] IS NULL, p.id > 0, p.id = [PROPERTY])), 0) AS value'
WHERE `id` = 31;

-- Expense invoices have no extras. A Cubix leftover extra (2000 on invoice_id 6)
-- was attaching itself to new expense #6 and showing 2,000 on View.
DELETE ie
FROM `invoice_extras` ie
INNER JOIN `invoices` i ON i.id = ie.invoice_id
WHERE i.type_id = 6;
