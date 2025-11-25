-- ================================================================
-- SQL SCRIPT TO FIX DATABASE SCHEMA FOR ukk_bengkel
-- Execute this in phpMyAdmin or HeidiSQL if Laragon Terminal has issues
-- ================================================================

USE db_bengkel;

-- STEP 1: Run pending migrations (add layanan_id column if not exists)
-- Check if layanan_id column exists first
SET @column_check = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'db_bengkel' 
    AND TABLE_NAME = 'booking' 
    AND COLUMN_NAME = 'layanan_id'
);

-- Add layanan_id if it doesn't exist
SET @sql = IF(@column_check = 0, 
    'ALTER TABLE booking ADD COLUMN layanan_id BIGINT UNSIGNED NULL AFTER kendaraan_id',
    'SELECT "layanan_id column already exists" AS status'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Add foreign key for layanan_id if not exists
SET @fk_check = (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
    WHERE TABLE_SCHEMA = 'db_bengkel'
    AND TABLE_NAME = 'booking'
    AND COLUMN_NAME = 'layanan_id'
    AND CONSTRAINT_NAME LIKE '%foreign%'
);

SET @sql = IF(@fk_check = 0,
    'ALTER TABLE booking ADD CONSTRAINT booking_layanan_id_foreign 
     FOREIGN KEY (layanan_id) REFERENCES layanans(id) ON DELETE SET NULL',
    'SELECT "layanan_id foreign key already exists" AS status'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- STEP 2: Add foreign key constraint for kendaraan_id if not exists
SET @kendaraan_fk_check = (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
    WHERE TABLE_SCHEMA = 'db_bengkel'
    AND TABLE_NAME = 'booking'
    AND COLUMN_NAME = 'kendaraan_id'
    AND CONSTRAINT_NAME LIKE '%foreign%'
);

SET @sql = IF(@kendaraan_fk_check = 0,
    'ALTER TABLE booking ADD CONSTRAINT booking_kendaraan_id_foreign 
     FOREIGN KEY (kendaraan_id) REFERENCES kendaraan(id) ON DELETE CASCADE',
    'SELECT "kendaraan_id foreign key already exists" AS status'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- STEP 3: Remove unused columns (jenis_layanan and jenis_servis)
-- Check and drop jenis_layanan if exists
SET @jenis_layanan_check = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'db_bengkel' 
    AND TABLE_NAME = 'booking' 
    AND COLUMN_NAME = 'jenis_layanan'
);

SET @sql = IF(@jenis_layanan_check > 0,
    'ALTER TABLE booking DROP COLUMN jenis_layanan',
    'SELECT "jenis_layanan column does not exist" AS status'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Check and drop jenis_servis if exists
SET @jenis_servis_check = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'db_bengkel' 
    AND TABLE_NAME = 'booking' 
    AND COLUMN_NAME = 'jenis_servis'
);

SET @sql = IF(@jenis_servis_check > 0,
    'ALTER TABLE booking DROP COLUMN jenis_servis',
    'SELECT "jenis_servis column does not exist" AS status'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- STEP 4: Verify the changes
SELECT 'Database schema updated successfully!' AS Result;

-- Show final booking table structure
DESCRIBE booking;

-- Show foreign keys on booking table
SELECT 
    CONSTRAINT_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = 'db_bengkel'
AND TABLE_NAME = 'booking'
AND REFERENCED_TABLE_NAME IS NOT NULL;
