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

 Date: 23/11/2026 11:11:32
*/


-- ----------------------------
-- Table structure for kisak_pokja1
-- ----------------------------
DROP TABLE IF EXISTS "public"."kisak_pokja1";
CREATE TABLE "public"."kisak_pokja1" (
  "id" int8 NOT NULL DEFAULT nextval('kisak_pokja1_id_seq'::regclass),
  "tgl_kegiatan" date,
  "tempat" varchar(255) COLLATE "pg_catalog"."default",
  "materi" text COLLATE "pg_catalog"."default",
  "id_kec" int8,
  "id_kel" int8,
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
  "deleted_at" timestamp(0),
  "pertanyaan_id" int4,
  "nama_kec" varchar(255) COLLATE "pg_catalog"."default",
  "nama_kel" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Primary Key structure for table kisak_pokja1
-- ----------------------------
ALTER TABLE "public"."kisak_pokja1" ADD CONSTRAINT "kisak_pokja1_pkey" PRIMARY KEY ("id");
