@include('dokter.navdokter')
<div class="container">
    <p style="font-size: 30px" class="text-center">List Pemeriksaan</p>
    <table class="table table-striped" style="border:2px solid #dee6ed">
        <thead>
            <tr>
                <th scope="col">Nama</th>
                <th scope="col">Keluhan</th>
                <th scope="col">Pilih Tanggal</th>
                <th scope="col">No Antrian</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listpasien as $item)
                <?php
                // if($item->)
                echo $item->
                ?>
                <tr>
                    <td>{{$item->pasien->nama}}</td>
                    <td>{{$item->keluhan}}</td>
                    <td>
                        <?php
                        if(is_null($item->periksa)){
                            ?>
                            <input type="date">
                            <button class="btn btn-success">Simpan</button>
                            <?php
                        }else{
                            ?>
                            <p>{{$item->periksa->tgl_periksa}}</p>
                            <?php
                        }
                        ?>
                    </td>
                    <td>{{$item->no_antrian}}</td>
                    <td><img src="https://static.thenounproject.com/png/171127-200.png" width="25" style="cursor: pointer"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>

</html>
