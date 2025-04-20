# TP7DPBO2025C1


## Janji  
Saya **A Bintang Iftitah FJ** dengan NIM **2305995** mengerjakan soal TP 7 dalam mata kuliah **Desain dan Pemrograman Berorientasi Objek** untuk keberkahanNya, maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

---

## ERD Diagram
![image](https://github.com/user-attachments/assets/13473d5d-64b5-43ec-9e13-8997b5b219f2)

Ref: bus.id_agen > agen_bus.id_agen
Ref: jadwal.id_bus > bus.id_bus
Ref: jadwal.id_terminal_asal > terminal.id_terminal
Ref: jadwal.id_terminal_tujuan > terminal.id_terminal
Ref: pembelian.id_user > users.id_user
Ref: pembelian.id_jadwal > jadwal.id_jadwal
Ref: kursi.id_jadwal > jadwal.id_jadwal
Ref: pembayaran.id_pembelian > pembelian.id_pembelian


##  Kelas

### 1. `AgenBus`

### 2. `Bus`

### 3. `crud_interface`

### 4. `Jadwal`

### 5. `Kursi`

### 6. 'Pembayaran'

### 7. 'Pembelian'

### 8. 'Terminal'

### 9. 'User'

---

## Alur Program

1. Program dimulai dari `Index.php`
2. User dapat click tombol schedule, agen bus, daftar terminal serta admin panel
3. Crud page berada di dalam admin panel 
4. Di dalam crud page terdapat action crud serta daftar isi tabel yang sudah tersedia 
5. Terdapat message jika sudah menambahkan data atau alert confirmation ketika ingin delete 
6. Untuk pembelian, pembayaran dan kursi tidak dapat di crud tanpa login sehingga pada simulasi ini untuk crud tidak dilakukan pada semua kelas nya , namun desain tetap mengikuti desain erd 
7. Database di simpan dalam tipe sql di php my admin


---

## Penjelasan Fitur

- ✅ Tampilan Menu pada index
- ✅ Action Crud


---

## Dokumentasi
![tp8](https://github.com/user-attachments/assets/df0adb3c-6aaa-4aa1-a059-233514356a6c)
![landingPage](https://github.com/user-attachments/assets/2062cd5c-dd14-4f3a-b3d1-3b12f3e714b0)
![db_my_admin](https://github.com/user-attachments/assets/a2c44288-4cd3-499c-a43d-fb4e4a20d266)




