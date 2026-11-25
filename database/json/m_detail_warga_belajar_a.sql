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

 Date: 25/11/2026 08:36:39
*/


-- ----------------------------
-- Table structure for m_detail_warga_belajar_a
-- ----------------------------
DROP TABLE IF EXISTS "public"."m_detail_warga_belajar_a";
CREATE TABLE "public"."m_detail_warga_belajar_a" (
  "id_kel" int4,
  "kel" varchar(255) COLLATE "pg_catalog"."default",
  "id_kec" int4,
  "lembaga" varchar(255) COLLATE "pg_catalog"."default",
  "id_kelompok" int4,
  "nama" varchar(255) COLLATE "pg_catalog"."default",
  "tgl_lahir" varchar(255) COLLATE "pg_catalog"."default",
  "jenis_kelamin" varchar(255) COLLATE "pg_catalog"."default",
  "nik" varchar(255) COLLATE "pg_catalog"."default",
  "no_kk" varchar(255) COLLATE "pg_catalog"."default",
  "alamat" varchar(255) COLLATE "pg_catalog"."default",
  "rt" varchar(255) COLLATE "pg_catalog"."default",
  "rw" varchar(255) COLLATE "pg_catalog"."default"
)
;
