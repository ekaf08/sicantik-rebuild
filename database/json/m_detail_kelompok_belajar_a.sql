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

 Date: 25/11/2026 08:37:49
*/


-- ----------------------------
-- Table structure for m_detail_kelompok_belajar_a
-- ----------------------------
DROP TABLE IF EXISTS "public"."m_detail_kelompok_belajar_a";
CREATE TABLE "public"."m_detail_kelompok_belajar_a" (
  "id_kelompok" int8,
  "lembaga" varchar(255) COLLATE "pg_catalog"."default",
  "id_kel" int4,
  "kel" varchar(255) COLLATE "pg_catalog"."default",
  "id_kec" int4,
  "alamat" varchar(255) COLLATE "pg_catalog"."default",
  "rt_rw" varchar(255) COLLATE "pg_catalog"."default",
  "nama_petugas" varchar(255) COLLATE "pg_catalog"."default",
  "nik_petugas" varchar(255) COLLATE "pg_catalog"."default"
)
;
