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

 Date: 09/11/2026 15:13:09
*/


-- ----------------------------
-- Table structure for peserta_lotus
-- ----------------------------
DROP TABLE IF EXISTS "public"."peserta_lotus";
CREATE TABLE "public"."peserta_lotus" (
  "id" int8 NOT NULL DEFAULT nextval('peserta_lotus_id_seq'::regclass),
  "pertanyaan_id" int8 NOT NULL,
  "nik" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "nama" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "nik_ibu" varchar(255) COLLATE "pg_catalog"."default",
  "nama_ibu" varchar(255) COLLATE "pg_catalog"."default",
  "alamat" text COLLATE "pg_catalog"."default",
  "id_kec" int4,
  "id_kel" int4,
  "nama_kec" varchar(255) COLLATE "pg_catalog"."default",
  "nama_kel" varchar(255) COLLATE "pg_catalog"."default",
  "rw" varchar(255) COLLATE "pg_catalog"."default",
  "rt" varchar(255) COLLATE "pg_catalog"."default",
  "flag_kolom" varchar(255) COLLATE "pg_catalog"."default",
  "deleted_at" timestamp(0),
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
  "nik_pendamping" varchar(255) COLLATE "pg_catalog"."default",
  "nama_pendamping" varchar(255) COLLATE "pg_catalog"."default",
  "pendamping" varchar(255) COLLATE "pg_catalog"."default",
  "hubungan_keluarga" varchar(255) COLLATE "pg_catalog"."default",
  "no_kk" varchar(255) COLLATE "pg_catalog"."default",
  "tahun" varchar(255) COLLATE "pg_catalog"."default",
  "tahap" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Primary Key structure for table peserta_lotus
-- ----------------------------
ALTER TABLE "public"."peserta_lotus" ADD CONSTRAINT "peserta_lotus_pkey" PRIMARY KEY ("id");
