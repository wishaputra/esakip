<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Tujuan;
use App\Models\Cascading\Model_Sasaran;
use App\Models\Cascading\Model_Tujuan_Renstra;
use App\Models\Cascading\Model_Sasaran_Renstra;
use App\Models\Cascading\Model_Program;
use App\Models\Cascading\Model_Kegiatan;
use App\Models\Cascading\Model_SubKegiatan;

class ChartController extends Controller
{


    
    public function loadChart()
{
    
    // Fetch data from the Model_Visi
    $visiNodes = Model_Visi::all()->map(function($visi) {
        return [
            'key' => 'visi' . $visi->id, // Prefix the id with 'visi' to make it unique
            'visi' => $visi->visi,
            'tahun_awal' => $visi->tahun_awal,
            'tahun_akhir' => $visi->tahun_akhir,
            // Add other necessary fields here
        ];
    });

    // Fetch data from the Model_Misi
    $misiNodes = Model_Misi::all()->map(function($misi) {
        return [
            'key' => 'misi' . $misi->id, // Prefix the id with 'misi' to make it unique
            'misi' => $misi->misi,
            'parent' => 'visi' . $misi->id_visi, // Assign the 'parent' property to link with the visi node
            // Add other necessary fields here
        ];
    });

    // Fetch data from the Model_Tujuan
    $tujuanNodes = Model_Tujuan::all()->map(function($tujuan) {
        return [
            'key' => 'tujuan' . $tujuan->id, // Prefix the id with 'tujuan' to make it unique
            'tujuan' => $tujuan->tujuan,
            'parent' => 'misi' . $tujuan->id_misi, // Assign the 'parent' property to link with the misi node
            // Add other necessary fields here
        ];
    });

    $sasaranNodes = Model_Sasaran::all()->map(function($sasaran) {
        return [
            'key' => 'sasaran' . $sasaran->id, // Prefix the id with 'sasaran' to make it unique
            'sasaran' => $sasaran->sasaran,
            'parent' => 'tujuan' . $sasaran->id_tujuan, // Assign the 'parent' property to link with the tujuan node
            // Add other necessary fields here
        ];
    });

    $tujuanRenstraNodes = Model_Tujuan_Renstra::all()->map(function($tujuanRenstra) {
        return [
            'key' => 'tujuanRenstra' . $tujuanRenstra->id, // Prefix the id with 'tujuanRenstra' to make it unique
            'tujuanRenstra' => $tujuanRenstra->tujuan_renstra,
            'parent' => 'sasaran' . $tujuanRenstra->id_sasaran, // Assign the 'parent' property to link with the sasaran node
            // Add other necessary fields here
        ];
    });

    $sasaranRenstraNodes = Model_Sasaran_Renstra::all()->map(function($sasaranRenstra) {
        return [
            'key' => 'sasaranRenstra' . $sasaranRenstra->id, // Prefix id with 'sasaranRenstra' to make it unique
            'sasaranRenstra' => $sasaranRenstra->sasaran_renstra,
            'parent' => 'tujuanRenstra' . $sasaranRenstra->id_tujuan_renstra, // Assign the 'parent' property to link with the tujuanRenstra node
            // Add other necessary fields here
        ];
    });

    $programNodes = Model_Program::all()->map(function($program) {
        return [
            'key' => 'program' . $program->id, // Prefix id with 'program' to make it unique
            'program' => $program->program,
            'parent' => 'sasaranRenstra' . $program->id_sasaran_renstra, // Assign the 'parent' property to link with the sasaranRenstra node
            // Add other necessary fields here
        ];
    });
    
    $kegiatanNodes = Model_Kegiatan::all()->map(function($kegiatan) {
        return [
            'key' => 'kegiatan' . $kegiatan->id, // Prefix id with 'kegiatan' to make it unique
            'kegiatan' => $kegiatan->kegiatan,
            'parent' => 'program' . $kegiatan->id_program, // Assign the 'parent' property to link with the program node
            // Add other necessary fields here
        ];
    });

    $subkegiatanNodes = Model_SubKegiatan::all()->map(function($sub_kegiatan) {
        return [
            'key' => 'subkegiatan' . $sub_kegiatan->id, // Prefix id with 'subkegiatan' to make it unique
            'sub_kegiatan' => $sub_kegiatan->sub_kegiatan,
            'parent' => 'kegiatan' . $sub_kegiatan->id_kegiatan, // Assign the 'parent' property to link with the kegiatan node
            // Add other necessary fields here
        ];
    });

    // Create links from each visi node to its misi nodes
    $visiToMisiLinks = $misiNodes->map(function($misi) {
        return [
            'from' => $misi['parent'],
            'to' => $misi['key'],
        ];
    });

    // Create links from each misi node to its tujuan nodes
    $misiToTujuanLinks = $tujuanNodes->map(function($tujuan) {
        return [
            'from' => $tujuan['parent'],
            'to' => $tujuan['key'],
        ];
    });

    $tujuanToSasaranLinks = $sasaranNodes->map(function($sasaran) {
        return [
            'from' => $sasaran['parent'],
            'to' => $sasaran['key'],
        ];
    });

    $sasaranToTujuanRenstraLinks = $tujuanRenstraNodes->map(function($tujuanRenstra) {
        return [
            'from' => $tujuanRenstra['parent'],
            'to' => $tujuanRenstra['key'],
        ];
    });

    $tujuanRenstraToSasaranRenstraLinks = $sasaranRenstraNodes->map(function($sasaranRenstra) {
        return [
            'from' => $sasaranRenstra['parent'],
            'to' => $sasaranRenstra['key'],
        ];
    });

    $sasaranRenstraToProgramLinks = $programNodes->map(function($program) {
        return [
            'from' => $program['parent'],
            'to' => $program['key'],
        ];
    });

    $programToKegiatanLinks = $kegiatanNodes->map(function($kegiatan) {
        return [
            'from' => $kegiatan['parent'],
            'to' => $kegiatan['key'],
        ];
    });

    $kegiatanToSubKegiatanLinks = $subkegiatanNodes->map(function($sub_kegiatan) {
        return [
            'from' => $sub_kegiatan['parent'],
            'to' => $sub_kegiatan['key'],
        ];
    });

    // Merge the visi nodes, misi nodes, and tujuan nodes into one array
    $nodes = $visiNodes->concat($misiNodes)->concat($tujuanNodes)->concat($sasaranNodes)->concat($tujuanRenstraNodes)->concat($sasaranRenstraNodes)->concat($programNodes)->concat($kegiatanNodes)->concat($subkegiatanNodes);

    // Merge all links into one array
    $links = $visiToMisiLinks->concat($misiToTujuanLinks)->concat($tujuanToSasaranLinks)->concat($sasaranToTujuanRenstraLinks)->concat($tujuanRenstraToSasaranRenstraLinks)->concat($sasaranRenstraToProgramLinks)->concat($programToKegiatanLinks)->concat($kegiatanToSubKegiatanLinks);   

    // Example response structure expected by GoJS
    $response = [
        'nodeDataArray' => $nodes->toArray(),
        'linkDataArray' => $links->toArray(),
    ];

    return response()->json($response);
}
}