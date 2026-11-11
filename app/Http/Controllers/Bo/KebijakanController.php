<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\Kebijakan;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class KebijakanController extends Controller
{
    private const UPLOAD_DIR = 'uploads/file-surat-keputusan';
    private const POKJA = ['Sekretaris', 'Pokja 1', 'Pokja 2', 'Pokja 3', 'Pokja 4'];
    private const PAGE_SIZES = [10, 25, 50];
    private const POLA_NO_SK = '/^[0-9A-Za-z.\/\-]+$/';
    private const POLA_PERIHAL = '/^[\p{L}\p{N} .,\-\/()&:%\'"]+$/u';
    private const POLA_KETERANGAN = '/^[\p{L}\p{N} .,\-\/()&:%\'"\r\n]+$/u';
    private const POLA_BAHAYA = '/(https?|ftp|sftp)\s*:|javascript\s*:|vbscript\s*:|mailto\s*:|www\s*\.|:\s*\/\/|[a-z0-9\-]+\.(com|net|org|xyz|info|biz|top|site|online|link|click|app|dev|go\.id|co\.id|or\.id|web\.id|sch\.id)\b/iu';

    private const LABEL = [
        'no_sk'       => 'No SK',
        'perihal'     => 'Perihal',
        'id_kec'      => 'Kecamatan',
        'id_kel'      => 'Kelurahan',
        'tgl_mulai'   => 'Tanggal mulai',
        'tgl_selesai' => 'Tanggal selesai',
        'pokja'       => 'Pokja',
        'keterangan'  => 'Keterangan',
        'file_sk'     => 'File SK',
    ];

    public const WILAYAH = [
        '101' => ['id_kel' => '101', 'id_kec' => '1', 'nama_kel' => 'Asem Rowo', 'nama_kec' => 'ASEMROWO'],
        '102' => ['id_kel' => '102', 'id_kec' => '1', 'nama_kel' => 'Genting Kalianak', 'nama_kec' => 'ASEMROWO'],
        '103' => ['id_kel' => '103', 'id_kec' => '1', 'nama_kel' => 'Tambak Sarioso', 'nama_kec' => 'ASEMROWO'],
        '201' => ['id_kel' => '201', 'id_kec' => '2', 'nama_kel' => 'Kandangan', 'nama_kec' => 'BENOWO'],
        '202' => ['id_kel' => '202', 'id_kec' => '2', 'nama_kel' => 'Romokalisari', 'nama_kec' => 'BENOWO'],
        '203' => ['id_kel' => '203', 'id_kec' => '2', 'nama_kel' => 'Sememi', 'nama_kec' => 'BENOWO'],
        '204' => ['id_kel' => '204', 'id_kec' => '2', 'nama_kel' => 'Tambak Osowilangon', 'nama_kec' => 'BENOWO'],
        '301' => ['id_kel' => '301', 'id_kec' => '3', 'nama_kel' => 'Alun-Alun Contong', 'nama_kec' => 'BUBUTAN'],
        '302' => ['id_kel' => '302', 'id_kec' => '3', 'nama_kel' => 'Bubutan', 'nama_kec' => 'BUBUTAN'],
        '303' => ['id_kel' => '303', 'id_kec' => '3', 'nama_kel' => 'Gundih', 'nama_kec' => 'BUBUTAN'],
        '304' => ['id_kel' => '304', 'id_kec' => '3', 'nama_kel' => 'Jepara', 'nama_kec' => 'BUBUTAN'],
        '305' => ['id_kel' => '305', 'id_kec' => '3', 'nama_kel' => 'Tembok Dukuh', 'nama_kec' => 'BUBUTAN'],
        '401' => ['id_kel' => '401', 'id_kec' => '4', 'nama_kel' => 'Bulak', 'nama_kec' => 'BULAK'],
        '402' => ['id_kel' => '402', 'id_kec' => '4', 'nama_kel' => 'Kedung Cowek', 'nama_kec' => 'BULAK'],
        '403' => ['id_kel' => '403', 'id_kec' => '4', 'nama_kel' => 'Kenjeran', 'nama_kec' => 'BULAK'],
        '404' => ['id_kel' => '404', 'id_kec' => '4', 'nama_kel' => 'Sukolilo Baru', 'nama_kec' => 'BULAK'],
        '501' => ['id_kel' => '501', 'id_kec' => '5', 'nama_kel' => 'Dukuh Kupang', 'nama_kec' => 'DUKUH PAKIS'],
        '502' => ['id_kel' => '502', 'id_kec' => '5', 'nama_kel' => 'Dukuh Pakis', 'nama_kec' => 'DUKUH PAKIS'],
        '503' => ['id_kel' => '503', 'id_kec' => '5', 'nama_kel' => 'Gunung Sari', 'nama_kec' => 'DUKUH PAKIS'],
        '504' => ['id_kel' => '504', 'id_kec' => '5', 'nama_kel' => 'Pradah Kalikendal', 'nama_kec' => 'DUKUH PAKIS'],
        '601' => ['id_kel' => '601', 'id_kec' => '6', 'nama_kel' => 'Dukuh Menanggal', 'nama_kec' => 'GAYUNGAN'],
        '602' => ['id_kel' => '602', 'id_kec' => '6', 'nama_kel' => 'Gayungan', 'nama_kec' => 'GAYUNGAN'],
        '603' => ['id_kel' => '603', 'id_kec' => '6', 'nama_kel' => 'Ketintang', 'nama_kec' => 'GAYUNGAN'],
        '604' => ['id_kel' => '604', 'id_kec' => '6', 'nama_kel' => 'Menanggal', 'nama_kec' => 'GAYUNGAN'],
        '701' => ['id_kel' => '701', 'id_kec' => '7', 'nama_kel' => 'Embong Kaliasin', 'nama_kec' => 'GENTENG'],
        '702' => ['id_kel' => '702', 'id_kec' => '7', 'nama_kel' => 'Genteng', 'nama_kec' => 'GENTENG'],
        '703' => ['id_kel' => '703', 'id_kec' => '7', 'nama_kel' => 'Kapasari', 'nama_kec' => 'GENTENG'],
        '704' => ['id_kel' => '704', 'id_kec' => '7', 'nama_kel' => 'Ketabang', 'nama_kec' => 'GENTENG'],
        '705' => ['id_kel' => '705', 'id_kec' => '7', 'nama_kel' => 'Peneleh', 'nama_kec' => 'GENTENG'],
        '801' => ['id_kel' => '801', 'id_kec' => '8', 'nama_kel' => 'Airlangga', 'nama_kec' => 'GUBENG'],
        '802' => ['id_kel' => '802', 'id_kec' => '8', 'nama_kel' => 'Baratajaya', 'nama_kec' => 'GUBENG'],
        '803' => ['id_kel' => '803', 'id_kec' => '8', 'nama_kel' => 'Gubeng', 'nama_kec' => 'GUBENG'],
        '804' => ['id_kel' => '804', 'id_kec' => '8', 'nama_kel' => 'Kertajaya', 'nama_kec' => 'GUBENG'],
        '805' => ['id_kel' => '805', 'id_kec' => '8', 'nama_kel' => 'Mojo', 'nama_kec' => 'GUBENG'],
        '806' => ['id_kel' => '806', 'id_kec' => '8', 'nama_kel' => 'Pucang Sewu', 'nama_kec' => 'GUBENG'],
        '901' => ['id_kel' => '901', 'id_kec' => '9', 'nama_kel' => 'Gunung Anyar', 'nama_kec' => 'GUNUNG ANYAR'],
        '902' => ['id_kel' => '902', 'id_kec' => '9', 'nama_kel' => 'Gunung Anyar Tambak', 'nama_kec' => 'GUNUNG ANYAR'],
        '903' => ['id_kel' => '903', 'id_kec' => '9', 'nama_kel' => 'Rungkut Menanggal', 'nama_kec' => 'GUNUNG ANYAR'],
        '904' => ['id_kel' => '904', 'id_kec' => '9', 'nama_kel' => 'Rungkut Tengah', 'nama_kec' => 'GUNUNG ANYAR'],
        '1001' => ['id_kel' => '1001', 'id_kec' => '10', 'nama_kel' => 'Jambangan', 'nama_kec' => 'JAMBANGAN'],
        '1002' => ['id_kel' => '1002', 'id_kec' => '10', 'nama_kel' => 'Karah', 'nama_kec' => 'JAMBANGAN'],
        '1003' => ['id_kel' => '1003', 'id_kec' => '10', 'nama_kel' => 'Kebonsari', 'nama_kec' => 'JAMBANGAN'],
        '1004' => ['id_kel' => '1004', 'id_kec' => '10', 'nama_kel' => 'Pagesangan', 'nama_kec' => 'JAMBANGAN'],
        '1101' => ['id_kel' => '1101', 'id_kec' => '11', 'nama_kel' => 'Karang Pilang', 'nama_kec' => 'KARANG PILANG'],
        '1102' => ['id_kel' => '1102', 'id_kec' => '11', 'nama_kel' => 'Kebraon', 'nama_kec' => 'KARANG PILANG'],
        '1103' => ['id_kel' => '1103', 'id_kec' => '11', 'nama_kel' => 'Kedurus', 'nama_kec' => 'KARANG PILANG'],
        '1104' => ['id_kel' => '1104', 'id_kec' => '11', 'nama_kel' => 'Warugunung', 'nama_kec' => 'KARANG PILANG'],
        '1201' => ['id_kel' => '1201', 'id_kec' => '12', 'nama_kel' => 'Bulak Banteng', 'nama_kec' => 'KENJERAN'],
        '1202' => ['id_kel' => '1202', 'id_kec' => '12', 'nama_kel' => 'Tambak Wedi', 'nama_kec' => 'KENJERAN'],
        '1203' => ['id_kel' => '1203', 'id_kec' => '12', 'nama_kel' => 'Tanah Kali Kedinding', 'nama_kec' => 'KENJERAN'],
        '1204' => ['id_kel' => '1204', 'id_kec' => '12', 'nama_kel' => 'Sidotopo Wetan', 'nama_kec' => 'KENJERAN'],
        '1301' => ['id_kel' => '1301', 'id_kec' => '13', 'nama_kel' => 'Dupak', 'nama_kec' => 'KREMBANGAN'],
        '1302' => ['id_kel' => '1302', 'id_kec' => '13', 'nama_kel' => 'Kemayoran', 'nama_kec' => 'KREMBANGAN'],
        '1303' => ['id_kel' => '1303', 'id_kec' => '13', 'nama_kel' => 'Krembangan Selatan', 'nama_kec' => 'KREMBANGAN'],
        '1304' => ['id_kel' => '1304', 'id_kec' => '13', 'nama_kel' => 'Morokrembangan', 'nama_kec' => 'KREMBANGAN'],
        '1305' => ['id_kel' => '1305', 'id_kec' => '13', 'nama_kel' => 'Perak Barat', 'nama_kec' => 'KREMBANGAN'],
        '1401' => ['id_kel' => '1401', 'id_kec' => '14', 'nama_kel' => 'Bangkingan', 'nama_kec' => 'LAKARSANTRI'],
        '1402' => ['id_kel' => '1402', 'id_kec' => '14', 'nama_kel' => 'Jeruk', 'nama_kec' => 'LAKARSANTRI'],
        '1403' => ['id_kel' => '1403', 'id_kec' => '14', 'nama_kel' => 'Lakarsantri', 'nama_kec' => 'LAKARSANTRI'],
        '1404' => ['id_kel' => '1404', 'id_kec' => '14', 'nama_kel' => 'Lidah Kulon', 'nama_kec' => 'LAKARSANTRI'],
        '1405' => ['id_kel' => '1405', 'id_kec' => '14', 'nama_kel' => 'Lidah Wetan', 'nama_kec' => 'LAKARSANTRI'],
        '1406' => ['id_kel' => '1406', 'id_kec' => '14', 'nama_kel' => 'Sumur Welut', 'nama_kec' => 'LAKARSANTRI'],
        '1501' => ['id_kel' => '1501', 'id_kec' => '15', 'nama_kel' => 'Dukuh Sutorejo', 'nama_kec' => 'MULYOREJO'],
        '1502' => ['id_kel' => '1502', 'id_kec' => '15', 'nama_kel' => 'Kalijudan', 'nama_kec' => 'MULYOREJO'],
        '1503' => ['id_kel' => '1503', 'id_kec' => '15', 'nama_kel' => 'Kalisari', 'nama_kec' => 'MULYOREJO'],
        '1504' => ['id_kel' => '1504', 'id_kec' => '15', 'nama_kel' => 'Kejawan Putih Tambak', 'nama_kec' => 'MULYOREJO'],
        '1505' => ['id_kel' => '1505', 'id_kec' => '15', 'nama_kel' => 'Manyar Sabrangan', 'nama_kec' => 'MULYOREJO'],
        '1506' => ['id_kel' => '1506', 'id_kec' => '15', 'nama_kel' => 'Mulyorejo', 'nama_kec' => 'MULYOREJO'],
        '1601' => ['id_kel' => '1601', 'id_kec' => '16', 'nama_kel' => 'Bongkaran', 'nama_kec' => 'PABEAN CANTIKAN'],
        '1602' => ['id_kel' => '1602', 'id_kec' => '16', 'nama_kel' => 'Krembangan Utara', 'nama_kec' => 'PABEAN CANTIKAN'],
        '1603' => ['id_kel' => '1603', 'id_kec' => '16', 'nama_kel' => 'Nyamplungan', 'nama_kec' => 'PABEAN CANTIKAN'],
        '1604' => ['id_kel' => '1604', 'id_kec' => '16', 'nama_kel' => 'Perak Timur', 'nama_kec' => 'PABEAN CANTIKAN'],
        '1605' => ['id_kel' => '1605', 'id_kec' => '16', 'nama_kel' => 'Perak Utara', 'nama_kec' => 'PABEAN CANTIKAN'],
        '1701' => ['id_kel' => '1701', 'id_kec' => '17', 'nama_kel' => 'Babat Jerawat', 'nama_kec' => 'PAKAL'],
        '1702' => ['id_kel' => '1702', 'id_kec' => '17', 'nama_kel' => 'Benowo', 'nama_kec' => 'PAKAL'],
        '1703' => ['id_kel' => '1703', 'id_kec' => '17', 'nama_kel' => 'Pakal', 'nama_kec' => 'PAKAL'],
        '1704' => ['id_kel' => '1704', 'id_kec' => '17', 'nama_kel' => 'Sumberejo', 'nama_kec' => 'PAKAL'],
        '1801' => ['id_kel' => '1801', 'id_kec' => '18', 'nama_kel' => 'Kali Rungkut', 'nama_kec' => 'RUNGKUT'],
        '1802' => ['id_kel' => '1802', 'id_kec' => '18', 'nama_kel' => 'Kedung Baruk', 'nama_kec' => 'RUNGKUT'],
        '1803' => ['id_kel' => '1803', 'id_kec' => '18', 'nama_kel' => 'Medokan Ayu', 'nama_kec' => 'RUNGKUT'],
        '1804' => ['id_kel' => '1804', 'id_kec' => '18', 'nama_kel' => 'Penjaringansari', 'nama_kec' => 'RUNGKUT'],
        '1805' => ['id_kel' => '1805', 'id_kec' => '18', 'nama_kel' => 'Rungkut Kidul', 'nama_kec' => 'RUNGKUT'],
        '1806' => ['id_kel' => '1806', 'id_kec' => '18', 'nama_kel' => 'Wonorejo', 'nama_kec' => 'RUNGKUT'],
        '1901' => ['id_kel' => '1901', 'id_kec' => '19', 'nama_kel' => 'Bringin', 'nama_kec' => 'SAMBIKEREP'],
        '1902' => ['id_kel' => '1902', 'id_kec' => '19', 'nama_kel' => 'Made', 'nama_kec' => 'SAMBIKEREP'],
        '1903' => ['id_kel' => '1903', 'id_kec' => '19', 'nama_kel' => 'Lontar', 'nama_kec' => 'SAMBIKEREP'],
        '1904' => ['id_kel' => '1904', 'id_kec' => '19', 'nama_kel' => 'Sambikerep', 'nama_kec' => 'SAMBIKEREP'],
        '2001' => ['id_kel' => '2001', 'id_kec' => '20', 'nama_kel' => 'Banyu Urip', 'nama_kec' => 'SAWAHAN'],
        '2002' => ['id_kel' => '2002', 'id_kec' => '20', 'nama_kel' => 'Kupang Krajan', 'nama_kec' => 'SAWAHAN'],
        '2003' => ['id_kel' => '2003', 'id_kec' => '20', 'nama_kel' => 'Pakis', 'nama_kec' => 'SAWAHAN'],
        '2004' => ['id_kel' => '2004', 'id_kec' => '20', 'nama_kel' => 'Petemon', 'nama_kec' => 'SAWAHAN'],
        '2005' => ['id_kel' => '2005', 'id_kec' => '20', 'nama_kel' => 'Putat Jaya', 'nama_kec' => 'SAWAHAN'],
        '2006' => ['id_kel' => '2006', 'id_kec' => '20', 'nama_kel' => 'Sawahan', 'nama_kec' => 'SAWAHAN'],
        '2101' => ['id_kel' => '2101', 'id_kec' => '21', 'nama_kel' => 'Ampel', 'nama_kec' => 'SEMAMPIR'],
        '2102' => ['id_kel' => '2102', 'id_kec' => '21', 'nama_kel' => 'Pegirian', 'nama_kec' => 'SEMAMPIR'],
        '2103' => ['id_kel' => '2103', 'id_kec' => '21', 'nama_kel' => 'Sidotopo', 'nama_kec' => 'SEMAMPIR'],
        '2104' => ['id_kel' => '2104', 'id_kec' => '21', 'nama_kel' => 'Ujung', 'nama_kec' => 'SEMAMPIR'],
        '2105' => ['id_kel' => '2105', 'id_kec' => '21', 'nama_kel' => 'Wonokusumo', 'nama_kec' => 'SEMAMPIR'],
        '2201' => ['id_kel' => '2201', 'id_kec' => '22', 'nama_kel' => 'Kapasan', 'nama_kec' => 'SIMOKERTO'],
        '2202' => ['id_kel' => '2202', 'id_kec' => '22', 'nama_kel' => 'Sidodadi', 'nama_kec' => 'SIMOKERTO'],
        '2203' => ['id_kel' => '2203', 'id_kec' => '22', 'nama_kel' => 'Simokerto', 'nama_kec' => 'SIMOKERTO'],
        '2204' => ['id_kel' => '2204', 'id_kec' => '22', 'nama_kel' => 'Simolawang', 'nama_kec' => 'SIMOKERTO'],
        '2205' => ['id_kel' => '2205', 'id_kec' => '22', 'nama_kel' => 'Tambakrejo', 'nama_kec' => 'SIMOKERTO'],
        '2301' => ['id_kel' => '2301', 'id_kec' => '23', 'nama_kel' => 'Gebang Putih', 'nama_kec' => 'SUKOLILO'],
        '2302' => ['id_kel' => '2302', 'id_kec' => '23', 'nama_kel' => 'Keputih', 'nama_kec' => 'SUKOLILO'],
        '2303' => ['id_kel' => '2303', 'id_kec' => '23', 'nama_kel' => 'Klampis Ngasem', 'nama_kec' => 'SUKOLILO'],
        '2304' => ['id_kel' => '2304', 'id_kec' => '23', 'nama_kel' => 'Medokan Semampir', 'nama_kec' => 'SUKOLILO'],
        '2305' => ['id_kel' => '2305', 'id_kec' => '23', 'nama_kel' => 'Menur Pumpungan', 'nama_kec' => 'SUKOLILO'],
        '2306' => ['id_kel' => '2306', 'id_kec' => '23', 'nama_kel' => 'Nginden Jangkungan', 'nama_kec' => 'SUKOLILO'],
        '2307' => ['id_kel' => '2307', 'id_kec' => '23', 'nama_kel' => 'Semolowaru', 'nama_kec' => 'SUKOLILO'],
        '2401' => ['id_kel' => '2401', 'id_kec' => '24', 'nama_kel' => 'Putat Gede', 'nama_kec' => 'SUKOMANUNGGAL'],
        '2402' => ['id_kel' => '2402', 'id_kec' => '24', 'nama_kel' => 'Simomulyo', 'nama_kec' => 'SUKOMANUNGGAL'],
        '2403' => ['id_kel' => '2403', 'id_kec' => '24', 'nama_kel' => 'Simomulyo Baru', 'nama_kec' => 'SUKOMANUNGGAL'],
        '2404' => ['id_kel' => '2404', 'id_kec' => '24', 'nama_kel' => 'Sukomanunggal', 'nama_kec' => 'SUKOMANUNGGAL'],
        '2405' => ['id_kel' => '2405', 'id_kec' => '24', 'nama_kel' => 'Sonokwijenan', 'nama_kec' => 'SUKOMANUNGGAL'],
        '2406' => ['id_kel' => '2406', 'id_kec' => '24', 'nama_kel' => 'Tanjungsari', 'nama_kec' => 'SUKOMANUNGGAL'],
        '2501' => ['id_kel' => '2501', 'id_kec' => '25', 'nama_kel' => 'Dukuh Setro', 'nama_kec' => 'TAMBAKSARI'],
        '2502' => ['id_kel' => '2502', 'id_kec' => '25', 'nama_kel' => 'Gading', 'nama_kec' => 'TAMBAKSARI'],
        '2503' => ['id_kel' => '2503', 'id_kec' => '25', 'nama_kel' => 'Kapasmadya Baru', 'nama_kec' => 'TAMBAKSARI'],
        '2504' => ['id_kel' => '2504', 'id_kec' => '25', 'nama_kel' => 'Pacar Kembang', 'nama_kec' => 'TAMBAKSARI'],
        '2505' => ['id_kel' => '2505', 'id_kec' => '25', 'nama_kel' => 'Pacar Keling', 'nama_kec' => 'TAMBAKSARI'],
        '2506' => ['id_kel' => '2506', 'id_kec' => '25', 'nama_kel' => 'Ploso', 'nama_kec' => 'TAMBAKSARI'],
        '2507' => ['id_kel' => '2507', 'id_kec' => '25', 'nama_kel' => 'Rangkah', 'nama_kec' => 'TAMBAKSARI'],
        '2508' => ['id_kel' => '2508', 'id_kec' => '25', 'nama_kel' => 'Tambaksari', 'nama_kec' => 'TAMBAKSARI'],
        '2601' => ['id_kel' => '2601', 'id_kec' => '26', 'nama_kel' => 'Balongsari', 'nama_kec' => 'TANDES'],
        '2602' => ['id_kel' => '2602', 'id_kec' => '26', 'nama_kel' => 'Banjar Sugihan', 'nama_kec' => 'TANDES'],
        '2603' => ['id_kel' => '2603', 'id_kec' => '26', 'nama_kel' => 'Karang Poh', 'nama_kec' => 'TANDES'],
        '2604' => ['id_kel' => '2604', 'id_kec' => '26', 'nama_kel' => 'Manukan Kulon', 'nama_kec' => 'TANDES'],
        '2605' => ['id_kel' => '2605', 'id_kec' => '26', 'nama_kel' => 'Manukan Wetan', 'nama_kec' => 'TANDES'],
        '2606' => ['id_kel' => '2606', 'id_kec' => '26', 'nama_kel' => 'Tandes', 'nama_kec' => 'TANDES'],
        '2701' => ['id_kel' => '2701', 'id_kec' => '27', 'nama_kel' => 'Dr. Soetomo', 'nama_kec' => 'TEGALSARI'],
        '2702' => ['id_kel' => '2702', 'id_kec' => '27', 'nama_kel' => 'Kedungdoro', 'nama_kec' => 'TEGALSARI'],
        '2703' => ['id_kel' => '2703', 'id_kec' => '27', 'nama_kel' => 'Keputran', 'nama_kec' => 'TEGALSARI'],
        '2704' => ['id_kel' => '2704', 'id_kec' => '27', 'nama_kel' => 'Tegalsari', 'nama_kec' => 'TEGALSARI'],
        '2705' => ['id_kel' => '2705', 'id_kec' => '27', 'nama_kel' => 'Wonorejo', 'nama_kec' => 'TEGALSARI'],
        '2801' => ['id_kel' => '2801', 'id_kec' => '28', 'nama_kel' => 'Kendangsari', 'nama_kec' => 'TENGGILIS MEJOYO'],
        '2802' => ['id_kel' => '2802', 'id_kec' => '28', 'nama_kel' => 'Kutisari', 'nama_kec' => 'TENGGILIS MEJOYO'],
        '2803' => ['id_kel' => '2803', 'id_kec' => '28', 'nama_kel' => 'Panjang Jiwo', 'nama_kec' => 'TENGGILIS MEJOYO'],
        '2804' => ['id_kel' => '2804', 'id_kec' => '28', 'nama_kel' => 'Prapen', 'nama_kec' => 'TENGGILIS MEJOYO'],
        '2805' => ['id_kel' => '2805', 'id_kec' => '28', 'nama_kel' => 'Tenggilis Mejoyo', 'nama_kec' => 'TENGGILIS MEJOYO'],
        '2901' => ['id_kel' => '2901', 'id_kec' => '29', 'nama_kel' => 'Babatan', 'nama_kec' => 'WIYUNG'],
        '2902' => ['id_kel' => '2902', 'id_kec' => '29', 'nama_kel' => 'Balasklumprik', 'nama_kec' => 'WIYUNG'],
        '2903' => ['id_kel' => '2903', 'id_kec' => '29', 'nama_kel' => 'Jajar Tunggal', 'nama_kec' => 'WIYUNG'],
        '2904' => ['id_kel' => '2904', 'id_kec' => '29', 'nama_kel' => 'Wiyung', 'nama_kec' => 'WIYUNG'],
        '3001' => ['id_kel' => '3001', 'id_kec' => '30', 'nama_kel' => 'Bendul Merisi', 'nama_kec' => 'WONOCOLO'],
        '3002' => ['id_kel' => '3002', 'id_kec' => '30', 'nama_kel' => 'Jemur Wonosari', 'nama_kec' => 'WONOCOLO'],
        '3003' => ['id_kel' => '3003', 'id_kec' => '30', 'nama_kel' => 'Margorejo', 'nama_kec' => 'WONOCOLO'],
        '3004' => ['id_kel' => '3004', 'id_kec' => '30', 'nama_kel' => 'Sidosermo', 'nama_kec' => 'WONOCOLO'],
        '3005' => ['id_kel' => '3005', 'id_kec' => '30', 'nama_kel' => 'Siwalankerto', 'nama_kec' => 'WONOCOLO'],
        '3101' => ['id_kel' => '3101', 'id_kec' => '31', 'nama_kel' => 'Darmo', 'nama_kec' => 'WONOKROMO'],
        '3102' => ['id_kel' => '3102', 'id_kec' => '31', 'nama_kel' => 'Jagir', 'nama_kec' => 'WONOKROMO'],
        '3103' => ['id_kel' => '3103', 'id_kec' => '31', 'nama_kel' => 'Ngagel', 'nama_kec' => 'WONOKROMO'],
        '3104' => ['id_kel' => '3104', 'id_kec' => '31', 'nama_kel' => 'Ngagelrejo', 'nama_kec' => 'WONOKROMO'],
        '3105' => ['id_kel' => '3105', 'id_kec' => '31', 'nama_kel' => 'Sawunggaling', 'nama_kec' => 'WONOKROMO'],
        '3106' => ['id_kel' => '3106', 'id_kec' => '31', 'nama_kel' => 'Wonokromo', 'nama_kec' => 'WONOKROMO'],
    ];

    public function index()
    {
        return view('bo.pages.kebijakan.index');
    }

    public function getData(Request $request)
    {
        $limit = (int) $request->input('limit', 10);
        if (!in_array($limit, self::PAGE_SIZES, true)) {
            $limit = 10;
        }

        $search = $request->input('search');
        $search = is_string($search) ? mb_substr(trim($search), 0, 100) : '';
        $search = addcslashes($search, '\\%_');

        $tahun = $request->input('tahun');
        $pokja = $request->input('pokja');
        $idKec = $request->input('id_kec');
        $idKel = $request->input('id_kel');

        $query = Kebijakan::query();

        if (is_string($tahun) && preg_match('/^\d{4}$/', $tahun)) {
            $query->where('tahun', $tahun);
        }

        if (is_string($pokja) && in_array($pokja, self::POKJA, true)) {
            $query->where('pokja', $pokja);
        }

        if (is_string($idKec) && ctype_digit($idKec)) {
            $query->where('id_kec', $idKec);
        }

        if (is_string($idKel) && ctype_digit($idKel)) {
            $query->where('id_kel', $idKel);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('no_sk', 'ilike', "%{$search}%")
                  ->orWhere('perihal', 'ilike', "%{$search}%")
                  ->orWhere('keterangan', 'ilike', "%{$search}%")
                  ->orWhere('pokja', 'ilike', "%{$search}%")
                  ->orWhere('created_by', 'ilike', "%{$search}%");
            });
        }

        $paginator = $query->orderBy('id', 'desc')->paginate($limit);
        $paginator->getCollection()->transform(function ($item) {
            return $this->sertakanNamaWilayah($item);
        });

        return response()->json($paginator);
    }

    private function cariWilayah($idKel)
    {
        return self::WILAYAH[(string) $idKel] ?? null;
    }

    private function sertakanNamaWilayah($kebijakan)
    {
        $wilayah = $this->cariWilayah($kebijakan->id_kel);
        if (empty($kebijakan->nama_kec)) {
            $kebijakan->setAttribute('nama_kec', $wilayah['nama_kec'] ?? null);
        }
        if (empty($kebijakan->nama_kel)) {
            $kebijakan->setAttribute('nama_kel', $wilayah['nama_kel'] ?? null);
        }

        return $kebijakan;
    }

    private function mengandungPolaBerbahaya($nilai)
    {
        return (bool) preg_match(self::POLA_BAHAYA, (string) $nilai);
    }

    private function aturanTeks($pola, $wajib, $maks)
    {
        return [
            'bail',
            $wajib ? 'required' : 'nullable',
            'string',
            'max:' . $maks,
            'regex:' . $pola,
            function ($attribute, $value, $fail) {
                if ($this->mengandungPolaBerbahaya($value)) {
                    $fail((self::LABEL[$attribute] ?? $attribute) . ' tidak boleh berisi link atau script.');
                }
            },
        ];
    }

    private function aturan(Request $request)
    {
        return [
            'no_sk'       => $this->aturanTeks(self::POLA_NO_SK, true, 23),
            'perihal'     => $this->aturanTeks(self::POLA_PERIHAL, true, 255),
            'id_kec'      => ['bail', 'required', 'integer', 'between:1,31'],
            'id_kel'      => [
                'bail',
                'required',
                'integer',
                function ($attribute, $value, $fail) use ($request) {
                    $wilayah = $this->cariWilayah($value);
                    if (!$wilayah || (string) $wilayah['id_kec'] !== (string) $request->input('id_kec')) {
                        $fail('Kelurahan tidak sesuai dengan kecamatan yang dipilih.');
                    }
                },
            ],
            'tgl_mulai'   => ['bail', 'required', 'date_format:Y-m-d', 'after_or_equal:2000-01-01', 'before_or_equal:2100-12-31'],
            'tgl_selesai' => ['bail', 'nullable', 'date_format:Y-m-d', 'after_or_equal:tgl_mulai', 'before_or_equal:2100-12-31'],
            'pokja'       => ['nullable', Rule::in(self::POKJA)],
            'keterangan'  => $this->aturanTeks(self::POLA_KETERANGAN, false, 1000),
            'file_sk'     => [
                'bail',
                'nullable',
                'file',
                'mimes:pdf',
                'mimetypes:application/pdf',
                'max:2048',
                function ($attribute, $value, $fail) {
                    $handle = @fopen($value->getRealPath(), 'rb');
                    $header = $handle ? fread($handle, 5) : '';
                    if ($handle) {
                        fclose($handle);
                    }
                    if ($header !== '%PDF-') {
                        $fail('File SK bukan dokumen PDF yang valid.');
                    }
                },
            ],
        ];
    }

    private function pesan()
    {
        return [
            'required'                    => ':attribute wajib diisi.',
            'string'                      => ':attribute harus berupa teks.',
            'max'                         => [
                'string' => ':attribute maksimal :max karakter.',
                'file'   => ':attribute maksimal :max KB.',
            ],
            'between'                     => ['numeric' => ':attribute tidak valid.'],
            'regex'                       => ':attribute mengandung karakter yang tidak diizinkan.',
            'integer'                     => ':attribute tidak valid.',
            'date_format'                 => ':attribute harus berupa tanggal yang valid.',
            'in'                          => ':attribute tidak valid.',
            'file'                        => ':attribute harus berupa file.',
            'uploaded'                    => ':attribute gagal diunggah.',
            'mimes'                       => ':attribute harus berformat PDF.',
            'mimetypes'                   => ':attribute harus berformat PDF.',
            'tgl_mulai.after_or_equal'    => 'Tanggal mulai tidak boleh sebelum 1 Januari 2000.',
            'tgl_mulai.before_or_equal'   => 'Tanggal mulai tidak boleh melebihi 31 Desember 2100.',
            'tgl_selesai.after_or_equal'  => 'Tanggal selesai tidak boleh kurang dari tanggal mulai.',
            'tgl_selesai.before_or_equal' => 'Tanggal selesai tidak boleh melebihi 31 Desember 2100.',
        ];
    }

    private function bersihkanInput(Request $request)
    {
        $bersih = [];

        foreach (['no_sk', 'perihal', 'keterangan'] as $kolom) {
            $nilai = $request->input($kolom);
            if (!is_string($nilai)) {
                continue;
            }

            $tanpaKontrol = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $nilai);
            $nilai = $tanpaKontrol ?? $nilai;
            $nilai = trim(preg_replace('/[ \t]+/', ' ', $nilai) ?? $nilai);

            $bersih[$kolom] = $nilai === '' ? null : $nilai;
        }

        $request->merge($bersih);
    }

    private function uploadFile($file)
    {
        $fileName = time() . '_' . Str::random(16) . '.pdf';
        $destinationPath = public_path(self::UPLOAD_DIR);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $file->move($destinationPath, $fileName);

        return $fileName;
    }

    private function hapusFile($fileName)
    {
        if (!$fileName) {
            return;
        }

        $fileName = basename($fileName);
        $path = public_path(self::UPLOAD_DIR . '/' . $fileName);
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    public function store(Request $request)
    {
        $this->bersihkanInput($request);
        $data = $request->validate($this->aturan($request), $this->pesan(), self::LABEL);

        $userLogin = auth()->user()->name ?? 'Admin';
        $wilayah = $this->cariWilayah($data['id_kel']);

        $kebijakan = Kebijakan::create([
            'no_sk'       => $data['no_sk'],
            'perihal'     => $data['perihal'],
            'id_kec'      => $data['id_kec'],
            'id_kel'      => $data['id_kel'],
            'nama_kec'    => $wilayah['nama_kec'],
            'nama_kel'    => $wilayah['nama_kel'],
            'tgl_mulai'   => $data['tgl_mulai'],
            'tgl_selesai' => $data['tgl_selesai'] ?? null,
            'file_sk'     => null,
            'keterangan'  => $data['keterangan'] ?? null,
            'kota'        => 'KOTA SURABAYA',
            'tahun'       => date('Y', strtotime($data['tgl_mulai'])),
            'pokja'       => $data['pokja'] ?? null,
            'created_by'  => $userLogin,
            'updated_by'  => null,
            'deleted_by'  => null,
        ]);

        if ($request->hasFile('file_sk')) {
            try {
                $kebijakan->update([
                    'file_sk' => $this->uploadFile($request->file('file_sk')),
                ]);
            } catch (\Throwable $e) {
                report($e);
                return response()->json([
                    'status'  => 'partial',
                    'message' => 'Data berhasil disimpan, tetapi file SK gagal diunggah. Silakan edit data untuk mengunggah ulang.',
                ], 200);
            }
        }

        return response()->json(['status' => 'success', 'data' => $kebijakan], 200);
    }

    private function safeDecrypt($hash)
    {
        $base64 = str_replace(['-', '_'], ['+', '/'], $hash);
        $remainder = strlen($base64) % 4;
        if ($remainder) {
            $base64 .= str_repeat('=', 4 - $remainder);
        }
        $decrypted = base64_decode($base64);
        return Crypt::decryptString($decrypted);
    }

    public function show($id)
    {
        try {
            $realId = $this->safeDecrypt($id);
            $data = Kebijakan::findOrFail($realId);
            $this->sertakanNamaWilayah($data);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $realId = $this->safeDecrypt($id);
            $kebijakan = Kebijakan::findOrFail($realId);

            $this->bersihkanInput($request);
            $data = $request->validate($this->aturan($request), $this->pesan(), self::LABEL);

            $userLogin = auth()->user()->name ?? 'Admin';
            $wilayah = $this->cariWilayah($data['id_kel']);

            $kebijakan->update([
                'no_sk'       => $data['no_sk'],
                'perihal'     => $data['perihal'],
                'id_kec'      => $data['id_kec'],
                'id_kel'      => $data['id_kel'],
                'nama_kec'    => $wilayah['nama_kec'],
                'nama_kel'    => $wilayah['nama_kel'],
                'tgl_mulai'   => $data['tgl_mulai'],
                'tgl_selesai' => $data['tgl_selesai'] ?? null,
                'keterangan'  => $data['keterangan'] ?? null,
                'tahun'       => date('Y', strtotime($data['tgl_mulai'])),
                'pokja'       => $data['pokja'] ?? null,
                'updated_by'  => $userLogin,
            ]);

            if ($request->hasFile('file_sk')) {
                try {
                    $fileLama = $kebijakan->file_sk;
                    $fileBaru = $this->uploadFile($request->file('file_sk'));
                    $kebijakan->update(['file_sk' => $fileBaru]);
                    $this->hapusFile($fileLama);
                } catch (\Throwable $e) {
                    report($e);
                    return response()->json([
                        'status'  => 'partial',
                        'message' => 'Data berhasil diperbarui, tetapi file SK gagal diunggah. Silakan coba unggah ulang.',
                    ], 200);
                }
            }

            return response()->json(['status' => 'success', 'data' => $kebijakan], 200);
        } catch (ValidationException $e) {
            throw $e;
        } catch (ModelNotFoundException | DecryptException $e) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        } catch (\Exception $e) {
            report($e);
            return response()->json(['message' => 'Gagal memperbarui data. Silakan coba lagi.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $realId = $this->safeDecrypt($id);
            $kebijakan = Kebijakan::findOrFail($realId);

            $userLogin = auth()->user()->name ?? 'Admin';
            $fileLama = $kebijakan->file_sk;

            $kebijakan->deleted_by = $userLogin;
            $kebijakan->file_sk = null;
            $kebijakan->save();
            $kebijakan->delete();

            $this->hapusFile($fileLama);

            return response()->json(['status' => 'success'], 200);
        } catch (ModelNotFoundException | DecryptException $e) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        } catch (\Exception $e) {
            report($e);
            return response()->json(['message' => 'Gagal menghapus data. Silakan coba lagi.'], 500);
        }
    }
}