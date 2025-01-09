<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        background: '#111111',
                        foreground: '#161616',
                        primary: '#34e24d',
                        hover: '#091930'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-background text-white">
    <div class="container mx-auto px-5 py-10">
        <h1 class="text-3xl font-bold mb-5">Keranjang Belanja</h1>

        <!-- Cart Items -->
        <div id="cart-items" class="space-y-5"></div>

        <!-- Total Price -->
        <div id="cart-total" class="mt-5 text-right text-lg font-bold"></div>

        <!-- Empty Cart Message -->
        <div id="empty-cart-message" class="text-center text-gray-400 mt-10 hidden">
            Keranjang belanja Anda kosong.
        </div>

        <!-- Order Form -->
        <form action="/backend/cart_logic.php" method="POST" class="mt-10">
            <div class="mb-4">
                <label for="name" class="block text-lg font-bold">Nama Lengkap</label>
                <input type="text" id="name" name="name" required class="mt-2 p-2 w-full bg-foreground border border-primary rounded">
            </div>
            <div class="mb-4">
                <label for="address" class="block text-lg font-bold">Alamat</label>
                <textarea id="address" name="address" required class="mt-2 p-2 w-full bg-foreground border border-primary rounded"></textarea>
            </div>
            <input type="hidden" id="order_id" name="order_id">
            <button type="submit" class="px-5 py-2 bg-primary text-white rounded font-bold hover:bg-green-500 duration-300">Pesan Sekarang</button>
        </form>
    </div>

    <script>
        function displayCartItems() {
            const cartItemsContainer = document.getElementById('cart-items');
            const cartTotalContainer = document.getElementById('cart-total');
            const emptyCartMessage = document.getElementById('empty-cart-message');
            const cart = JSON.parse(localStorage.getItem('cart')) || [];

            cartItemsContainer.innerHTML = '';
            cartTotalContainer.textContent = '';

            if (cart.length === 0) {
                emptyCartMessage.classList.remove('hidden');
                return;
            }

            emptyCartMessage.classList.add('hidden');

            const groupedCart = cart.reduce((acc, item) => {
                const existingItem = acc.find((i) => i.namaBarang === item.namaBarang);
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    acc.push({ ...item, quantity: 1 });
                }
                return acc;
            }, []);

            let totalPrice = 0;

            groupedCart.forEach((item) => {
                const itemTotalPrice = item.hargaJual * item.quantity;
                totalPrice += itemTotalPrice;

                const itemElement = document.createElement('div');
                itemElement.className = 'flex items-center justify-between bg-foreground p-4 rounded shadow';
                itemElement.innerHTML = `
                    <div class="flex items-center gap-4">
                        <img src="${item.foto}" alt="${item.namaBarang}" class="w-16 h-16 object-cover rounded">
                        <div>
                            <p class="font-bold">${item.namaBarang}</p>
                            <p class="text-primary">Rp ${item.hargaJual.toLocaleString('id-ID')} x ${item.quantity}</p>
                            <p>Total: Rp ${itemTotalPrice.toLocaleString('id-ID')}</p>
                        </div>
                    </div>
                `;
                cartItemsContainer.appendChild(itemElement);
            });

            cartTotalContainer.textContent = `Total: Rp ${totalPrice.toLocaleString('id-ID')}`;
            setOrderId();
        }

        function setOrderId() {
            const orderIdField = document.getElementById('order_id');
            const randomNumber = Math.floor(Math.random() * 1000000);
            const orderId = 'RCF' + randomNumber;
            orderIdField.value = orderId;
        }

        document.addEventListener('DOMContentLoaded', displayCartItems);
    </script>
</body>

</html>
