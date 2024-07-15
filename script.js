document.addEventListener('DOMContentLoaded', () => {
    const productContainer = document.getElementById('product-container');
    const addProductBtn = document.getElementById('add-product-btn');
    const deleteProductBtn = document.getElementById('delete-product-btn');

    // Fetch products from the server
    fetch('product_list.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }

            data.forEach(product => {
                const productItem = document.createElement('div');
                productItem.className = 'product-item';

                productItem.innerHTML = `
                    <input type="checkbox" class="delete-checkbox">
                    <div>${product.sku}</div>
                    <div>${product.name}</div>
                    <div>${product.price} $</div>
                    <div>${product.attribute}</div>
                `;

                productContainer.appendChild(productItem);
            });
        })
        .catch(error => console.error('Error fetching product list:', error));
    
    // Redirect to add product page
    addProductBtn.addEventListener('click', () => {
        window.location.href = 'add_product.html';
    });

    // Mass delete function
    deleteProductBtn.addEventListener('click', () => {
        const checkboxes = document.querySelectorAll('.delete-checkbox:checked');
        const skus = Array.from(checkboxes).map(checkbox => checkbox.nextElementSibling.textContent);

        if (skus.length > 0) {
            fetch('delete_product.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ skus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    console.error('Error deleting products:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
});
