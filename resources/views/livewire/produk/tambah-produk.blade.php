<style>
    .btn-simpan {
        background-color: #3B4B7A;
        color: white;
        font-weight: 600;
        padding: 5px 20px 5px 20px;
        box-shadow: 5px 5px 10px rgb(112, 112, 112);
        margin-top: 10px;
        margin-bottom: 30px;
        float: right;
    }

    .btn-simpan:hover {
        background-color: #2C3245;
        color: white;
    }
</style>
<div>
    <h3 class="mb-4"><b>Oke Toys - Tambah Produk</b></h3>
    <form>
        <div class="mb-3">
            <label for="namaProduk" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="namaProduk" autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select class="form-select" id="pilih-kategori" required>
                <option selected disabled value="">Pilih kategori</option>
                <option>Mainan Edukasi</option>
                <option>Kategori 2</option>
                <option>Kategori 3</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="fotoProduk" class="form-label">Foto Produk</label>
            <input type="file" class="form-control" id="fotoProduk" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="hargaModal" class="form-label">Harga Modal</label>
            <input type="number" class="form-control" id="hargaModal" required>
        </div>
        <div class="mb-3">
            <label for="hargaJual" class="form-label">Harga Jual</label>
            <input type="number" class="form-control" id="hargaJual" required>
        </div>
        <button type="submit" class="btn btn-simpan">Simpan</button>
    </form>
</div>
