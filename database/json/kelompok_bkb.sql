/*
 Navicat Premium Data Transfer

 Source Server         : sim-pkk
 Source Server Type    : PostgreSQL
 Source Server Version : 150004 (150004)
 Source Host           : 172.18.254.75:5432
 Source Catalog        : sim_pkk
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 150004 (150004)
 File Encoding         : 65001

 Date: 26/11/2026 08:42:54
*/


-- ----------------------------
-- Table structure for kelompok_bkb
-- ----------------------------
DROP TABLE IF EXISTS "public"."kelompok_bkb";
CREATE TABLE "public"."kelompok_bkb" (
  "id" int8,
  "kecamatan_id" int8,
  "id_kec" int4,
  "id_kel" int4,
  "kelurahan_id" int8,
  "nomor_register" int8,
  "nama_kelompok" varchar(255) COLLATE "pg_catalog"."default",
  "alamat_jalan" varchar(255) COLLATE "pg_catalog"."default",
  "nama_pembina_pkbid" varchar(255) COLLATE "pg_catalog"."default",
  "nomor_sk" varchar(255) COLLATE "pg_catalog"."default",
  "mengetahui_pembina_nama" varchar(255) COLLATE "pg_catalog"."default",
  "mengetahui_ketua_nama" varchar(255) COLLATE "pg_catalog"."default",
  "label" numeric(255,0),
  "nama_kel" varchar(255) COLLATE "pg_catalog"."default",
  "nama_kec" varchar(255) COLLATE "pg_catalog"."default"
)
;
COMMENT ON COLUMN "public"."kelompok_bkb"."id_kec" IS 'id_kec_pkk';
COMMENT ON COLUMN "public"."kelompok_bkb"."id_kel" IS 'id_kel_pkk';
COMMENT ON COLUMN "public"."kelompok_bkb"."nama_kelompok" IS '*Kolom 14';
COMMENT ON COLUMN "public"."kelompok_bkb"."label" IS '*Kolom 16';
