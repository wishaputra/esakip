<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RSUD SERUT</title>
    <link rel="icon" type="image/x-icon" href="https://upload.wikimedia.org/wikipedia/commons/6/6e/Lambang_Kota_Tangerang_Selatan.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <style>
        th, td {
            vertical-align:middle;
            color: white;
            font-size:40px;
        }
        th.bg-custom{
            background-color: #0c9394;
            color: white;
        }
        td.bg-custom{
            background-color: #0c9394;
            color: white;
        }
        td.font-custom{
            font-size:xxx-large;
            color: black;
        }
    </style>
  </head>
  <body>
    <table class="table text-center">
        <thead>
            <tr>
                <th colspan="4" class="bg-custom">Rumah Sakit Umum Daerah<br>Serpong Utara<br>
                    <?php
                        echo date('l,') . date(' d F Y');
                    ?><br>
                    <iframe src="https://free.timeanddate.com/clock/i8j6gq0m/n108/tlid38/fs42/fcfff/tct/pct/ftb/th1" frameborder="0" width="170" height="51" allowtransparency="true"></iframe>
                </th>
                <th colspan="4">
                    <video height="400px" autoplay loop muted>
                        <source src="https://rsudserpongutara.tangerangselatankota.go.id/storage/files/videors.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th colspan="2" class="bg-custom">Rawat Inap</th>
                <th colspan="2" class="bg-info">IGD</th>
                <th colspan="2" class="bg-custom">Maternal</th>
                <th colspan="2" class="bg-info">Persalinan</th>
            </tr>
            <tr>
                @foreach($ranap as $item)
                    <td class="bg-custom font-custom">Total Bed</td><td class="bg-custom font-custom">{{ $item->totalBed }}</td>
                @endforeach
                @foreach($igd as $item)
                    <td class="bg-info font-custom">Total Bed</td><td class="bg-info font-custom">{{ $item->totalBed }}</td>
                @endforeach
                @foreach($maternal as $item)
                    <td class="bg-custom font-custom">Total Bed</td><td class="bg-custom font-custom">{{ $item->totalBed }}</td>
                @endforeach
                @foreach($persalinan as $item)
                    <td class="bg-info font-custom">Total Bed</td><td class="bg-info font-custom">{{ $item->totalBed }}</td>
                @endforeach
            </tr>
            <tr>
                @foreach($ranap as $item)
                    <td class="bg-custom font-custom">Bed Terpakai</td><td class="bg-custom font-custom">{{ $item->bedTerpakai }}</td>
                @endforeach
                @foreach($igd as $item)
                    <td class="bg-info font-custom">Bed Terpakai</td><td class="bg-info font-custom">{{ $item->bedTerpakai }}</td>
                @endforeach
                @foreach($maternal as $item)
                    <td class="bg-custom font-custom">Bed Terpakai</td><td class="bg-custom font-custom">{{ $item->bedTerpakai }}</td>
                @endforeach
                @foreach($persalinan as $item)
                    <td class="bg-info font-custom">Bed Terpakai</td><td class="bg-info font-custom">{{ $item->bedTerpakai }}</td>
                @endforeach
            </tr>
            <tr>
                @foreach($ranap as $item)
                    <td class="bg-custom font-custom">Bed Kosong</td><td class="bg-custom font-custom">{{ $item->totalBed - $item->bedTerpakai }}</td>
                @endforeach
                @foreach($igd as $item)
                    <td class="bg-info font-custom">Bed Kosong</td><td class="bg-info font-custom">{{ $item->totalBed - $item->bedTerpakai }}</td>
                @endforeach
                @foreach($maternal as $item)
                    <td class="bg-custom font-custom">Bed Kosong</td><td class="bg-custom font-custom">{{ $item->totalBed - $item->bedTerpakai }}</td>
                @endforeach
                @foreach($persalinan as $item)
                    <td class="bg-info font-custom">Bed Kosong</td><td class="bg-info font-custom">{{ $item->totalBed - $item->bedTerpakai }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    
  </body>
</html>