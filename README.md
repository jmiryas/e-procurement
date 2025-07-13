## e-Procurement

API e-Procurement sederhana untuk mengelola proses pengadaan barang dan jasa. API ini dibuat menggunakan Laravel dan menggunakan Laravel Sanctum untuk autentikasi tokennya.

# Endpoint

Berikut adalah endpoint dari API ini:

| #   | Method | Endpoint                   | Deskripsi                                                       |
| --- | ------ | -------------------------- | --------------------------------------------------------------- |
| 1   | POST   | `/api/v1/auth/register`    | Registrasi user                                                 |
| 2   | POST   | `/api/v1/auth/login`       | Login User                                                      |
| 3   | POST   | `/api/v1/vendors/register` | Register vendor berdasarkan user login                          |
| 4   | GET    | `/api/v1/products`         | Menampilkan semua produk yang dimiliki user login               |
| 5   | POST   | `/api/v1/products`         | Menambahkan produk baru                                         |
| 6   | GET    | `/api/v1/products/{id}`    | Menampilkan satu produk yang dimiliki user login berdasarkan ID |
| 7   | PATCH  | `/api/v1/products/{id}`    | Memperbarui produk user login berdasarkan ID                    |
| 8   | DELETE | `/api/v1/products/{id}`    | Menghapus produk user login berdasarkan ID                      |

# Log

Secara otomatis, setiap request dan response yang ada di API ini akan disimpan pada folder `storage/logs/api`. Berikut adalah sample log request dan response nya:

```log
[2025-07-13 15:30:43] [REQUEST] {
    "method": "GET",
    "url": "http://127.0.0.1:8000/api/v1/products",
    "headers": {
        "authorization": "Bearer 4|Cx2XH7kBJdMbsfZoZv8aOFtqAN9tkOtzFLjJSHZp04b01035"
    },
    "body": []
}

[2025-07-13 15:30:43] [RESPONSE] {
    "status": 200,
    "headers": {
        "content-type": "application/json"
    },
    "body": {
        "success": true,
        "message": "Produk berhasil didapatkan",
        "data": [
            {
                "id": 2,
                "vendorId": 1,
                "unit": "pcs",
                "name": "Le Minerale 600ml",
                "qty": 5,
                "price": 3000,
                "createdAt": "2025-07-13T07:18:07.000000Z"
            },
            {
                "id": 1,
                "vendorId": 1,
                "unit": "box",
                "name": "Vit 600ml",
                "qty": 5,
                "price": 3500,
                "createdAt": "2025-07-13T07:17:56.000000Z"
            }
        ]
    }
}
```
