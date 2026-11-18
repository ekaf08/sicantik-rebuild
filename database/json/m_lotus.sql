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

 Date: 18/11/2026 09:36:32
*/


-- ----------------------------
-- Table structure for m_lotus
-- ----------------------------
DROP TABLE IF EXISTS "public"."m_lotus";
CREATE TABLE "public"."m_lotus" (
  "id" int8 NOT NULL DEFAULT nextval('m_lotus_id_seq'::regclass),
  "pertanyaan_id" int8 NOT NULL,
  "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "nama_kec" varchar(255) COLLATE "pg_catalog"."default",
  "nama_kel" varchar(255) COLLATE "pg_catalog"."default",
  "tahap" varchar(255) COLLATE "pg_catalog"."default",
  "id_kec" int8,
  "id_kel" int8,
  "rw" int8,
  "rt" int8,
  "deleted_at" timestamp(0),
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
  "alamat" text COLLATE "pg_catalog"."default",
  "flag_kolom" varchar(255) COLLATE "pg_catalog"."default",
  "tahun" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of m_lotus
-- ----------------------------
INSERT INTO "public"."m_lotus" VALUES (7, 146, 'SAD123', 'KREMBANGAN', 'DUPAK', '2', 15, NULL, 1, 1, '2026-09-09 09:51:54', '2026-09-08 15:29:32', '2026-09-09 09:51:54', 'sad', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (1, 146, 'Kemuncrut', 'KREMBANGAN', 'DUPAK', '1', 15, NULL, 1, 1, '2026-09-09 09:51:57', '2026-09-08 13:51:54', '2026-09-09 09:51:57', 'TES 123', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (10, 145, 'sad', 'KREMBANGAN', 'KEMAYORAN', '1', 15, NULL, 1, 1, '2026-09-09 09:52:05', '2026-09-08 15:52:38', '2026-09-09 09:52:05', 'sd', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (8, 145, 'kEMAYORAN', 'KREMBANGAN', 'KEMAYORAN', '1', 15, NULL, 1, 2, '2026-09-09 09:52:08', '2026-09-08 15:47:18', '2026-09-09 09:52:08', 'DSKJFHKJDSFH', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (3, 145, 'Kemayoran 123', 'KREMBANGAN', 'KEMAYORAN', '1', 15, NULL, 1, 1, '2026-09-09 09:52:10', '2026-09-08 14:44:50', '2026-09-09 09:52:10', 'Kemancrut', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (9, 143, 'Perak Berjaye', 'KREMBANGAN', 'PERAK BARAT', '1', 15, NULL, 1, 1, '2026-09-09 09:52:17', '2026-09-08 15:49:09', '2026-09-09 09:52:17', 'u', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (5, 144, 'Kremsel', 'KREMBANGAN', 'KREMBANGAN SELATAN', '1', 15, NULL, 1, 1, '2026-09-09 09:52:40', '2026-09-08 14:47:05', '2026-09-09 09:52:40', 'Hahah', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (12, 146, 'OD', 'KREMBANGAN', 'DUPAK', '1', 15, 84, 12, 12, '2026-09-09 14:44:22', '2026-09-09 14:40:37', '2026-09-09 14:44:22', 'od', 'krisan_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (28, 104, 'SOTH Kusumajaya 6', 'GUBENG', 'KERTAJAYA', '1', 8, 42, 6, 3, '2026-09-29 04:12:08', '2026-09-26 09:19:55', '2026-09-29 04:12:08', 'Pucang Anom timur no 17 a', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (13, 166, 'ADADGDRT546', 'WIYUNG', 'BABATAN', '1', 20, 104, 1, 1, '2026-09-10 14:49:47', '2026-09-10 14:49:33', '2026-09-10 14:49:47', 'ad', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (14, 137, 'NUSA INDAH', 'TANDES', 'MANUKAN KULON', '1', 14, 75, 2, 5, NULL, '2026-09-11 10:54:57', '2026-09-11 10:54:57', 'MANUKAN MULYO', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (15, 189, 'GUNATAMA', 'GUNUNG ANYAR', 'GUNUNG ANYAR TAMBAK', '1', 25, 127, 1, 1, NULL, '2026-09-18 11:18:33', '2026-09-18 11:18:33', 'Jalan Gunung Anyar Jaya, kec Gunung Anyar Surabaya', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (16, 196, 'Kemangi Gen Velocity', 'SUKOMANUNGGAL', 'SIMOMULYO', '1', 27, 134, 4, 6, NULL, '2026-09-24 20:59:13', '2026-09-24 20:59:13', 'Gumuk Bogo no 3', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (17, 196, 'Kemangi Gen Velocity', 'SUKOMANUNGGAL', 'SIMOMULYO', '1', 27, 134, 4, 6, NULL, '2026-09-24 21:02:25', '2026-09-24 21:02:25', 'Gumuk Bogo no 3', 'krisan_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (18, 196, 'Kemangi Gen Velocity', 'SUKOMANUNGGAL', 'SIMOMULYO', '1', 27, 134, 4, 6, NULL, '2026-09-24 21:03:10', '2026-09-24 21:03:10', 'Gumuk Bogo no 3', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (19, 196, 'Kemangi Gen Velocity', 'SUKOMANUNGGAL', 'SIMOMULYO', '1', 27, 134, 4, 6, NULL, '2026-09-24 21:03:48', '2026-09-24 21:03:48', 'Gumuk Bogo no 3', 'kiat_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (20, 196, 'Kemangi Gen Velocity', 'SUKOMANUNGGAL', 'SIMOMULYO', '1', 27, 134, 4, 6, NULL, '2026-09-24 21:04:29', '2026-09-24 21:04:29', 'Gumuk Bogo no 3', 'pkbn_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (21, 127, 'KEMANGI TERATAI 1', 'PABEAN CANTIAN', 'NYAMPLUNGAN', '1', 12, 65, 4, 4, NULL, '2026-09-25 09:32:22', '2026-09-25 09:32:22', 'JL. KALIMAS MADYA 4', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (22, 127, 'KEMANGI MAWAR', 'PABEAN CANTIAN', 'NYAMPLUNGAN', '2', 12, 65, 1, 2, NULL, '2026-09-25 09:32:59', '2026-09-25 09:32:59', 'BENTENG', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (24, 171, 'Lya Indra Puspita', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 2, 3, '2026-09-25 19:55:44', '2026-09-25 19:51:57', '2026-09-25 19:55:44', 'Dukuh Kali Kendal', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (25, 171, 'Hermin', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 1, 2, NULL, '2026-09-25 19:57:25', '2026-09-25 19:57:25', 'Putat Gede Barat 2/46', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (29, 104, 'SOTH KUSUMAJAYA 10', 'GUBENG', 'KERTAJAYA', '1', 8, 42, 10, 5, '2026-09-29 04:12:12', '2026-09-26 09:21:05', '2026-09-29 04:12:12', 'Jl. Juwingan no 63', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (30, 104, 'Soth kusumajaya 11', 'GUBENG', 'KERTAJAYA', '2', 8, 42, 11, 6, '2026-09-29 04:12:15', '2026-09-26 09:22:15', '2026-09-29 04:12:15', 'Jl Gubeng kertajaya 4b no 13', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (31, 104, 'Soth kusumajaya 10', 'GUBENG', 'KERTAJAYA', '2', 8, 42, 10, 5, '2026-09-29 04:12:18', '2026-09-26 09:22:42', '2026-09-29 04:12:18', 'Jl juwingan no 63', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (26, 171, 'Irawati', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 4, 1, NULL, '2026-09-25 19:58:28', '2026-09-25 19:58:28', 'Pradah Kalikendal', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (27, 171, 'Irma Nurfitasri', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 1, 2, NULL, '2026-09-25 19:59:47', '2026-09-25 19:59:47', 'Pradah Kalikendal', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (41, 104, 'ERICA PRAPTIWI', 'GUBENG', 'KERTAJAYA', '1', 8, 42, 8, 2, NULL, '2026-09-29 04:26:30', '2026-09-29 04:26:30', 'PUCANGAN 3 / 43A', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (34, 104, 'INDRI FITRIYANI', 'GUBENG', 'KERTAJAYA', '1', 8, 42, 8, 4, NULL, '2026-09-29 04:20:43', '2026-09-29 04:20:43', 'PUCANGAN 3 / 74', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (35, 104, 'YAYUK', 'GUBENG', 'KERTAJAYA', '1', 8, 42, 8, 2, NULL, '2026-09-29 04:21:40', '2026-09-29 04:21:40', 'PUCANGAN 3 / 43B', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (36, 104, 'JULITA', 'GUBENG', 'KERTAJAYA', '1', 8, 42, 8, 5, NULL, '2026-09-29 04:22:23', '2026-09-29 04:22:23', 'PUCANGAN 3 / 115B', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (37, 104, 'KINANTI PUSPITA DEWI', 'GUBENG', 'KERTAJAYA', '1', 8, 42, 8, 1, NULL, '2026-09-29 04:23:09', '2026-09-29 04:23:09', 'PUCANGAN 3 / 5', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (38, 104, 'SAFITRI KUMALASARI', 'GUBENG', 'KERTAJAYA', '1', 8, 42, 8, 3, NULL, '2026-09-29 04:24:00', '2026-09-29 04:24:00', 'PUCANGAN 3 / 83C', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (39, 104, 'EVA SETIAWATI', 'GUBENG', 'KERTAJAYA', '1', 8, 42, 8, 3, NULL, '2026-09-29 04:24:46', '2026-09-29 04:24:46', 'PUCANGAN 3/83A', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (40, 104, 'PARTINI', 'GUBENG', 'KERTAJAYA', '1', 8, 42, 8, 4, NULL, '2026-09-29 04:25:29', '2026-09-29 04:25:29', 'PUCANGAN 3 / 105C', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (42, 104, 'ASTRYAH', 'GUBENG', 'KERTAJAYA', '1', 8, 42, 8, 3, NULL, '2026-09-29 04:28:19', '2026-09-29 04:28:19', 'PUCANGAN 3/ 77', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (4, 146, 'Dupak Crot', 'KREMBANGAN', 'DUPAK', '1', 15, NULL, 1, 1, '2026-09-09 09:51:38', '2026-09-08 14:45:20', '2026-09-09 09:51:38', 'sfsfdsf', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (6, 146, 'skuy', 'KREMBANGAN', 'DUPAK', '1', 15, NULL, 2, 1, '2026-09-09 09:51:47', '2026-09-08 15:28:18', '2026-09-09 09:51:47', 'sjadk', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (2, 146, 'Ters', 'KREMBANGAN', 'DUPAK', '1', 15, NULL, 1, 8, '2026-09-09 09:51:51', '2026-09-08 14:11:07', '2026-09-09 09:51:51', 'Ok sudah', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (43, 104, 'SUMIATUN', 'GUBENG', 'KERTAJAYA', '1', 8, 42, 8, 0, NULL, '2026-09-29 04:29:06', '2026-09-29 04:29:06', 'PUCANGAN 3 / 12A', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (44, 171, 'Jarwati', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 2, 3, NULL, '2026-09-30 18:40:18', '2026-09-30 18:40:18', 'Dukuh Kawal Kalikendal', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (45, 171, 'Lilik Sutrisni Nengsih', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 1, 2, NULL, '2026-09-30 18:42:06', '2026-09-30 18:42:06', 'Putat Gede Timur IV no.26', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (46, 171, 'Lya Indra Puspita', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 2, 3, NULL, '2026-09-30 18:42:51', '2026-09-30 18:42:51', 'Dukuh Kalikendal', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (47, 171, 'Siti Murtakiyah', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 1, 2, NULL, '2026-09-30 18:43:51', '2026-09-30 18:43:51', 'Pradah Kalikendal', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (48, 171, 'Suci Maria Ulfa', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 2, 3, NULL, '2026-09-30 18:44:35', '2026-09-30 18:44:35', 'Dukuh Kawal Kalikendal', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (23, 215, 'MELATI', 'SAMBI KEREP', 'LONTAR', '1', 31, 153, 1, 2, NULL, '2026-09-25 12:53:28', '2026-11-04 09:13:04', 'JL. RAYA LONTAR NO. 05', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (49, 171, 'Istiwati', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 1, 2, NULL, '2026-09-30 18:45:38', '2026-09-30 18:45:38', 'Pradah Kalikendal', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (50, 171, 'Wiwik', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 2, 1, NULL, '2026-09-30 18:47:10', '2026-09-30 18:47:10', 'Dukuh Kalikendal', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (51, 171, 'Aisyah Nur Afiqah', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 1, 2, NULL, '2026-09-30 18:55:14', '2026-09-30 18:55:14', 'Putat Gede Barat', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (52, 171, 'Bastian Rega Pratama', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 1, 2, NULL, '2026-09-30 18:56:53', '2026-09-30 18:56:53', 'Putat Gede Timur', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (53, 171, 'Besilia Denita Dana Dipa', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 1, 4, NULL, '2026-09-30 18:57:54', '2026-09-30 18:57:54', 'Pradah Kalikendal', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (54, 171, 'Chillya Auliya An- Nisa', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 1, 2, NULL, '2026-09-30 18:58:43', '2026-09-30 18:58:43', 'Pradah Kalikendal', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (55, 171, 'Faliq Nuna Annafi', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 1, 2, NULL, '2026-09-30 18:59:39', '2026-09-30 18:59:39', 'Pradah Kalikendal', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (56, 171, 'M. Deco Alfiansyah', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 2, 3, NULL, '2026-09-30 19:00:25', '2026-09-30 19:00:25', 'Dukuh Kalikendal', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (57, 171, 'M. Fadil Ardiansyah R', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 1, 2, NULL, '2026-09-30 19:01:12', '2026-09-30 19:01:12', 'Pradah Kalikendal', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (58, 171, 'Olyvia Dwi Anjari Vitope', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 2, 3, NULL, '2026-09-30 19:02:00', '2026-09-30 19:02:00', 'Dukuh Kalikendal', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (59, 171, 'Selvina Ardina Rasti', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 2, 3, NULL, '2026-09-30 19:02:42', '2026-09-30 19:02:42', 'Dukuh Kawal Kalikendal', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (60, 171, 'Zakira Asfadayani', 'DUKUH PAKIS', 'PRADAH KALIKENDAL', '1', 21, 109, 2, 1, NULL, '2026-09-30 19:04:49', '2026-09-30 19:04:49', 'Dukuh Kalikendal', 'kilas_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (61, 217, 'WIJAYA KUSUMA TAHAP', 'PABEAN CANTIAN', 'TANJUNG PERAK', '2', 12, 155, 9, 1, NULL, '2026-10-01 09:04:01', '2026-10-01 09:04:01', 'Kalimas Baru 2 GG lebar 70', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (62, 217, 'MELATI', 'PABEAN CANTIAN', 'TANJUNG PERAK', '1', 12, 155, 8, 7, NULL, '2026-10-01 09:09:03', '2026-10-01 09:09:03', 'Teluk Aru Utara 48', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (72, 134, 'halo', 'BUBUTAN', 'GUNDIH', '2', 13, 72, 2, NULL, '2026-10-30 10:01:08', '2026-10-30 10:00:54', '2026-10-30 10:01:08', 'halo', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (65, 107, 'CERIA', 'SUKOLILO', 'KLAMPIS NGASEM', '1', 9, 45, 3, 2, NULL, '2026-10-15 13:32:44', '2026-10-15 13:32:44', 'Jl Klampis', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (66, 145, 'KEMANGI MELATI PUTIH', 'KREMBANGAN', 'KEMAYORAN', '2', 15, 83, 1, 1, NULL, '2026-10-17 18:40:16', '2026-10-17 18:40:27', 'Jl. Krembangan Baru 6/19', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (73, 28, 'test', 'ASEMROWO', NULL, NULL, 28, NULL, 1, NULL, '2026-10-30 10:02:26', '2026-10-30 10:02:20', '2026-10-30 10:02:26', 'test', 'kisah_volume', '2025');
INSERT INTO "public"."m_lotus" VALUES (75, 183, 'test', 'TENGGILIS MEJOYO', 'KUTISARI', '1', 24, 121, 1, NULL, '2026-10-30 16:38:59', '2026-10-30 16:38:49', '2026-10-30 16:38:59', 'test', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (76, 183, 'ttest', 'TENGGILIS MEJOYO', 'KUTISARI', '1', 24, 121, 1, NULL, '2026-10-30 17:12:49', '2026-10-30 16:44:55', '2026-10-30 17:12:49', 'test1', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (67, 118, 'NURUL HIDAYAH', 'TAMBAKSARI', 'TAMBAKSARI', '1', 10, 56, 11, 111, '2026-10-19 09:09:23', '2026-10-19 08:32:17', '2026-10-19 09:09:23', 'Jl. Rungkut Asri No. 14', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (68, 28, 'Candra Kurniawan', 'ASEMROWO', NULL, '2', 28, NULL, 1, 1, '2026-10-19 09:55:14', '2026-10-19 09:37:56', '2026-10-19 09:55:14', 'Jl. Bratang Gede No. 13', 'kisah_volume', '2025');
INSERT INTO "public"."m_lotus" VALUES (32, 129, 'KEMANGI BAHAGIA BERSAMA', 'PABEAN CANTIAN', 'KREMBANGAN UTARA', '1', 12, 67, 8, 3, NULL, '2026-09-28 07:56:38', '2026-10-19 11:10:38', 'MUTERAN 3', 'kisah_volume', NULL);
INSERT INTO "public"."m_lotus" VALUES (69, 191, 'GEMAR HEBAT', 'MULYOREJO', 'MANYAR SABRANGAN', '1', 26, 129, 1, 5, NULL, '2026-10-22 14:22:00', '2026-10-22 14:22:00', 'Jl. Manyar Sabrangan No. 23', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (70, 191, 'GEMAR HEBAT2', 'MULYOREJO', 'MANYAR SABRANGAN', '2', 26, 129, 1, 5, NULL, '2026-10-22 14:22:46', '2026-10-22 14:22:46', 'Jl. Manyar Sabrangan No. 23', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (33, 129, 'KEMANGI DAHLIA JINGGA', 'PABEAN CANTIAN', 'KREMBANGAN UTARA', '2', 12, 67, 6, 3, NULL, '2026-09-28 07:57:13', '2026-10-24 19:11:06', 'KEBALEN KULON 3/48', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (63, 194, 'GANDARI 3', 'MULYOREJO', 'KALIJUDAN', '2', 26, 132, 3, 1, NULL, '2026-10-15 08:10:30', '2026-10-29 11:55:11', 'KALIJUDAN NO. 154', 'pkbn_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (64, 194, 'GANDARI 4', 'MULYOREJO', 'KALIJUDAN', '1', 26, 132, 4, 3, NULL, '2026-10-15 08:10:54', '2026-10-29 11:55:24', 'KALIJUDAN 10 / 55', 'pkbn_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (71, 134, 'TEST1', 'BUBUTAN', 'GUNDIH', '1', 13, 72, 1, NULL, '2026-10-30 10:01:05', '2026-10-30 09:28:18', '2026-10-30 10:01:05', 'test', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (77, 183, 'test', 'TENGGILIS MEJOYO', 'KUTISARI', '1', 24, 121, 1, NULL, '2026-10-30 17:13:21', '2026-10-30 17:12:56', '2026-10-30 17:13:21', 'test', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (78, 183, 'test', 'TENGGILIS MEJOYO', 'KUTISARI', '1', 24, 121, 1, NULL, '2026-10-30 17:16:08', '2026-10-30 17:13:28', '2026-10-30 17:16:08', 'test', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (74, 107, 'BAHAGIA (CONTOH)', 'SUKOLILO', 'KLAMPIS NGASEM', '1', 9, 45, 1, NULL, '2026-10-31 10:49:35', '2026-10-30 16:27:33', '2026-10-31 10:49:35', 'JL BLA BLA', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (79, 107, 'BAHAGIA (CONTOH)', 'SUKOLILO', 'KLAMPIS NGASEM', '1', 9, 45, 1, NULL, NULL, '2026-10-31 10:50:03', '2026-10-31 10:50:03', 'JL BLA BLA', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (80, 131, 'Teduh Gemilang', 'BUBUTAN', 'TEMBOK DUKUH', '1', 13, 69, 9, NULL, NULL, '2026-11-03 08:40:19', '2026-11-03 08:40:19', 'Kantor Kelurahan Tembok Dukuh
Demak Selatan V/2', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (81, 123, 'MELATI', 'SIMOKERTO', 'SIMOLAWANG', '1', 11, 61, 2, NULL, NULL, '2026-11-03 08:55:22', '2026-11-03 08:55:22', 'Jl. Sidodadi Baru No. 33', 'krisan_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (82, 123, 'ANGGREK', 'SIMOKERTO', 'SIMOLAWANG', '2', 11, 61, 8, NULL, NULL, '2026-11-03 09:05:39', '2026-11-03 09:05:39', 'Jl. Botoputih 2 No. 8', 'krisan_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (83, 84, 'KEMANGI MATAHARI', 'TEGALSARI', 'KEDUNGDORO', '1', 5, 22, 9, NULL, NULL, '2026-11-03 09:17:50', '2026-11-03 09:17:50', 'SMP Muhammadiyah 3 - Plemahan', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (85, 131, 'Teduh Gemilang', 'BUBUTAN', 'TEMBOK DUKUH', '2', 13, 69, 9, NULL, NULL, '2026-11-03 09:18:34', '2026-11-03 09:18:34', 'Kantor Kelurahan Tembok Dukuh
Demak selayan V/2', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (86, 84, 'KEMANGI MATAHARI', 'TEGALSARI', 'KEDUNGDORO', '2', 5, 22, 10, NULL, NULL, '2026-11-03 09:18:48', '2026-11-03 09:18:48', 'PLEMAHAN 6/2-4', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (87, 97, 'Lestari', 'GENTENG', 'GENTENG', '1', 7, 35, 5, NULL, NULL, '2026-11-03 09:18:49', '2026-11-03 09:18:49', 'Balai RW 5 Genteng Kulon', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (88, 132, 'PERMATA HATI BUNDA', 'BUBUTAN', 'ALUN-ALUN CONTONG', '2', 13, 70, 6, NULL, NULL, '2026-11-03 09:18:54', '2026-11-03 09:19:22', 'Kantor Kelurahan Alun-Alun Contong
Jl. Bubutan V / 19 Surabaya', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (89, 95, 'CAKRA', 'GENTENG', 'KAPASARI', '2', 7, 33, 10, NULL, NULL, '2026-11-03 09:19:31', '2026-11-03 09:19:31', 'Kalisari Sayangan 2 No.2', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (90, 97, 'Lestari 2', 'GENTENG', 'GENTENG', '2', 7, 35, 3, NULL, '2026-11-03 09:20:57', '2026-11-03 09:19:37', '2026-11-03 09:20:57', 'Balai RW 3 Kebangsren gang 2', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (92, 88, 'Titian Cita', 'TEGALSARI', 'KEPUTRAN', '1', 5, 26, 4, NULL, NULL, '2026-11-03 09:20:00', '2026-11-03 09:20:00', 'Balai RW 4
Dinoyo Sekolahan 2/19', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (93, 132, 'Bunda AAC', 'BUBUTAN', 'ALUN-ALUN CONTONG', '1', 13, 70, 6, NULL, NULL, '2026-11-03 09:20:05', '2026-11-03 09:20:05', 'Kantor Kelurahan Alun-Alun Contong
Jl. Bubutan V / 19 Surabaya', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (94, 87, 'Gladiol', 'TEGALSARI', 'DR. SOETOMO', '2', 5, 25, 7, NULL, NULL, '2026-11-03 09:20:12', '2026-11-03 09:20:12', 'Jl. Diponegoro 222 Balai RW 07', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (95, 134, 'GUNDIH CERIA', 'BUBUTAN', 'GUNDIH', '1', 13, 72, 1, NULL, NULL, '2026-11-03 09:20:32', '2026-11-03 09:20:32', 'Kantor Kelurahan Gundih
Jl. Gundih V No.12', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (96, 133, 'Bubutan Bersatu', 'BUBUTAN', 'BUBUTAN', '1', 13, 71, 7, NULL, NULL, '2026-11-03 09:21:01', '2026-11-03 09:21:01', 'Balai RW 07 Jl. Tembaan', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (97, 87, 'Kemangi Dahlia', 'TEGALSARI', 'DR. SOETOMO', '1', 5, 25, 4, NULL, NULL, '2026-11-03 09:21:01', '2026-11-03 09:21:01', 'Kupang Panjaan 5 Balai RW 04', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (98, 88, 'Rosela', 'TEGALSARI', 'KEPUTRAN', '2', 5, 26, 5, NULL, NULL, '2026-11-03 09:21:06', '2026-11-03 09:21:06', 'Balai RW 5
Dinoyo Gang 10', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (99, 95, 'GEMPAR', 'GENTENG', 'KAPASARI', '1', 7, 33, 5, NULL, NULL, '2026-11-03 09:21:11', '2026-11-03 09:21:11', 'Kapasari III / 37', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (100, 134, 'ANGGREK 6', 'BUBUTAN', 'GUNDIH', '2', 13, 72, 6, NULL, NULL, '2026-11-03 09:21:22', '2026-11-03 09:21:22', 'Balai RW 6 
Jl. Demak Timur 7', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (101, 133, 'Bubutan Bersatu 2', 'BUBUTAN', 'BUBUTAN', '2', 13, 71, 8, NULL, NULL, '2026-11-03 09:21:30', '2026-11-03 09:21:30', 'Balai RW 08 Jl. Semarang no. 128', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (102, 124, 'Kemangi Flamboyan', 'SIMOKERTO', 'SIDODADI', '1', 11, 62, 1, NULL, NULL, '2026-11-03 09:21:31', '2026-11-03 09:21:31', 'Balai RW 1 Jl. Sidokapasan II No. 30-33', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (104, 124, 'Kemangi Dahlia', 'SIMOKERTO', 'SIDODADI', '2', 11, 62, 2, NULL, NULL, '2026-11-03 09:22:14', '2026-11-03 09:22:14', 'Balai RW 2 Jl. Seng 53-A', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (105, 135, 'Pelita 1 Jepara', 'BUBUTAN', 'JEPARA', '2', 13, 73, 6, NULL, NULL, '2026-11-03 09:22:33', '2026-11-03 09:22:33', 'Balai RW 6', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (107, 97, 'Lestari 2', 'GENTENG', 'GENTENG', '2', 7, 35, 3, NULL, NULL, '2026-11-03 09:23:33', '2026-11-03 09:23:33', 'Balai RW 3 Kebangsren gang 2', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (123, 163, 'Kenanga', 'BENOWO', 'KANDANGAN', '2', 19, 101, 7, NULL, NULL, '2026-11-04 09:22:17', '2026-11-04 09:22:17', 'Jugruk Rejosari', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (108, 85, 'VIBE', 'TEGALSARI', 'TEGALSARI', '1', 5, 23, 4, NULL, NULL, '2026-11-03 09:24:19', '2026-11-03 09:24:19', 'KAMPUNG MALANG TENGAH 1 NO 9', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (109, 96, 'KERABAT 2.0', 'GENTENG', 'KETABANG', '2', 7, 34, 1, NULL, NULL, '2026-11-03 09:25:00', '2026-11-03 09:25:38', 'Jl. Ambengan', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (103, 96, 'KERABAT', 'GENTENG', 'KETABANG', '1', 7, 34, 3, NULL, NULL, '2026-11-03 09:21:44', '2026-11-03 09:25:47', 'Jl Ambengan 36', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (110, 85, 'GARUDA', 'TEGALSARI', 'TEGALSARI', '2', 5, 23, 7, NULL, NULL, '2026-11-03 09:25:55', '2026-11-03 09:25:55', 'BALAI RT 4. JL PANDEGILING GG 4', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (111, 11, 'KARTILAS', 'SIMOKERTO', NULL, NULL, 11, NULL, 13, NULL, NULL, '2026-11-03 09:51:41', '2026-11-03 09:51:41', 'Sidoyoso Wetan 49', 'kisah_volume', '2025');
INSERT INTO "public"."m_lotus" VALUES (124, 164, 'STAR ( Sinergi Tangguh Arek Romokalisari )', 'BENOWO', 'ROMOKALISARI', '1', 19, 102, 2, NULL, NULL, '2026-11-04 09:22:26', '2026-11-04 09:22:26', 'Balai RW 02 Dk Kalisari', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (112, 7, 'MAPAN 13 EMKAL', 'GENTENG', NULL, NULL, 7, NULL, 13, NULL, NULL, '2026-11-03 10:24:11', '2026-11-03 12:03:00', 'Jl. BKR Pelajar No.43 (Kecamatan Genteng)', 'kisah_volume', '2025');
INSERT INTO "public"."m_lotus" VALUES (113, 125, 'SOBAT SANTUY', 'SIMOKERTO', 'TAMBAKREJO', '1', 11, 63, 1, NULL, NULL, '2026-11-03 12:20:28', '2026-11-03 12:20:28', 'Ngaglik 87', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (114, 125, 'Sobat Santuy', 'SIMOKERTO', 'TAMBAKREJO', '1', 11, 63, 1, NULL, '2026-11-03 12:21:25', '2026-11-03 12:20:53', '2026-11-03 12:21:25', 'Ngaglik 87', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (115, 125, 'GARUDA', 'SIMOKERTO', 'TAMBAKREJO', '2', 11, 63, 10, NULL, NULL, '2026-11-03 12:23:44', '2026-11-03 12:23:44', 'Kapasari Pedukuhan Balai RW X', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (116, 125, 'GARUDA', 'SIMOKERTO', 'TAMBAKREJO', '1', 11, 63, 10, NULL, '2026-11-03 12:25:51', '2026-11-03 12:24:39', '2026-11-03 12:25:51', 'Jl.Kapasari Pedukuhan Balai RW X', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (117, 9, 'REMAJA HEBAT', 'SUKOLILO', NULL, NULL, 9, NULL, 1, NULL, NULL, '2026-11-03 13:27:11', '2026-11-03 13:27:11', 'KANTOR KECAMATAN SUKOLILO', 'kisah_volume', '2025');
INSERT INTO "public"."m_lotus" VALUES (84, 98, 'MARKISA', 'GENTENG', 'PENELEH', '1', 7, 36, 15, NULL, NULL, '2026-11-03 09:17:56', '2026-11-03 14:10:22', 'Balai RW 15, Jl Lawang Seketeng Surabaya', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (106, 98, 'STRAWBERRY', 'GENTENG', 'PENELEH', '2', 7, 36, 9, NULL, NULL, '2026-11-03 09:22:43', '2026-11-03 14:10:46', 'Balai RW 10, Jl Klimbungan IV Surabaya', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (118, 211, 'SATRIA BAKTI', 'PAKAL', 'SUMBER REJO', '1', 30, 149, 3, NULL, NULL, '2026-11-04 08:33:18', '2026-11-04 08:34:50', 'BALAI RW.03 SUMBER LANGGENG', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (119, 215, 'MELATI 2', 'SAMBI KEREP', 'LONTAR', '2', 31, 153, 2, NULL, NULL, '2026-11-04 09:12:26', '2026-11-04 09:12:26', 'JL. RAYA LONTAR NO. 05', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (120, 211, 'TAMBAKDONO', 'PAKAL', 'SUMBER REJO', '2', 30, 149, 7, NULL, NULL, '2026-11-04 09:13:02', '2026-11-04 09:13:02', 'BALAI RW.07 TAMBAKDONO', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (121, 162, 'KEMANGI SEMANGGI', 'BENOWO', 'SEMEMI', '1', 19, 100, 2, NULL, NULL, '2026-11-04 09:19:50', '2026-11-04 09:19:50', 'BALAI RW02 UKA KELURAHAN SEMEMI', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (122, 163, 'Pandansari', 'BENOWO', 'KANDANGAN', '1', 19, 101, 1, NULL, NULL, '2026-11-04 09:21:47', '2026-11-04 09:21:47', 'Raya Kandangan', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (125, 216, 'Made berkah', 'SAMBI KEREP', 'MADE', '1', 31, 154, 1, NULL, '2026-11-04 09:24:23', '2026-11-04 09:23:19', '2026-11-04 09:24:23', 'Jl.raya made', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (126, 162, 'KEMANGI SEMEMI BERSEMI', 'BENOWO', 'SEMEMI', '2', 19, 100, 4, NULL, NULL, '2026-11-04 09:25:37', '2026-11-04 09:25:37', 'BALAI RW04 SEMEMI KEL SEMEMI', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (127, 204, 'Ceria', 'ASEMROWO', 'GENTING KALIANAK', '2', 28, 142, 3, NULL, NULL, '2026-11-04 09:25:43', '2026-11-04 09:25:43', 'Genting 1/11', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (128, 209, 'kemangi', 'PAKAL', 'BABAT JERAWAT', '1', 30, 147, 4, NULL, NULL, '2026-11-04 09:26:10', '2026-11-04 09:26:10', 'Dk.Jerawat Balai RW.04', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (129, 213, 'DAHLIA 1', 'SAMBI KEREP', 'BERINGIN', '1', 31, 151, 1, NULL, NULL, '2026-11-04 09:27:41', '2026-11-04 09:29:07', 'Jl Raya Bringin Indah no. 81', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (130, 204, 'Ceria', 'ASEMROWO', 'GENTING KALIANAK', '1', 28, 142, 3, NULL, NULL, '2026-11-04 09:37:11', '2026-11-04 09:37:11', 'Genting GG 1 No 11', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (131, 141, 'Sehati', 'TANDES', 'TANDES', '1', 14, 79, 8, NULL, NULL, '2026-11-04 10:12:26', '2026-11-04 10:12:26', 'Tandes Lor', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (132, 141, 'Sekarsari', 'TANDES', 'TANDES', '2', 14, 79, 1, NULL, NULL, '2026-11-04 10:13:03', '2026-11-04 10:13:03', 'Tandes Kidul GG Makam No. 79', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (133, 140, 'Kemangi Berseri', 'TANDES', 'BALONGSARI', '2', 14, 78, 1, NULL, NULL, '2026-11-04 10:39:47', '2026-11-04 10:39:47', 'Balongsari', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (134, 179, 'CEMARA', 'JAMBANGAN', 'KARAH', '1', 23, 117, 7, NULL, NULL, '2026-11-04 11:54:24', '2026-11-04 11:54:24', 'Jl. Bibis Karah Sawah 1', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (135, 179, 'BERSINAR', 'JAMBANGAN', 'KARAH', '2', 23, 117, 6, NULL, NULL, '2026-11-04 11:55:12', '2026-11-04 11:55:12', 'Jl. Karah No. 65', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (172, 155, 'KEMANGI WENING', 'KENJERAN', 'TANAH KALI KEDINDING', '1', 17, 93, 6, NULL, NULL, '2026-11-12 10:08:01', '2026-11-12 10:08:01', 'POGOT BARU', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (137, 158, 'Lakarsantri Berseri', 'LAKAR SANTRI', 'LAKARSANTRI', '2', 18, 96, 1, NULL, NULL, '2026-11-04 12:54:41', '2026-11-04 12:54:41', 'Lakarsantri Balai RW.001', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (136, 158, 'LAKARSANTRI BERSERI', 'LAKAR SANTRI', 'LAKARSANTRI', '1', 18, 96, 4, NULL, NULL, '2026-11-04 12:52:28', '2026-11-04 12:55:00', 'LAKARSANTRI GG. 4-C', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (138, 210, 'Kemangi Bintang Pakal', 'PAKAL', 'PAKAL', '1', 30, 148, 3, NULL, NULL, '2026-11-04 14:13:54', '2026-11-04 14:13:54', 'Jl. Pakal Amd', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (139, 161, 'Bangkingan Hebat', 'LAKAR SANTRI', 'BANGKINGAN', '1', 18, 99, 3, NULL, NULL, '2026-11-04 14:55:40', '2026-11-04 14:55:40', 'Kantor Kelurahan Bangkingan', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (140, 161, 'BANGKINGAN HEBAT', 'LAKAR SANTRI', 'BANGKINGAN', '2', 18, 99, 0, NULL, NULL, '2026-11-04 14:56:17', '2026-11-04 14:56:17', 'KANTOR KELURAHAN BANGKINGAN', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (141, 130, 'KEMANGI BOHAY', 'PABEAN CANTIAN', 'BONGKARAN', '1', 12, 68, 10, NULL, NULL, '2026-11-05 09:32:50', '2026-11-05 09:32:50', 'Balai RW 10 Jl Pengampon 6/49', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (142, 142, 'AMORA', 'KREMBANGAN', 'MOROKREMBANGAN', '1', 15, 80, 6, NULL, NULL, '2026-11-05 09:33:34', '2026-11-05 09:33:34', 'Jl. Tambak Asri no. 133', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (143, 143, 'PELANGI', 'KREMBANGAN', 'PERAK BARAT', '1', 15, 81, 5, NULL, NULL, '2026-11-05 09:34:30', '2026-11-05 09:34:30', 'JL. IKAN MUJAER NO. 2', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (144, 146, 'TUNAS BUANA', 'KREMBANGAN', 'DUPAK', '1', 15, 84, 4, NULL, NULL, '2026-11-05 09:34:43', '2026-11-05 09:34:43', 'SEKOLAHAN TUNAS BUANA JL. DUPAK BANGUNREJO NO. 32', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (145, 130, 'Kemangi Melati', 'PABEAN CANTIAN', 'BONGKARAN', '2', 12, 68, 8, NULL, NULL, '2026-11-05 09:34:44', '2026-11-05 09:34:44', 'Balai RW 8 Jl Semut 4 /19', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (146, 146, 'KEMANGI CENDEKIA', 'KREMBANGAN', 'DUPAK', '2', 15, 84, 4, NULL, NULL, '2026-11-05 09:36:28', '2026-11-05 09:36:28', 'SDN DUPAK 1 ALUN ALUN BANGUNSARI SELATAN NO. 90', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (147, 145, 'KEMANGI KEMAYORAN', 'KREMBANGAN', 'KEMAYORAN', '1', 15, 83, 5, NULL, NULL, '2026-11-05 09:38:58', '2026-11-05 09:38:58', 'Jl krembangan jaya utara 1 no 89', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (148, 212, 'KEMANGI SERUNI', 'PAKAL', 'BENOWO', '1', 30, 150, 1, NULL, NULL, '2026-11-05 09:45:20', '2026-11-05 09:45:20', 'JL. RAYA BENOWO NO. 88', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (149, 143, 'PUTRI DUYUNG', 'KREMBANGAN', 'PERAK BARAT', '2', 15, 81, 6, NULL, NULL, '2026-11-05 09:57:01', '2026-11-05 09:57:01', 'JL.IKAN GURAMI LEBAR NO. 14', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (150, 150, 'ANGGREK CERIA', 'SEMAMPIR', 'AMPEL', '1', 16, 88, 3, NULL, NULL, '2026-11-05 10:18:02', '2026-11-05 10:18:02', 'AMPEL MULIA 23', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (151, 150, 'ANGGREK CERIA', 'SEMAMPIR', 'AMPEL', '2', 16, 88, 3, NULL, NULL, '2026-11-05 10:18:48', '2026-11-05 10:18:48', 'AMPEL MULIA 23', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (173, 153, 'Semanggi', 'KENJERAN', 'TAMBAK WEDI', '2', 17, 91, 3, NULL, NULL, '2026-11-13 10:01:00', '2026-11-13 10:01:00', 'Tambak Wedi Baru No 85 Surabaya', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (154, 142, 'AMORA', 'KREMBANGAN', 'MOROKREMBANGAN', '2', 15, 80, 7, NULL, NULL, '2026-11-05 10:40:07', '2026-11-05 10:40:07', 'jl. Kalianak Timur lebar no. 22', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (153, 147, 'CERIA', 'SEMAMPIR', 'WONOKUSUMO', '2', 16, 85, 6, NULL, NULL, '2026-11-05 10:35:40', '2026-11-05 12:17:53', 'Jl Bulaksari no 26 Surabaya', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (152, 147, 'PERMATA CERIA', 'SEMAMPIR', 'WONOKUSUMO', '1', 16, 85, 15, NULL, NULL, '2026-11-05 10:34:04', '2026-11-05 12:18:19', 'Jl Bulak Jaya gg 5 no 9 Surabaya', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (155, 212, 'KEMANGI BENOWO CERIA RW 2', 'PAKAL', 'BENOWO', '2', 30, 150, 1, NULL, NULL, '2026-11-05 12:26:59', '2026-11-05 12:26:59', 'JL. RAYA BENOWO NO. 88', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (156, 205, 'KEMANGI YASMIN', 'BULAK', 'SUKOLILO BARU', '1', 29, 143, 1, NULL, NULL, '2026-11-06 10:44:32', '2026-11-06 10:44:32', 'Jl. Sukolilo Larangan', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (157, 205, 'KEMANGI AVICENNA', 'BULAK', 'SUKOLILO BARU', '2', 29, 143, 2, NULL, NULL, '2026-11-06 10:45:39', '2026-11-06 10:45:39', 'Jl. Sukolilo gang 4', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (161, 210, 'Kemangi Baji Tangguh', 'PAKAL', 'PAKAL', '2', 30, 148, 4, NULL, NULL, '2026-11-06 18:19:33', '2026-11-06 18:19:33', 'BEJI SELATAN RT 4', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (162, 149, 'Mawar', 'SEMAMPIR', 'UJUNG', '1', 16, 87, 10, NULL, NULL, '2026-11-08 19:46:33', '2026-11-08 19:46:33', 'Sawah Pulo SR No. 2', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (163, 149, 'Al Wardah', 'SEMAMPIR', 'UJUNG', '2', 16, 87, 9, NULL, NULL, '2026-11-08 19:47:43', '2026-11-08 19:47:43', 'Sawah Pulo SR No. 2', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (164, 86, 'PELANGI', 'TEGALSARI', 'WONOREJO', '1', 5, 24, 8, NULL, NULL, '2026-11-09 13:40:26', '2026-11-09 13:40:26', 'BALAI RW 8', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (165, 86, 'PELANGI', 'TEGALSARI', 'WONOREJO', '2', 5, 24, 6, NULL, NULL, '2026-11-09 13:41:19', '2026-11-09 13:41:19', 'BALAI RW6', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (166, 114, 'bougenvile', 'TAMBAKSARI', 'PACARKEMBANG', '1', 10, 52, 8, NULL, NULL, '2026-11-11 10:41:02', '2026-11-11 10:41:02', 'Bronggalan sawah 2 no 1', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (167, 114, 'MELATI', 'TAMBAKSARI', 'PACARKEMBANG', '2', 10, 52, 6, NULL, NULL, '2026-11-11 10:44:00', '2026-11-11 10:44:00', 'pacarkembang 8 no 25', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (168, 165, 'Raihan', 'BENOWO', 'TAMBAK OSO WILANGUN', '1', 19, 103, 1, NULL, '2026-11-11 12:26:42', '2026-11-11 12:25:55', '2026-11-11 12:26:42', 'Tambak osowilangun rt1 rw1', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (169, 165, 'Raihan', 'BENOWO', 'TAMBAK OSO WILANGUN', '1', 19, 103, 1, NULL, NULL, '2026-11-11 12:28:12', '2026-11-11 12:28:12', 'Tambak osowilangun RT 1 RW 1', 'krisan_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (170, 165, 'Aurora', 'BENOWO', 'TAMBAK OSO WILANGUN', '2', 19, 103, 1, NULL, NULL, '2026-11-11 12:29:05', '2026-11-11 12:29:05', 'Tambak osowilangun RT 1 RW 1', 'krisan_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (171, 153, 'Ombak Inspirasi', 'KENJERAN', 'TAMBAK WEDI', '1', 17, 91, 4, NULL, NULL, '2026-11-11 13:57:00', '2026-11-11 13:57:00', 'Jl Tambak Wedi Baru No 103 Surabaya', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (174, 155, 'KEMANGI CEMPAKA JAYA', 'KENJERAN', 'TANAH KALI KEDINDING', '1', 17, 93, 7, NULL, NULL, '2026-11-13 16:04:23', '2026-11-13 16:05:27', 'POGOT JAYA', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (175, 67, 'Sido Harum', 'WONOCOLO', 'SIDOSERMO', '2', 2, 5, 1, NULL, NULL, '2026-11-14 09:33:02', '2026-11-14 09:33:02', 'Sidosermo PDK IV Kav 147', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (176, 67, 'Sido Wangi', 'WONOCOLO', 'SIDOSERMO', '1', 2, 5, 2, NULL, NULL, '2026-11-14 09:33:28', '2026-11-14 09:33:28', 'Sidosermo PDK IV Kav 147', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (91, 135, 'PELITA JEPARA', 'BUBUTAN', 'JEPARA', '1', 13, 73, 4, NULL, NULL, '2026-11-03 09:19:53', '2026-11-14 23:10:15', 'kantor Kelurahan', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (160, 208, 'MAWAR CERIA', 'BULAK', 'KENJERAN', '1', 29, 146, 1, NULL, '2026-11-16 13:27:10', '2026-11-06 12:00:01', '2026-11-16 13:27:10', 'Tambak Deres', 'kilas_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (159, 208, 'MAWAR CERIA', 'BULAK', 'KENJERAN', '1', 29, 146, 1, NULL, NULL, '2026-11-06 11:59:25', '2026-11-16 09:24:59', 'Tambak Deres', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (158, 208, 'MAWAR CERIA', 'BULAK', 'KENJERAN', '1', 29, 146, 1, NULL, '2026-11-16 13:27:03', '2026-11-06 11:58:09', '2026-11-16 13:27:03', 'Tambak Deres', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (195, 200, 'MUHAMMAD DAFFA AL GHAZALI ANGGONO', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 5, NULL, NULL, '2026-11-16 10:27:50', '2026-11-16 10:27:50', 'SUKOMANUNGGAL BARU SELATAN PJKA 215', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (196, 200, 'MOHAMMAD AZAM AL HAFIDAR', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 5, NULL, NULL, '2026-11-16 10:28:18', '2026-11-16 10:28:18', 'SUKOMANUNGGAL BARU SELATAN PJKA 269', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (187, 200, 'SITI NUR MAULIDA', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 1, NULL, NULL, '2026-11-16 10:23:04', '2026-11-16 10:28:33', 'DONOWATI 4/18', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (189, 200, 'ACHMAD NAUFAL AZMI PAMUNGKAS', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 1, NULL, NULL, '2026-11-16 10:24:05', '2026-11-16 10:28:38', 'DONOWATI 4A/7', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (191, 200, 'DANISWARA JATMIKA PRATAMA', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 1, NULL, NULL, '2026-11-16 10:25:15', '2026-11-16 10:28:43', 'DONOWATI 3/2', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (193, 200, 'EGEI DWI ERLANGGA', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 2, NULL, NULL, '2026-11-16 10:26:37', '2026-11-16 10:28:48', 'SUKOMANUNGGAL 1/24', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (194, 200, 'ACHAMAD ARSYIL AZDIEM', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 4, NULL, NULL, '2026-11-16 10:27:00', '2026-11-16 10:28:55', 'TAMBAK LUMPANG NO.42-B', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (192, 200, 'GYSELLA AURA FEBTYA', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 2, NULL, NULL, '2026-11-16 10:25:48', '2026-11-16 10:29:00', 'SUKOMANUNGGAL 1/19', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (190, 200, 'NATANAEL KUISTAFOEN OLLA', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 1, NULL, NULL, '2026-11-16 10:24:33', '2026-11-16 10:29:05', 'DONOWATI 7/43', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (188, 200, 'AKBAR NURDAFFA', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 1, NULL, NULL, '2026-11-16 10:23:43', '2026-11-16 10:29:10', 'DONOWATI 4/21', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (177, 200, 'A''ISAH', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 1, NULL, NULL, '2026-11-16 10:07:10', '2026-11-16 10:29:24', 'DONOWATI 4/18', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (178, 200, 'IIN MEGAWATI', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 1, NULL, NULL, '2026-11-16 10:10:54', '2026-11-16 10:29:28', 'DONOWATI 4/21', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (179, 200, 'SUHARTINI', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 1, NULL, NULL, '2026-11-16 10:11:16', '2026-11-16 10:29:33', 'DONOWATI 4A/7', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (180, 200, 'SRI WAHYUNI', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 1, NULL, NULL, '2026-11-16 10:12:22', '2026-11-16 10:29:38', 'DONOWATI 7/43', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (181, 200, 'ASMINAH', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 1, NULL, NULL, '2026-11-16 10:13:12', '2026-11-16 10:29:43', 'DONOWATI 3/2', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (182, 200, 'ANITA', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 2, NULL, NULL, '2026-11-16 10:20:22', '2026-11-16 10:29:48', 'SUKOMANUNGGAL 1/19', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (183, 200, 'KALIMAH', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 2, NULL, NULL, '2026-11-16 10:20:58', '2026-11-16 10:29:54', 'SUKOMANUNGGAL 1/24', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (184, 200, 'NOR KOMARIYAH', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 4, NULL, NULL, '2026-11-16 10:21:36', '2026-11-16 10:29:59', 'TAMBAK LUMPANG NO.42-B', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (185, 200, 'TITIK MARDIANNA MEYKASARI', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 5, NULL, NULL, '2026-11-16 10:21:59', '2026-11-16 10:30:04', 'SUKOMANUNGGAL BARU SELATAN PJKA 215', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (186, 200, 'LILIK ELLYNGGAR VIRDAUZY', 'SUKOMANUNGGAL', 'SUKOMANUNGGAL', '2', 27, 138, 1, NULL, NULL, '2026-11-16 10:22:22', '2026-11-16 10:30:09', 'SUKOMANUNGGAL BARU SELATAN PJKA 269', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (197, 208, 'MELATI', 'BULAK', 'KENJERAN', '2', 29, 146, 2, NULL, NULL, '2026-11-16 13:28:03', '2026-11-16 13:28:03', 'KEJAWN LOR', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (198, 197, 'KEMANGI TAHAP 1', 'SUKOMANUNGGAL', 'SIMOMULYO BARU', '1', 27, 135, 2, NULL, NULL, '2026-11-17 11:02:13', '2026-11-17 11:02:13', 'KELURAHAN SIMOMULYO BARU', 'krisan_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (199, 197, 'KEMANGI TAHAP 2', 'SUKOMANUNGGAL', 'SIMOMULYO BARU', '2', 27, 135, 7, NULL, NULL, '2026-11-17 11:10:59', '2026-11-17 11:10:59', 'BALAI RW 07 SIMOREJO SARI B', 'kisah_volume', '2027');
INSERT INTO "public"."m_lotus" VALUES (200, 197, 'KELAS PARENTING PUSPAGA JUPITER', 'SUKOMANUNGGAL', 'SIMOMULYO BARU', '1', 27, 135, 8, NULL, NULL, '2026-11-17 11:20:49', '2026-11-17 11:21:11', 'ZOOM', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (201, 197, 'KELAS PARENTING PUSPAGA CEPAK', 'SUKOMANUNGGAL', 'SIMOMULYO BARU', '1', 27, 135, 8, NULL, NULL, '2026-11-17 11:21:30', '2026-11-17 11:21:30', 'ZOOM', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (202, 197, 'KELAS PARENTING PUSPAGA CATIN', 'SUKOMANUNGGAL', 'SIMOMULYO BARU', '2', 27, 135, 8, NULL, NULL, '2026-11-17 11:22:04', '2026-11-17 11:22:04', 'ZOOM', 'kisah_volume', '2027');
INSERT INTO "public"."m_lotus" VALUES (203, 197, 'KELAS PARENTING PUSPAGA LANSIA', 'SUKOMANUNGGAL', 'SIMOMULYO BARU', '2', 27, 135, 8, NULL, NULL, '2026-11-17 11:22:47', '2026-11-17 11:22:47', 'ZOOM', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (204, 139, 'SRIKANDI', 'TANDES', 'KARANG POH', '1', 14, 77, 6, NULL, NULL, '2026-11-17 16:23:18', '2026-11-17 16:23:18', 'JL. DARMO INDAH ASRI NO. 2', 'kisah_volume', '2026');
INSERT INTO "public"."m_lotus" VALUES (205, 139, 'SRIKANDI', 'TANDES', 'KARANG POH', '2', 14, 77, 6, NULL, NULL, '2026-11-17 16:25:19', '2026-11-17 16:25:19', 'JL. DARMO INDAH ASRI NO. 2', 'kisah_volume', '2026');

-- ----------------------------
-- Primary Key structure for table m_lotus
-- ----------------------------
ALTER TABLE "public"."m_lotus" ADD CONSTRAINT "m_lotus_pkey" PRIMARY KEY ("id");
