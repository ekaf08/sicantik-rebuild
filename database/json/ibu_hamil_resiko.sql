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

 Date: 23/11/2026 10:52:36
*/


-- ----------------------------
-- Table structure for ibu_hamil_resiko
-- ----------------------------
DROP TABLE IF EXISTS "public"."ibu_hamil_resiko";
CREATE TABLE "public"."ibu_hamil_resiko" (
  "nokk" varchar(50) COLLATE "pg_catalog"."default",
  "nik" varchar(50) COLLATE "pg_catalog"."default",
  "namalengkap" varchar(200) COLLATE "pg_catalog"."default",
  "tgl_lahir" date,
  "alamatktp" varchar(255) COLLATE "pg_catalog"."default",
  "rtktp" varchar(10) COLLATE "pg_catalog"."default",
  "rwktp" varchar(10) COLLATE "pg_catalog"."default",
  "kelurahanktp" varchar(255) COLLATE "pg_catalog"."default",
  "kecamatanktp" varchar(255) COLLATE "pg_catalog"."default",
  "alamat" varchar(255) COLLATE "pg_catalog"."default",
  "rt" varchar(32) COLLATE "pg_catalog"."default",
  "rw" varchar(32) COLLATE "pg_catalog"."default",
  "kelurahan" varchar(255) COLLATE "pg_catalog"."default",
  "kecamatan" varchar(255) COLLATE "pg_catalog"."default",
  "resiko" text COLLATE "pg_catalog"."default",
  "tanggalperkiraan" date,
  "riwayat_kehamilan" json,
  "riwayat_catin" json
)
;
