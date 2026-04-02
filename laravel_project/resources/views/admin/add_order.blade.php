@extends('admin.layout.structure')
@section('content')

<main class="bg-white-medium flex-1 p-3 overflow-hidden">

    <h2 class="text-2xl font-bold mb-4">Add New Order</h2>

    <!-- Buttons -->
    <div class="flex gap-4 mb-6">
        <a href="{{ url('admin/orders') }}" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            📋 Order List
        </a>

        <a href="{{ url('admin/order/add') }}" 
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
            ➕ Add Order
        </a>
    </div>

    <!-- Add Order Box -->
    <div class="bg-white p-6 rounded shadow-lg">

        <form action="{{ url('admin/order/store') }}" method="POST">
            @csrf

            <!-- CUSTOMER DETAILS -->
            <h3 class="text-xl font-semibold mb-3">Customer Details</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                <div>
                    <label class="font-medium">Customer Name</label>
                    <input type="text" name="customer_name" class="w-full p-2 border rounded" required>
                </div>

                <div>
                    <label class="font-medium">Phone</label>
                    <input type="text" name="customer_phone" class="w-full p-2 border rounded" required>
                </div>

                <div>
                    <label class="font-medium">Email</label>
                    <input type="email" name="customer_email" class="w-full p-2 border rounded">
                </div>

                <div>
                    <label class="font-medium">Address</label>
                    <input type="text" name="customer_address" class="w-full p-2 border rounded" required>
                </div>

            </div>

            <hr class="my-6">

            <!-- PRODUCT DETAILS -->
            <h3 class="text-xl font-semibold mb-3">Add Products</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div>
                    <label class="font-medium">Category</label>
                    <select name="category_id" id="category" class="w-full p-2 border rounded">
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-medium">Product</label>
                    <select id="product" class="w-full p-2 border rounded">
                        <option value="">Select Product</option>
                    </select>
                </div>

                <div>
                    <label class="font-medium">Quantity</label>
                    <input type="number" id="qty" value="1" class="w-full p-2 border rounded">
                </div>

            </div>

            <button type="button" id="addProductBtn"
                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded mt-4">
                ➕ Add to List
            </button>

            <!-- ORDER ITEMS TABLE -->
            <div class="mt-6">
                <h3 class="text-xl font-semibold mb-3">Order Items</h3>

                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2">Product</th>
                            <th class="p-2">Qty</th>
                            <th class="p-2">Price</th>
                            <th class="p-2">Total</th>
                            <th class="p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody id="itemTable"></tbody>
                </table>
            </div>

            <div class="text-right mt-4">
                <span class="text-xl font-bold">Grand Total: ₹</span>
                <span id="grandTotal" class="text-xl font-bold">0</span>
            </div>

            <hr class="my-6">

            <!-- PAYMENT -->
            <h3 class="text-xl font-semibold mb-3">Payment</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                <div>
                    <label class="font-medium">Payment Method</label>
                    <select name="payment_method" class="w-full p-2 border rounded">
                        <option value="COD">Cash on Delivery</option>
                        <option value="Online">Online Payment</option>
                    </select>
                </div>

                <div>
                    <label class="font-medium">Order Note</label>
                    <input type="text" name="note" class="w-full p-2 border rounded">
                </div>

            </div>

            <button type="submit" 
                class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded shadow mt-4">
                ✅ Place Order
            </button>

        </form>

    </div>

</main>

<!-- JS -->
<script>
let items = [];
let total = 0;

// LOAD PRODUCTS WHEN CATEGORY CHANGES
document.getElementById('category').addEventListener('change', function () {

    let catId = this.value;

    fetch('/admin/get-products/' + catId)
        .then(res => res.json())
        .then(data => {
            let productSelect = document.getElementById('product');
            productSelect.innerHTML = '<option value="">Select Product</option>';

            data.forEach(p => {
                productSelect.innerHTML += `
                    <option value="${p.id}" data-price="${p.price}">
                        ${p.name}
                    </option>`;
            });
        });
});

// ADD PRODUCT TO TABLE
document.getElementById('addProductBtn').onclick = function () {

    let product = document.getElementById('product');
    let qty = document.getElementById('qty').value;

    if (!product.value) return alert("Select a product first!");

    let name = product.options[product.selectedIndex].text;
    let price = product.options[product.selectedIndex].getAttribute('data-price');
    let totalRow = qty * price;
    let productId = product.value;

    let tr = document.createElement('tr');
    tr.innerHTML = `
        <td class="p-2">
            ${name}
            <input type="hidden" name="product_id[]" value="${productId}">
            <input type="hidden" name="qty[]" value="${qty}">
            <input type="hidden" name="price[]" value="${price}">
        </td>
        <td class="p-2">${qty}</td>
        <td class="p-2">₹${price}</td>
        <td class="p-2">₹${totalRow}</td>
        <td class="p-2"><button type="button" class="text-red-600" onclick="removeRow(this, ${totalRow})">X</button></td>
    `;
    document.getElementById('itemTable').appendChild(tr);

    total += totalRow;
    document.getElementById('grandTotal').innerText = total;
};

function removeRow(btn, rowTotal) {
    btn.closest('tr').remove();
    total -= rowTotal;
    document.getElementById('grandTotal').innerText = total;
}
</script>

@endsection