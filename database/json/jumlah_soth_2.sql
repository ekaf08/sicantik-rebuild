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

 Date: 26/11/2026 10:13:53
*/


-- ----------------------------
-- Table structure for jumlah_soth_2
-- ----------------------------
DROP TABLE IF EXISTS "public"."jumlah_soth_2";
CREATE TABLE "public"."jumlah_soth_2" (
  "nama_soth" varchar(255) COLLATE "pg_catalog"."default",
  "alamat_soth" varchar(255) COLLATE "pg_catalog"."default",
  "rt_soth" int4,
  "rw_soth" int4,
  "id_kel" int4,
  "nama_kel" varchar(255) COLLATE "pg_catalog"."default",
  "id_kec" int4,
  "nama_kec" varchar(255) COLLATE "pg_catalog"."default"
)
;
