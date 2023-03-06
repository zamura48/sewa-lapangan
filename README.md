# Installation
- clone projek ini (git clone https://github.com/zamura48/sewa-lapangan.git)
- jalankan perintah ini di git bash/vscode terminal
```cpenv
cp env .env
```
- jalankan perintah ini di git bash/vscode terminal
```composerupdate
composer update
```
- buat database dengan nama "sewa-lapangan" (atau dengan nama yang lain)
- buka file .env pada projek ini
- hilangkan comment pada bagian database, kemudian isi dengan konfigurasi database (atau bisa mengikuti contoh dibawah ini)
```env
#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------

database.default.hostname = localhost
database.default.database = sewa-lapangan
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306

database.tests.hostname = localhost
database.tests.database = sewa-lapangan
database.tests.username = root
database.tests.password = 
database.tests.DBDriver = MySQLi
database.tests.DBPrefix =
database.tests.port = 3306
```

- jalankan perintah ini di git bash/vscode terminal
```migrate
php spark migrate
```
- jalankan perintah ini di git bash/vscode terminal
```seed
php spark db:seed
```
- setelah menjalankan db:seed, akan muncul seeder name isi dengan UserSeeder